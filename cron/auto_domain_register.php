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
 # giovanni.ceglia@gmail.com or giovanniceglia@xungame.com              #
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

 $DDOMAIN=$_GET['d'];
 $IDD=get_domain_iddomain($DDOMAIN);

 echo "<br> Registering: [$IDD] $DDOMAIN <br><br>";

 if ($IDD!=0){
  $ID_ADMIN=1;
  $ID_EPPSESSION=admin_eppsession_protection($ID_ADMIN);
  $IDEPP=admin_eppsession($ID_ADMIN);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  $ID=$IDD;
  if ($ID==0) { die(); }
  $YEARS=1;
  get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($ID, $NS1, $NS2, $IP1, $IP2);
  
  eppOpenConnection($eppsock);
  $xml=epp_create_domain($eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $IDREG, $IDADM, $IDTECH, $EPPCODE);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  eppCloseConnection($eppsock);

  if ($RESCODE==1000) {
   webpanel_logs_add("EppProto","Dominio creato con successo: $DOMAIN.");
   update_domain_status($ID,1);
  } else {
   webpanel_logs_add("EppProto","Creazione dominio fallita: $DOMAIN, Result Code: $RESCODE, Reason: $REASONCODE.");
  }

  $DEBUG=FALSE;
  if ($DEBUG) {
   echo "Sessione: $ID_EPPSESSION <br>";
   echo "Domain: $DOMAIN <br>";
   echo "ResCode: $RESCODE <br>";
   echo "ReasonCode: $REASONCODE <br>";
   echo "<br><br>"; 
   print_xml_textarea($xml,"domform",120,20);
   echo "<br><br>"; 
  }

  if (($RESCODE==2308)&&($REASONCODE==9083)) {
   //update_domain_status($ID,10);
  }
 }

 if (($RESCODE==2002)&&($REASONCODE==4015)) {
  $ID_ADMIN=1;
  $IDES=4;
  $IDEPP=admin_eppsession($ID_ADMIN);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  if ($ID_EPPSESSION!="") {
   epp_SelectSession($ID_EPPSESSION);
   eppOpenConnection($eppsock);
   $xml=eppReadXMLScheme("logout");
   xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
   eppSendCommand($eppsock,$xml);
   $xml=eppGetFrame($eppsock);
   eppCloseConnection($eppsock);
   $CRD=xml_get_credit($xml);
   webpanel_closeepp($ID_ADMIN,$CRD);
  }
  eppOpenConnection($eppsock);
  $xml=epp_login_db_account($eppsock);
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
 }

 DisconnectDB();
?>