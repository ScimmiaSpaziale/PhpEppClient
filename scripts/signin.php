<?
 ##################################################################################################### 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
 ##################################################################################################### 
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
 include("../libs/upgrades.db.php");
 ConnectDB();

 $USERNAME=addslashes($_POST['username']);
 $PASSWORD=addslashes($_POST['password']);

 if (($USERNAME=="")&&($PASSWORD=="")){
   webpanel_logs_add("Security","$LANGUAGE[151]");
   DisconnectDB();
   header("Location: ../errore.php?E=1");
   die();
 } else 
 if (($USERNAME=="")){
   webpanel_logs_add("Security","$LANGUAGE[152]");
   DisconnectDB();
   header("Location: ../errore.php?E=2");
   die();
 } else
 if (($PASSWORD=="")){
   webpanel_logs_add("Security","$LANGUAGE[153]");
   DisconnectDB();
   header("Location: ../errore.php?E=3");
   die();
 } else
 if (in_login($USERNAME,$PASSWORD)){
   webpanel_logs_add("Security","$LANGUAGE[154] $USERNAME");
   $ID_ADMIN=get_admin_user($USERNAME,$PASSWORD);
   check_upgrades();
   session_start();
   create_login_session($ID_ADMIN);
   session_write_close();
   DisconnectDB();
   header("Location: ../index.php");
 } else {
   webpanel_logs_add("Security","$LANGUAGE[155]");
   DisconnectDB();
   header("Location: ../errore.php?E=4");
   die();
 }
?>