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
  $ID_ADMIN=admin_protection();
  $ID_LEVEL=get_userlevel($ID_ADMIN);  
  $ID_USER=$ID_ADMIN;

  $IDD=validate_unsigned($_GET['idd']);
  $PAG=validate_unsigned($_GET['pag']);

  get_crd_prices($N_CRD, $T_CRD, $R_CRD, $F_CRD);
  $AVAILABLE_CRD=get_available_credits($ID_USER);
  $USED_CRD=get_used_credits($ID_USER);

  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);

  if ($ID_LEVEL<=1) {
   renew_domain_name($IDD,1);
  } else if ($ID_LEVEL>1) {
   if ($AVAILABLE_CRD>$F_CRD) {
    log_used_crd($ID_USER, $F_CRD, "Dominio rinnovato: $DOMAIN");
    dec_credits($ID_USER, $F_CRD);
    renew_domain_name($IDD,1);
   } else {
    echo "Rinnovo non eseguito, per insufficienza di credito. <br>";
   }
  }

 DisconnectDB();
 header("location: ../admin_domini_expiring.php?pag=$PAG");
?>