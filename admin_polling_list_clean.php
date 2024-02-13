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
 include("conf/webpanel.db.php");
 include("lang/language.it.php");
 include("lang/polling.opcodes.php");
 include("libs/webpanel.database.php");
 include("libs/webpanel.interface.php");
 include("libs/webpanel.login.php");
 include("libs/webpanel.functions.php");
 include("libs/xmlutility.inc.php");
 include("libs/external.inc.php");
 include("libs/output.inc.php");
 ConnectDB();
  $PAG=validate_unsigned($_GET['pag']);
  $K=validate_string($_POST['key']);
  if ($K=="") $K=validate_string($_GET['key']);

  webpanel_polling_list_clean($PAG);

 DisconnectDB();
?>