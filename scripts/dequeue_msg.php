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
 include("../libs/external.inc.php");
 ConnectDB();
  session_start();
  $ID_UTENTE=admin_protection();
  $ID_EPPSESSION=admin_eppsession_protection($ID_UTENTE);

  $IDP=validate_unsigned($_GET['idp']);
  $CODE=validate_string($_GET['code']);

  echo "<br> $LANGUAGE[466] [$IDP] <b>$CODE</b> <br><br>";

  $IDEPP=admin_eppsession($ID_UTENTE);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  eppOpenConnection($eppsock);
  $xml=epp_polling_ack($eppsock, $CODE);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  eppCloseConnection($eppsock);

  if ($RESCODE!=1000) {
   print_epp_error($RESCODE,$REASONCODE);
   webpanel_logs_add("EppProto","$LANGUAGE[467] $CODE.");
   if (($RESCODE==2303)&&($REASONCODE==5004)) { delete_polling_msg($IDP); }
  } else {
   echo "Comando eseguito con successo! <br>";
   webpanel_logs_add("EppProto","$LANGUAGE[468] $CODE.");
   polling_set_status($IDP,"Deleted");
   $XMLDEQ=$xml;
   polling_msg_upd_xmldeq($IDP,$XMLDEQ);
   xml_domain_polling_msg($xml,$QT,$IDMSG,$DATA,$MSGTITLE,$DOMAIN);

   if ($QT>0) {

    eppOpenConnection($eppsock);
    $xml=epp_polling_request($eppsock);
    $RESCODE=xml_get_resultcode($xml);
    $REASONCODE=xml_get_reasoncode($xml);
    if (($RESCODE!=1300)&&($RESCODE!=1301)) {
     eppCloseConnection($eppsock);
    } else {
     if ($RESCODE==1300) {
     }
     if ($RESCODE==1301) {
      xml_domain_polling_msg($xml,$QT,$IDMSG,$DATA,$MSGTITLE,$DOMAIN);
      $xmldeq="";
      $OPCODE=0;
      polling_msg_add($IDMSG,$QT,$DATA,$MSGTITLE,$xml,$xmldeq,$DOMAIN,$OPCODE);

      //$OPCODE=search_polling_opcode($MSGTITLE);
      //echo "$IDMSG,$DOMAIN,$OPCODE - MSGTITLE=$MSGTITLE <br>";
      //polling_msg_upd($IDMSG,$xmldeq,$DOMAIN,$OPCODE);
     }
    }

   }
  }

  print_debug_info($xml,"pollingqueue",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
  echo "<br><a href=\"../admin_polling_list.php\">$LANGUAGE[416]</a><br>";

 DisconnectDB();
?>