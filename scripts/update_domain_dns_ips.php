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

  $IDD=validate_unsigned($_GET[iddomain]);
  $REMOVEOLD=(validate_char($_POST[nsdel])=="V");
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($IDD, $OLD_NS[1], $OLD_NS[2], $OLD_NS[3], $OLD_NS[4], $OLD_NS[5], $OLD_NS[6], $OLD_IP[1], $OLD_IP[2], $OLD_IP[3], $OLD_IP[4], $OLD_IP[5], $OLD_IP[6]);

  $IDDS=validate_unsigned($_POST['idds']);
  update_servers_idds($IDDS);
  if ($IDDS==0) {
   $IP[1]=validate_string($_POST['ip1']);
   $IP[2]=validate_string($_POST['ip2']);
   $IP[3]=validate_string($_POST['ip3']);
   $IP[4]=validate_string($_POST['ip4']);
   $IP[5]=validate_string($_POST['ip5']);
   $IP[6]=validate_string($_POST['ip6']);
   $NS[1]=validate_string($_POST['ns1']);
   $NS[2]=validate_string($_POST['ns2']);
   $NS[3]=validate_string($_POST['ns3']);
   $NS[4]=validate_string($_POST['ns4']);
   $NS[5]=validate_string($_POST['ns5']);
   $NS[6]=validate_string($_POST['ns6']);
   $IPV6[1]=validate_string($_POST['ipv6n1']);
   $IPV6[2]=validate_string($_POST['ipv6n2']);
   $IPV6[3]=validate_string($_POST['ipv6n3']);
   $IPV6[4]=validate_string($_POST['ipv6n4']);
   $IPV6[5]=validate_string($_POST['ipv6n5']);
   $IPV6[6]=validate_string($_POST['ipv6n6']);
  } else {
   get_dnsserver_info($IDDS,$DESC,$NS[1],$IP[1],$NS[2],$IP[2],$NS[3],$IP[3],$NS[4],$IP[4],$NS[5],$IP[5],$NS[6],$IP[6]);
  } 

  $IDEPP=admin_eppsession($ID_UTENTE);
  $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
  epp_SelectSession($ID_EPPSESSION);

  eppOpenConnection($eppsock);
  $xml=epp_domain_info($eppsock, $DOMAIN);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  eppCloseConnection($eppsock);
  print_debug_info($xml,"infoform",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
  xml_get_domain_info_ns($xml,$OLD_NS[1],$OLD_NS[2],$OLD_NS[3],$OLD_NS[4],$OLD_NS[5],$OLD_NS[6]);

  del_domain_dns($IDD);
  add_domain_dns($IDD,$NS[1],$NS[2],$NS[3],$NS[4],$NS[5],$NS[6],$IP[1],$IP[2],$IP[3],$IP[4],$IP[5],$IP[6]);
  nameserver_queue_domain_update($IDD);

  echo "$LANGUAGE[546] $OLD_NS[1],$OLD_NS[2],$OLD_NS[3],$OLD_NS[4],$OLD_NS[5],$OLD_NS[6] <br>";

  eppOpenConnection($eppsock);
  $xml=epp_update_nameservers_full($eppsock, $DOMAIN, $NS, $OLD_NS, $IP, $IPV6, $REMOVEOLD);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  eppCloseConnection($eppsock);

  if ($RESCODE==1000) {
   echo "$LANGUAGE[501] <b>$DOMAIN</b> <br><br>";
   webpanel_logs_add("EppProto","$LANGUAGE[502] $DOMAIN.");
   update_domain_updating($IDD);
  } else if ($RESCODE==1001) {
   echo "$LANGUAGE[501] <b>$DOMAIN</b> <br><br>";
   webpanel_logs_add("EppProto","$LANGUAGE[503] $DOMAIN.");
   update_domain_updating($IDD);
  } else {
   webpanel_logs_add("EppProto","$LANGUAGE[504] $DOMAIN, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
  }

  print_debug_info($xml,"domform",120,20,$RESCODE,$REASONCODE,$ID_EPPSESSION);
  echo "<br><a href=\"../admin_domini.php\">$LANGUAGE[416]</a><br>";

 DisconnectDB();
?>