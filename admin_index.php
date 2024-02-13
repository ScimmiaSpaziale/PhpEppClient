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

 #ini_set('display_errors', 1); 
 #ini_set('display_startup_errors', 1); 
 #error_reporting(E_ALL);

 include("conf/config.inc.php");
 include("lang/language.it.php");
 include("conf/webpanel.db.php");
 include("libs/webpanel.database.php");
 include("libs/webpanel.interface.php");
 include("libs/webpanel.login.php");
 include("libs/webpanel.functions.php");
 include("libs/output.inc.php");
 ConnectDB();
  print_html_top("$LANGUAGE[374]");
   print_html_menu();
   $ID_ADMIN=admin_protection();
   $ID_LEVEL=get_userlevel($ID_ADMIN);

    print_div_open("middle_container_id","middle_container_full");
     print_div_open("left_col_id","left_col");
      print_html_menu_admin();
     print_div_close(1);
     print_div_open("fullmiddle_col_id","fullmiddle_col");
      print_clearline(2);
      $ID_EPPSESSION=admin_eppsession($ID_ADMIN);
      if ($ID_EPPSESSION==0) {
       form_open_eppconnection($ID_ADMIN);
       if ($ID_LEVEL==1) form_open_eppconnection_newpassword($ID_ADMIN);
      } else form_close_eppconnection($ID_ADMIN);
      if ($ID_LEVEL==1) {
       admin_mostra_dati_account($ID_ADMIN);
       print_clearline(1);
       webpanel_form_add_eppserver();
       webpanel_eppserver_list();
      }
      print_clearline(2);
     print_div_close(1);
    print_div_close(1);

  print_html_down();
 DisconnectDB();
?>