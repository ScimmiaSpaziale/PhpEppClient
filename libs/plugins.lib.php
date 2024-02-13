<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 1.6                                     #
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

 ########################################################################
 # Funzioni aggiunte 12/11/2010.
 ########################################################################

 function find_id_bill(){
  $IDBILL="";
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=1",$rs);
  if (NextRecord($rs,$r)) { $IDBILL=$r['idbill']; }
  return $IDBILL;
 } 

 function find_id_tech(){
  $IDTECH="";
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=1",$rs);
  if (NextRecord($rs,$r)) { $IDTECH=$r['idtech']; }
  return $IDTECH;
 } 

 function find_id_registrant($TAXCODE){
  $IDREG="";
  DBSelect("SELECT * FROM domain_contacts WHERE (vatcode LIKE '$TAXCODE') OR (fiscalcode LIKE '$TAXCODE')",$rs);
  if (NextRecord($rs,$r)) { $IDREG=$r['contact_id']; }
  return $IDREG;
 }

 function find_id_admin($TAXCODE){
  $IDADM="";
  DBSelect("SELECT * FROM domain_contacts WHERE (vatcode LIKE '$TAXCODE') OR (fiscalcode LIKE '$TAXCODE')",$rs);
  if (NextRecord($rs,$r)) { $IDADM=$r['contact_id']; }
  return $IDADM;
 }

 function EppExternalCmsOpenConnection(&$eppsock,$IDADMIN,$CMSNAME){
  webpanel_logs_add("EppProto","[IDA:$IDADMIN] $CMSNAME Tcp Connection.");
  eppOpenConnectionUser($eppsock,$IDADMIN);
  return $ID_EPPSESSION;
 }

 function EppExternalCmsCloseConnection(&$eppsock,$IDADMIN,$CMSNAME){
  eppCloseConnection($eppsock);
  webpanel_logs_add("EppProto","[IDA:$IDADMIN] $CMSNAME Tcp Closed. <br>");
 }

 ########################################################################
 # Funzioni aggiunte 26/07/2010.
 ########################################################################

 function RefreshEPPSession(){
  $T=time();
  DbQuery("UPDATE epp_sessions SET updated='$T' WHERE status='Open'");
  DbQuery("UPDATE epp_psessions SET updated='$T' WHERE status='Open'");
 }

 ########################################################################
 # Funzioni aggiunte 26/07/2010.
 ########################################################################

 function MultiUserNewLogin(&$eppsock,$ID_ADMIN,$CMSNAME){
  $xml=epp_login_db_account($eppsock,$ID_ADMIN);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  $OPENED_SESSION=(($RESCODE==2002)&&($REASONCODE==4014));
  if (($RESCODE!=1000)&&(!$OPENED_SESSION)) {
   print_epp_error($RESCODE,$REASONCODE);
   eppCloseConnection($eppsock);
   die();
  } else {
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);
  webpanel_logs_add("EppProto","[IDA:$ID_ADMIN] $CMSNAME Epp Connected: $SESSIONID");
  print_debug_info($xml,"debugform",120,40,$RESCODE,$REASONCODE,$SESSIONID);
 }

 function MultiUserNewLogout(&$eppsock,$ID_ADMIN,$CMSNAME){
  global $epp_clTRID;
  $IDEPP=admin_eppsession($ID_ADMIN);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);
  $xml=eppReadXMLScheme("logout");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);
  webpanel_logs_add("EppProto","[IDA:$ID_ADMIN] $CMSNAME Epp Closed: $ID_EPPSESSION");
 }

?>