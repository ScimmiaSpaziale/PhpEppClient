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
  $ID_ADMIN=1;
  $ID_EPPSESSION=admin_eppsession_protection($ID_ADMIN);
  $IDEPP=admin_eppsession($ID_ADMIN);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  #######################
  # Polling EPP Server  #
  #######################

  $QT=0; 
  eppOpenConnection($eppsock);
  $xml=epp_polling_request($eppsock);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE==1301) {
   xml_domain_polling_msg($xml,$QT,$IDMSG,$DATA,$MSGTITLE);
   polling_msg_add($IDMSG,$QT,$DATA,$MSGTITLE,$xml);
  }

  #######################
  # DeQueue EPP Server  #
  #######################

  if ($QT>0) {
   $IDP=get_id_polling($IDMSG);
   $CODE=$IDMSG; 
   eppOpenConnection($eppsock);
   $xml=epp_polling_ack($eppsock,$CODE);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE!=1000) {
    webpanel_logs_add("EppProto","Errore nella cancellazione di messaggio da coda polling: $CODE.");
   } else {
    webpanel_logs_add("EppProto","Messaggio eliminato dalla coda di polling con successo: $CODE.");
    polling_set_status($IDP,"Deleted");
   }
  }

 DisconnectDB();
?>