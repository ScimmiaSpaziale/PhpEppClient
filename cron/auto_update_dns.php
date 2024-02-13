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

 function count_bulk_ns(){
  DbSelect("SELECT COUNT(*) AS CNT FROM queue_bulk_ns WHERE tld LIKE '.IT' AND status=0",$rs);
  if (NextRecord($rs,$r)) return $r[CNT]; else return 0;
 }

 function set_bulk_ns_operation_send($ID){
  DbQuery("UPDATE queue_bulk_ns SET status=1 WHERE id=$ID");
 }

 function set_bulk_ns_operation_failed($ID){
  DbQuery("UPDATE queue_bulk_ns SET status=5 WHERE id=$ID");
 }

 function delete_bulk_ns_operation($ID){
  DbQuery("DELETE FROM queue_bulk_ns WHERE id=$ID");
 }

 function get_main_iddomain($DOMAIN) {
  DbSelect("SELECT * FROM t_payservice_domains WHERE domain LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) return $r[iddomain]; else return 0;
 }

 function update_main_panel($DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6){
  $IDDOMAIN=get_main_iddomain($DOMAIN);
  DbQuery("
   UPDATE t_payservice_nsservers SET
    ns1='$NS1', ns2='$NS2', ns3='$NS3', ns4='$NS4', ns5='$NS5'
     WHERE iddomain=$IDDOMAIN
  ");
 }

 ConnectDB();
  session_start();
  $CNT=count_bulk_ns();
  echo "Domini da aggiornare: <b>$CNT</b> <br>";
  if ($CNT<=0) {
   DisconnectDB();
   die();
  }
  $ID_ADMIN=1; $ID_UTENTE=1;
  eppOpenConnection($eppsock);

  ###################################################
  # Login EPP Server                                #
  ###################################################

  $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE!=1000) {
   echo "$LANGUAGE[508]<br>";  die();
  } else {
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

  ###################################################
  # Aggiornamento Domini in status 12 e 14
  ###################################################

  DbSelect("SELECT * FROM queue_bulk_ns WHERE (status=0) AND (tld LIKE '.IT') ORDER BY id ASC LIMIT 0,5",$rs);
  while (NextRecord($rs,$r)) {
   $idop=$r[id];
   $DOMAIN=$r[domain];
   $NS1=$r[ns1]; $NS2=$r[ns2]; $NS3=$r[ns3]; $NS4=$r[ns4]; $NS5=$r[ns5]; $NS6=$r[ns6];
   $IP1=""; $IP2=""; $IP3=""; $IP4=""; $IP5=""; $IP6="";
   $IDD=get_domain_iddomain($DOMAIN);
   get_domain_dnsinfo($IDD, $OLD_NS1, $OLD_NS2, $OLD_NS3, $OLD_NS4, $OLD_NS5, $OLD_NS6, $OLD_IP1, $OLD_IP2, $OLD_IP3, $OLD_IP4, $OLD_IP5, $OLD_IP6);

   $xml=epp_domain_info($eppsock, $DOMAIN);
   $RESCODE=xml_get_resultcode($xml); $REASONCODE=xml_get_reasoncode($xml);
   xml_get_domain_info_ns($xml,$OLD_NS1,$OLD_NS2,$OLD_NS3,$OLD_NS4,$OLD_NS5,$OLD_NS6);

   del_domain_dns($IDD); add_domain_dns($IDD,$NS1,$NS2,$NS3,$NS4,$NS5,$NS6,$IP1,$IP2,$IP3,$IP4,$IP5,$IP6);
   nameserver_queue_domain_update($IDD);

   echo "$LANGUAGE[546] $OLD_NS1,$OLD_NS2,$OLD_NS3,$OLD_NS4,$OLD_NS5,$OLD_NS6 <br>";
   $xml=epp_update_nameservers($eppsock, $DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $OLD_NS1, $OLD_NS2, $OLD_NS3, $OLD_NS4, $OLD_NS5, $OLD_NS6, TRUE);

   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);

   if ($RESCODE==1000) {
    echo "$LANGUAGE[501] <b>$DOMAIN</b> <br><br>";
    webpanel_logs_add("EppProto","$LANGUAGE[502] $DOMAIN.");
    update_domain_updating($IDD);
    update_main_panel($DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6);
    set_bulk_ns_operation_send($idop);
   } else if ($RESCODE==1001) {
    echo "$LANGUAGE[501] <b>$DOMAIN</b> <br><br>";
    webpanel_logs_add("EppProto","$LANGUAGE[503] $DOMAIN.");
    update_domain_updating($IDD);
    update_main_panel($DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6);
    set_bulk_ns_operation_send($idop);
   } else {
    webpanel_logs_add("EppProto","$LANGUAGE[504] $DOMAIN, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
    set_bulk_ns_operation_failed($idop);
   }

  } 

  ###################################################
  # Logout EPP Server                               #
  ###################################################

  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

 DisconnectDB();
?>