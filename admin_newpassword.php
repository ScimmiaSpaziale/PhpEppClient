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
      print_clearline(2);
      print_clearline(2);
      $IDES=validate_unsigned($_POST[ides]);
      $NEWPASSWORD=validate_string($_POST['newpassword']);
      update_servers_ides($IDES);
      eppOpenConnection($eppsock);
      if ($IDES>0) $xml=epp_login_newpassword_db_account($eppsock, "$NEWPASSWORD", $ID_ADMIN);
       else $xml=epp_login_newpassword_ext($eppsock, "$epp_username_A", "$epp_password_A", "$NEWPASSWORD");
      print_xml_textarea($xml,"xmltxt",80,12);
      print_clearline(2);
      $RESCODE=xml_get_resultcode($xml);
      $REASONCODE=xml_get_reasoncode($xml);
      if ($RESCODE!=1000) {
       print_epp_error($RESCODE,$REASONCODE);
       eppCloseConnection($eppsock);
       die();
      } else {
       $CRD=xml_get_credit($xml);
       echo "$LANGUAGE[380] <br>"; 
       echo "$LANGUAGE[403] $CRD <br>";
       client_update_eppcredit($ID_ADMIN,$CRD);
       $NEWPWD=crypt_webpanel_string($NEWPASSWORD);
       webpanel_logs_add("Security","$LANGUAGE[406] $NEWPASSWORD.");
       if ($IDES>0) update_password_epp_server($IDES,$NEWPASSWORD);
        else echo "<br>$LANGUAGE[407]<br><br>";
      }
      $SESSIONID=epp_http_get_sessionID($xml);
      echo "$LANGUAGE[404] <b>$SESSIONID</b> <br><br>"; 
      epp_SelectSession($SESSIONID);
      webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

      print_clearline(2);
     print_div_close(1);
    print_div_close(1);

  print_html_down();
 DisconnectDB();
?>