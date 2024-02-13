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
 include("../whois/whois.lang.php");
 include("../whois/server_list.php");
 include("../whois/whois_class.php");
 ConnectDB();
  $IDES=4;
  $ID_ADMIN=1;
  $ID=get_domain_backorder(0);
  get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  
  $tld=extract_tld_nodot($DOMAIN);
  $domain=remove_tld($DOMAIN);

  $ADDR=$servers[$tld]['address'];
  echo "<b>Domain:</b> $domain"."."."$tld <br><br>";
  echo "<b>Whois Address:</b> $ADDR <br><br>";

  $my_whois=new Whois_domain;
  $my_whois->possible_tlds=array_keys($servers);
  $my_whois->tld="$tld";
  $my_whois->domain=$domain;
  $my_whois->free_string=$servers[$tld]['free'];
  $my_whois->whois_server=$servers[$tld]['address'];
  $my_whois->whois_param=$servers[$tld]['param'];
  $my_whois->full_info="yes";
  $my_whois->process();
  if ($my_whois->msg != "") {
   echo $my_whois->msg;
  } 
  if ($my_whois->info != "") {
   echo $my_whois->compl_domain."<br>";
   echo "
    <div align=left>
     <blockquote>".nl2br($my_whois->info)."</blockquote>
    </div>
   ";
   if (!in_str($my_whois->info,"PENDING-DELETE")) {
    update_domain_status($ID,10);
    echo "<br> Dominio non più in pending delete! <br>";
   }
  } 

 DisconnectDB();
?>