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

    print_div_open("middle_container_id","middle_container_full");
     print_div_open("left_col_id","left_col");
      print_html_menu_admin();
     print_div_close(1);
     print_div_open("fullmiddle_col_id","fullmiddle_col");
      print_clearline(1);
      $PAG=validate_unsigned($_GET['pag']);
      webpanel_domain_navbar($PAG);

      print_clearline(2);

      $IDREG="9EU000000002872R";
      $T1_MM=2; $T1_GG=1; $T1_YEAR=2021;
      $T1=mktime(0,0,0,$T1_MM,$T1_GG,$T1_YEAR);
      $T2_MM=4; $T2_GG=31; $T2_YEAR=2021;
      $T2=mktime(0,0,0,$T2_MM,$T2_GG,$T2_YEAR);
      $T1_STR=date("d/m/Y-H:i",$T1);
      $T2_STR=date("d/m/Y-H:i",$T2);
      echo "<br> Lista creati da $T1_STR a $T2_STR per $IDREG <br>";
      webpanel_domain_list_ranged($PAG, $T1, $T2, $IDREG);      

      print_clearline(2);

      $IDREG="9EU000000002838R";
      $T1_MM=2; $T1_GG=1; $T1_YEAR=2021;
      $T1=mktime(0,0,0,$T1_MM,$T1_GG,$T1_YEAR);
      $T2_MM=4; $T2_GG=31; $T2_YEAR=2021;
      $T2=mktime(0,0,0,$T2_MM,$T2_GG,$T2_YEAR);
      $T1_STR=date("d/m/Y-H:i",$T1);
      $T2_STR=date("d/m/Y-H:i",$T2);
      echo "<br> Lista creati da $T1_STR a $T2_STR per $IDREG <br>";
      webpanel_domain_list_ranged($PAG, $T1, $T2, $IDREG);      

      print_clearline(2);

      $IDREG="9EU000000002872R";
      $T1_MM=2; $T1_GG=1; $T1_YEAR=2022;
      $T1=mktime(0,0,0,$T1_MM,$T1_GG,$T1_YEAR);
      $T2_MM=4; $T2_GG=10; $T2_YEAR=2022;
      $T2=mktime(0,0,0,$T2_MM,$T2_GG,$T2_YEAR);
      $T1_STR=date("d/m/Y-H:i",$T1);
      $T2_STR=date("d/m/Y-H:i",$T2);
      echo "<br> Lista in scadenza da $T1_STR a $T2_STR per $IDREG <br>";
      webpanel_domain_list_ranged_expire($PAG, $T1, $T2, $IDREG);  

      print_clearline(2);

      $IDREG="9EU000000002838R";
      $T1_MM=2; $T1_GG=1; $T1_YEAR=2022;
      $T1=mktime(0,0,0,$T1_MM,$T1_GG,$T1_YEAR);
      $T2_MM=4; $T2_GG=10; $T2_YEAR=2022;
      $T2=mktime(0,0,0,$T2_MM,$T2_GG,$T2_YEAR);
      $T1_STR=date("d/m/Y-H:i",$T1);
      $T2_STR=date("d/m/Y-H:i",$T2);
      echo "<br> Lista in scadenza da $T1_STR a $T2_STR per $IDREG <br>";
      webpanel_domain_list_ranged_expire($PAG, $T1, $T2, $IDREG);      

      print_clearline(2);

      $IDREG="9EU000000002853R";
      $T1_MM=2; $T1_GG=1; $T1_YEAR=2022;
      $T1=mktime(0,0,0,$T1_MM,$T1_GG,$T1_YEAR);
      $T2_MM=4; $T2_GG=10; $T2_YEAR=2022;
      $T2=mktime(0,0,0,$T2_MM,$T2_GG,$T2_YEAR);
      $T1_STR=date("d/m/Y-H:i",$T1);
      $T2_STR=date("d/m/Y-H:i",$T2);
      echo "<br> Lista in scadenza da $T1_STR a $T2_STR per $IDREG <br>";
      webpanel_domain_list_ranged_expire($PAG, $T1, $T2, $IDREG);      


      print_clearline(2);
     print_div_close(1);
    print_div_close(1);
 
  print_html_down();
 DisconnectDB();
?>