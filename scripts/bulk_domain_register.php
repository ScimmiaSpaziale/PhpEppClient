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
  eppOpenConnection($eppsock);

  $list=addslashes($_POST['domainlist']);
  $l=strlen($list);
  $i=0;
  while ($i<$l) {
   $e=extract_domain_from_list($i,$list);
   list($DOMAIN,$EPPCODE)=explode(" ",$e,2);
   $DOMAIN=trim($DOMAIN);

   $EPPCODE=create_random_eppcode();
   $YEARS=1;
   
   get_defaultinfo(
    $ID_UTENTE,$eppcredit,$NS1,$NS2,$NS3,$NS4,$NS5,$NS6,$IP1,$IP2,$IP3,$IP4,$IP5,$IP6,$IDREG,$IDADM,$IDTECH,$IDBILL,$prefix,$debug,$exam
   );

   $xml=epp_create_domain($eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $IDREG, $IDADM, $IDTECH, $EPPCODE);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);

   if ($RESCODE==1000) {
    echo "$LANGUAGE[437] <b>$DOMAIN</b> <br><br>";
    webpanel_logs_add("EppProto","$LANGUAGE[437] $DOMAIN.");
   } else {
    echo "$LANGUAGE[438] <b>$DOMAIN</b> <br><br>";
    webpanel_logs_add("EppProto","$LANGUAGE[438] $DOMAIN, $LANGUAGE[384] $RESCODE, $LANGUAGE[385] $REASONCODE.");
   }

  }

  eppCloseConnection($eppsock);
  echo "<br><a href=\"../admin_domini.php\">$LANGUAGE[416]</a><br>";

 DisconnectDB();
?>