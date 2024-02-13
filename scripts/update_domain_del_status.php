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

  $IDEPP=admin_eppsession($ID_UTENTE);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  $IDD=validate_unsigned($_GET['idd']);
  $STATUS=validate_string($_GET['status']);
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  
  eppOpenConnection($eppsock);
  $xml=epp_domain_remove_status($eppsock, $DOMAIN, $STATUS);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  print_epp_error($RESCODE,$REASONCODE);
  eppCloseConnection($eppsock);

  if ($RESCODE==1000) {
   echo "<br>$LANGUAGE[499] <b>$DOMAIN</b> <br><br>";
   webpanel_logs_add("EppProto","$LANGUAGE[499] $DOMAIN.");
   domain_del_status($IDD,$STATUS);
   update_domain_updating($IDD);
  } else {
   echo "<br>$LANGUAGE[500] <b>$DOMAIN</b> <br><br>";
   webpanel_logs_add("EppProto","$LANGUAGE[500] $DOMAIN, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
  }

  print_debug_info($xml,"domform",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
  echo "<br><a href=\"../admin_domini.php\">$LANGUAGE[416]</a><br>";

 DisconnectDB();
?>
