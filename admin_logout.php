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

 include("conf/config.inc.php");
 include("lang/language.it.php");
 include("conf/webpanel.db.php");
 include("libs/webpanel.database.php");
 include("libs/webpanel.interface.php");
 include("libs/webpanel.login.php");
 include("libs/webpanel.functions.php");
 include("libs/xmlutility.inc.php");
 include("libs/epplibrary.inc.php");
 include("libs/eppcommands.inc.php");
 include("libs/epphtml.inc.php");
 include("libs/output.inc.php");

 ConnectDB();
  print_html_top("$LANGUAGE[374]");
   print_html_menu();
    $ID_ADMIN=admin_protection();
    if (!isset($PAG)) $PAG=0;
    print_div_open("middle_container_id","middle_container_full");
     print_div_open("left_col_id","left_col");
      print_html_menu_admin();
     print_div_close(1);
     print_div_open("fullmiddle_col_id","fullmiddle_col");
      print_clearline(2);
      print_clearline(2);
      webpanel_epp_history($ID_ADMIN,$PAG);
      print_clearline(2);
      $IDEPP=admin_eppsession($ID_ADMIN);
      $ID_EPPSESSION=admin_get_eppsessionid($IDEPP);
      echo "$LANGUAGE[405] <b>$ID_EPPSESSION</b>";
      print_clearline(2);
      epp_SelectSession($ID_EPPSESSION);
      eppOpenConnection($eppsock);
      $xml=eppReadXMLScheme("logout");
      xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
      eppSendCommand($eppsock,$xml);
      $xml=eppGetFrame($eppsock);
      print_xml_textarea($xml,"xmltxt2",80,12);
      print_clearline(2);
      eppCloseConnection($eppsock);
      $CRD=xml_get_credit($xml);
      webpanel_closeepp($ID_ADMIN,$CRD);
      print_clearline(2);
     print_div_close(1);
    print_div_close(1);

  print_html_down();
 DisconnectDB();
?>