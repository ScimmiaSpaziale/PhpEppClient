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
 include("../libs/automails.inc.php");
 ConnectDB();
  session_start();
  $ID_UTENTE=admin_protection();

  $ID=validate_unsigned($_GET['id']);
  $IDD=$ID;
  $STATUS=get_domain_status($ID);
  get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);

  if (($STATUS!=1)&&($STATUS!=15)){
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
  }
  
  if ($STATUS==1) {
   $ID_EPPSESSION=admin_eppsession_protection($ID_UTENTE);

   echo "<br> $LANGUAGE[439] [$ID] <b>$DOMAIN</b> <br><br>";

   $IDEPP=admin_eppsession($ID_UTENTE);
   $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
   epp_SelectSession($ID_EPPSESSION);

   eppOpenConnection($eppsock);
   $xml=epp_domain_delete($eppsock, $DOMAIN);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   eppCloseConnection($eppsock);

   if ($RESCODE!=1000) {
    print_epp_error($RESCODE,$REASONCODE);
    webpanel_logs_add("EppProto","$LANGUAGE[431] $DOMAIN.");
   } else {
    notify_epp_domain_deletion($DOMAIN);
   }

   switch ($RESCODE) {
    case 1000:
     echo "$LANGUAGE[380] <br>";
     webpanel_logs_add("EppProto","$LANGUAGE[442] $DOMAIN.");
     update_domain_status($ID,5);
     update_domain_updating($ID);
     break;
    case 2002:
     echo "$$LANGUAGE[554]<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[554] $DOMAIN.");
     break;
    case 2302:
     echo "$LANGUAGE[551]<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[551] $DOMAIN.");
     update_domain_status($ID,4);
     update_domain_updating($ID);
     break;
    case 2303:
     echo "$LANGUAGE[440]<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[441] $DOMAIN.");
     update_domain_status($ID,0);
     update_domain_updating($ID);
     break;
    default:
     echo "$LANGUAGE[555]<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[555] $DOMAIN.");
     break;
   }

   print_debug_info($xml,"domform",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
   echo "<br><a href=\"../admin_domini.php\">$LANGUAGE[416]</a><br>";
  }
  
 DisconnectDB();
 @header("location: ../admin_domini.php");
?>