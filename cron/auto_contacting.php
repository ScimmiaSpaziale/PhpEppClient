<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 0.9                                     #
 # Useful Functions and Tools for EPP Registrar Operations              #
 #                                                                      #
 # Copyright (C) 2009 - 2010 by Giovanni Ceglia                         #
 #                                                                      #
 # This file is part of "EPP Ceglia Tools".                             #
 #                                                                      #
 # "EPP Ceglia Tools" is free software: you can redistribute it and/or  #
 # modify it under the terms of the GNU General Public License as       # 
 # published by the Free Software Foundation, either version 3 of the   #
 # License, or (at your option) any later version.                      #
 #                                                                      #
 # This program is distributed in the hope that it will be useful,      #
 # but WITHOUT ANY WARRANTY; without even the implied warranty of       # 
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         #
 # GNU General Public License for more details.                         #
 #                                                                      #
 # You should have received a copy of the GNU General Public License    #
 # along with this program. If not, see <http://www.gnu.org/licenses/>. #
 #                                                                      #
 ########################################################################

 ########################################################################
 #                                                                      #
 # This software is available at http://www.giovanniceglia.com          #
 # Comments and suggestions: http://www.giovanniceglia.com              #
 #                                                                      #
 # All contact info to contact Ceglia Giovanni can be found on:         # 
 # http://www.ceglia.tel, you can also write:                           #
 # giovanni.ceglia@frazionabile.it or giovanniceglia@xungame.com              #
 #                                                                      #
 ########################################################################

 include("../conf/config.inc.php");
 include("../lang/language.it.php");
 include("../conf/webpanel.db.php");
 include("../libs/webpanel.database.php");
 include("../libs/webpanel.interface.php");
 include("../libs/webpanel.login.php");
 include("../libs/webpanel.functions.php");
 include("../libs/xmlutility.inc.php");
 include("../libs/epplibrary.inc.php");
 include("../libs/eppcommands.inc.php");
 include("../libs/epphtml.inc.php");
 ConnectDB();
  $ID_ADMIN=1;

  #######################
  # Login EPP Server    #
  #######################

  eppOpenConnection($eppsock);
  $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE!=1000) {
   eppCloseConnection($eppsock);
   die();
  } else {
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

  #######################
  # Checking Contacts   #
  #######################

  $ID=get_contact_waiting(0);
  $IDC=$ID;
  $CID=get_extended_id($ID);

  if ($ID>0) {
 
   $PW="";
   get_contact_info(
    $ID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $SEX
   );

   eppOpenConnection($eppsock);
   $xml=epp_create_registrant(
    $eppsock, $CID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CF, $PW
   );
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   eppCloseConnection($eppsock); 

   if ($RESCODE==1000) {
    echo "$LANGUAGE[470] <b>$CID</b> <br><br>";
    webpanel_logs_add("Security","$LANGUAGE[470] $CID.");
    update_contact_status($IDC,"Active");
   } else {
    webpanel_logs_add("Security","$LANGUAGE[469] $CID, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
    update_contact_status($IDC,"Errors");
   }

   print_debug_info($xml,"createcontact",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
   echo "<br><a href=\"../admin_utenti.php\">$LANGUAGE[416]</a><br>";
  }
 
  #######################
  # Logout EPP Server   #
  #######################

  eppOpenConnection($eppsock);
  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

 DisconnectDB();
?>