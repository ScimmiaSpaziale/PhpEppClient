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
  session_start();
  $ID_UTENTE=admin_protection();
  $ID_EPPSESSION=admin_eppsession_protection($ID_UTENTE);

  $ID=validate_unsigned($_GET[id]);
  $IDC=$ID;
  $CID=get_extended_id($ID);
  $TEL=validate_string($_POST['tel']);
  $FAX=validate_string($_POST['fax']);
  $PUB=validate_string($_POST['pubblish']);
  if ($PUB=="True") $PUBFLAG=1; else $PUBFLAG=0;
  $ADDRESS=validate_string($_POST['address']);
  $CITY=validate_string($_POST['city']);
  $PROV=validate_string($_POST['province']);
  $COUNTRY=validate_string($_POST['country']);
  $ZIP=validate_string($_POST['zipcode']);
  $EMAIL=validate_string($_POST['email']);

  $IDEPP=admin_eppsession($ID_UTENTE);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  eppOpenConnection($eppsock);
  $xml=epp_contact_update_nofee($eppsock, $CID, $TEL, $FAX, $PUBFLAG, $ADDRESS, $ZIP, $CITY, $PROV, $COUNTRY, $EMAIL);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  eppCloseConnection($eppsock);

  if ($RESCODE==1000) {
   echo "$LANGUAGE[487] <b>$CID</b> <br><br>";
   webpanel_logs_add("EppProto","$LANGUAGE[487] $CID.");
   update_contact_tel($ID,$TEL);
   update_contact_fax($ID,$FAX);
   update_contact_privacy($ID,$PUB);
   update_contact_address($ID,$ADDRESS,$ZIP,$CITY,$PROV,$COUNTRY,$EMAIL);
  } else {
   webpanel_logs_add("EppProto","$LANGUAGE[488] $CID, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
  }

  print_debug_info($xml,"contactform",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
  echo "<br><a href=\"../admin_utenti.php\">$LANGUAGE[416]</a><br>";

 DisconnectDB();
?>