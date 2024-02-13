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

 ########################################################################
 # 0 - Massimo messaggi. 
 # 1 - Minimi messaggi. 
 # 2 - Zero messaggi. 
 ########################################################################
 $DEBUG_LEVEL=0;   
 $DEBUG_ENDLINE="<br>"; // Mettere /n per Shell/CMD.
 ########################################################################

 set_time_limit(0);
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
  $ID_ADMIN=1; $ID_UTENTE=1;
  eppOpenConnection($eppsock);

  ###################################################
  # Login EPP Server                                #
  ###################################################
  
  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 0] Inizio Login EPP ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE!=1000) {
   echo "$LANGUAGE[508]$DEBUG_ENDLINE";  die();
  } else {
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  $CRD=0;
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);
  echo "[Blocco 0] Operazione di Login EPP eseguita ... $DEBUG_ENDLINE";

  ###################################################
  # Aggiornamento Domini in status 12 e 14
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 1] Aggiornamento domini in status 12, 13, 14, 15 ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  DbSelect("SELECT * FROM domain_names WHERE (status>=12) AND (status<=15) ORDER BY idd ASC",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r['idd']; $IDD=$ID;
   get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
   //$DOMAIN=utf_encode($DOMAIN);
   $xml=epp_domain_info($eppsock, $DOMAIN);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE!=1000) {
    echo "[<b>$DOMAIN</b>] $LANGUAGE[566] $LANGUAGE[250]:$RESCODE, $LANGUAGE[251]:$REASONCODE.$DEBUG_ENDLINE";
    if ($RESCODE==2005) {
     del_domain_dns($IDD);
     del_domain_name($IDD);
     del_domain_flags($IDD);
     del_domain_status($IDD);
    }
    if (($RESCODE==2202)&&($REASONCODE==9085)) {
     del_domain_dns($IDD);
     del_domain_name($IDD);
     del_domain_flags($IDD);
     del_domain_status($IDD);
    } 
   } else {
    echo "[<b>$DOMAIN</b>] $LANGUAGE[380] $DEBUG_ENDLINE";
    xml_update_domain_info($IDD,$xml);
   }
  }
  if ($DEBUG_LEVEL<2) echo "[Blocco 1] Fine aggiornamento. $DEBUG_ENDLINE";

  ###################################################
  # Aggiornamento Contatti domini da status 12 e 14
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 2] Aggiornamento contatti dei domini da status 12, 13, 14, 15 ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  $ID=get_imported_contact($CID); $IDC=$ID;
  while ($ID>0) {
   echo "Checking Contact [$CID] $DEBUG_ENDLINE";
   $xml=epp_contact_info($eppsock,$CID);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE!=1000) {
    print_epp_error($RESCODE,$REASONCODE);
    echo "$DEBUG_ENDLINE";
    webpanel_delete_contact($IDC);
   } else {
    echo "[$IDC] $LANGUAGE[380] $DEBUG_ENDLINE";
    xml_update_contact_info($IDC,$xml);
   }
   $ID=get_imported_contact($CID); $IDC=$ID;
  }
  if ($DEBUG_LEVEL<2) echo "[Blocco 2] Fine aggiornamento.  $DEBUG_ENDLINE";

  ###################################################
  # Controllo e download della coda di Polling
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 3] Controllo e download della coda di polling ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  $CLCNT=0;
  $EMPTY_QUEUE=FALSE;
  while (!$EMPTY_QUEUE) { 

   $QT=0; 
   $xml=epp_polling_request($eppsock);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE==1301) {
    xml_domain_polling_msg($xml,$QT,$IDMSG,$DATA,$MSGTITLE,$DOMAIN);
    $xmldeq="";
    $OPCODE=0;
    polling_msg_add($IDMSG,$QT,$DATA,$MSGTITLE,$xml,$xmldeq,$DOMAIN,$OPCODE);
    echo " $LANGUAGE[511] $DEBUG_ENDLINE"; 
   } else {
    if ($RESCODE==1300) echo "La coda risulta senza messaggi. $DEBUG_ENDLINE";
     else echo "Errore nel download della coda di polling: ResCode $RESCODE, Reason $REASONCODE $DEBUG_ENDLINE";
   }

   #######################
   # DeQueue EPP Server  #
   #######################

   if ($QT>0) {
    $CLCNT++;
    echo "[Blocco 3.$CLCNT] Inizio pulizia della coda di polling ... $DEBUG_ENDLINE";
    echo "$LANGUAGE[512] $DEBUG_ENDLINE"; 
    $IDP=get_id_polling($IDMSG);
    $CODE=$IDMSG; 
    $xml=epp_polling_ack($eppsock,$CODE);
    $RESCODE=xml_get_resultcode($xml);
    $REASONCODE=xml_get_reasoncode($xml);
    if ($RESCODE!=1000) {
     webpanel_logs_add("EppProto","$LANGUAGE[514] $CODE.");
    } else {
     echo " ($QT) $LANGUAGE[515] $DEBUG_ENDLINE"; 
     webpanel_logs_add("EppProto","$LANGUAGE[517] $CODE.");
     polling_set_status($IDP,"Deleted");
     $xmldeq=$xml;
     $DOMAIN="";
     $OPCODE=0;
     polling_msg_upd($IDP,$xmldeq,$DOMAIN,$OPCODE);
     polling_msg_upd_xmldeq($IDP,$xmldeq);
    }
    echo "[Blocco 3.$CLCNT] Fine pulizia della coda di polling ... $DEBUG_ENDLINE";
   } else {
    $EMPTY_QUEUE=TRUE;
   }
  }
  if ($DEBUG_LEVEL<2) echo "[Blocco 3] Fine controllo della coda di polling ... $DEBUG_ENDLINE";

  ###################################################
  # Aggiornamento Operazione dai Codici Operativi   #
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 4] Esecuzione ed aggiornamento dei codici operativi ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  webpanel_polling_list_execute_opcodes();
  if ($DEBUG_LEVEL<2) echo "[Blocco 4] Fine esecuzioni operazioni di aggiornamento ed eventi automatici ... $DEBUG_ENDLINE";

  ###################################################
  # Aggiornamento Name Server Trasferimenti         #
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 5] Aggiornamento Name Server, dopo Trasferimenti ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  webpanel_check_queued_ns_update($eppsock);
  if ($DEBUG_LEVEL<2) echo "[Blocco 5] Fine aggiornamento Name Server dopo Trasferimenti ... $DEBUG_ENDLINE";

  ###################################################
  # Logout EPP Server                               #
  ###################################################

  if ($DEBUG_LEVEL<2) {
   echo "
    <hr>
    ################################################### $DEBUG_ENDLINE
    [Blocco 6] Inizio Logout EPP ... $DEBUG_ENDLINE
    ################################################### $DEBUG_ENDLINE
   ";
  } 

  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

  if ($DEBUG_LEVEL<2) echo "[Blocco 6] Fine Logout EPP ... $DEBUG_ENDLINE";

  if ($DEBUG_LEVEL<2) echo "$DEBUG_ENDLINE<a href=\"../admin_domini.php\">$LANGUAGE[416]</a>$DEBUG_ENDLINE";
 DisconnectDB();
?>