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

  $ID=validate_unsigned($_GET['id']);
  $IDD=$ID;
  $STATUS=get_domain_status($ID);
  get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);

  if ((($STATUS==0)||($STATUS==10)) || (($STATUS==8)||($STATUS==13))) {
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
  }
  
  if ($STATUS==1) {
   $ID_EPPSESSION=admin_eppsession_protection($ID_UTENTE);

   $IDEPP=admin_eppsession($ID_UTENTE);
   $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
   epp_SelectSession($ID_EPPSESSION);

   eppOpenConnection($eppsock);
   $xml=epp_domain_delete($eppsock, $DOMAIN);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   eppCloseConnection($eppsock);

   if ($RESCODE!=1000) {
    webpanel_logs_add("EppProto","Errore nella cancellazione del dominio: $DOMAIN.");
   } if ($RESCODE==2303) {
    webpanel_logs_add("EppProto","Dominio non cancellato perchè inesistente: $DOMAIN.");
    update_domain_status($ID,0);
    update_domain_updating($ID);
   } else {
    webpanel_logs_add("EppProto","Dominio cancellato con successo: $DOMAIN.");
    update_domain_status($ID,5);
    update_domain_updating($ID);
   }

 DisconnectDB();
?>