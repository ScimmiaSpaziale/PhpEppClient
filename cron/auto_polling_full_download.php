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
 include("../lang/polling.opcodes.php");
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

  echo "$LANGUAGE[507] <br>"; 
  eppOpenConnection($eppsock);
  $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE!=1000) {
   echo "$LANGUAGE[508] <br>"; 
   die();
  } else {
   echo " $LANGUAGE[509] <br>"; 
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

  #######################
  # Polling EPP Server  #
  #######################

  $EMPTY_QUEUE=FALSE;
  while (!$EMPTY_QUEUE) { 

   echo "$LANGUAGE[510] <br>"; 
   $QT=0; 
   $xml=epp_polling_request($eppsock);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE==1301) {
    xml_domain_polling_msg($xml,$QT,$IDMSG,$DATA,$MSGTITLE,$DOMAIN);
    $xmldeq="";
    $OPCODE=0;
    polling_msg_add($IDMSG,$QT,$DATA,$MSGTITLE,$xml,$xmldeq,$DOMAIN,$OPCODE);
    echo " $LANGUAGE[511] <br>"; 
   }

   #######################
   # DeQueue EPP Server  #
   #######################

   if ($QT>0) {
    echo "$LANGUAGE[512] <br>"; 
    $IDP=get_id_polling($IDMSG);
    $CODE=$IDMSG; 
    $xml=epp_polling_ack($eppsock,$CODE);
    $RESCODE=xml_get_resultcode($xml);
    $REASONCODE=xml_get_reasoncode($xml);
    if ($RESCODE!=1000) {
     echo " ($QT) $LANGUAGE[513] <br>"; 
     webpanel_logs_add("EppProto","$LANGUAGE[514] $CODE.");
    } else {
     echo " ($QT) $LANGUAGE[515] <br>"; 
     echo " ($QT) $LANGUAGE[516] <br>"; 
     webpanel_logs_add("EppProto","$LANGUAGE[517] $CODE.");
     polling_set_status($IDP,"Deleted");
     $xmldeq=$xml;
     $DOMAIN="";
     $OPCODE=0;
     polling_msg_upd($IDP,$xmldeq,$DOMAIN,$OPCODE);
     polling_msg_upd_xmldeq($IDP,$xmldeq);
    }
   } else {
    $EMPTY_QUEUE=TRUE;
   }

  }

  #######################
  # Logout EPP Server   #
  #######################

  echo "$LANGUAGE[518] <br>"; 
  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

 DisconnectDB();
?>