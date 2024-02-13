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

  $IDDS=validate_unsigned($_POST['idds']);
  update_servers_idds($IDDS);

  $IDD=validate_unsigned($_GET['idd']);
  $IDREG=validate_string($_POST['idreg']);
  $IDADM=validate_string($_POST['idadmin']);
  $IDTECH=validate_string($_POST['idtech']);
  $IDBILL=validate_string($_POST['idbill']);

  if ($IDDS==0) {
   $IP1=validate_string($_POST['ip1']);
   $IP2=validate_string($_POST['ip2']);
   $IP3=validate_string($_POST['ip3']);
   $IP4=validate_string($_POST['ip4']);
   $IP5=validate_string($_POST['ip5']);
   $IP6=validate_string($_POST['ip6']);
   $NS1=validate_string($_POST['ns1']);
   $NS2=validate_string($_POST['ns2']);
   $NS3=validate_string($_POST['ns3']);
   $NS4=validate_string($_POST['ns4']);
   $NS5=validate_string($_POST['ns5']);
   $NS6=validate_string($_POST['ns6']);
  } else {
   get_dnsserver_info($IDDS,$DESC,$NS1,$IP1,$NS2,$IP2,$NS3,$IP3,$NS4,$IP4,$NS5,$IP5,$NS6,$IP6);
  } 
 
  $DOMAIN=validate_string($_POST['name']);

  update_domain($IDD,$DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL);
  del_domain_dns($IDD);
  add_domain_dns($IDD,$NS1,$NS2,$NS3,$NS4,$NS5,$NS6,$IP1,$IP2,$IP3,$IP4,$IP5,$IP6);
  nameserver_queue_domain_update($IDD);

 DisconnectDB();
 header("location: ../admin_domini.php");
?>