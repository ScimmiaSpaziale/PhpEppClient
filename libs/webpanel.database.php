<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 1.6                                     #
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

 function Randomize() {
  mt_srand((double)microtime()*1000000);
 } 

 function db_error(){
  global $LANGUAGE;
  echo "$LANGUAGE[340]";
  die();
 }

 function ConnectDB(){
  global $db,$db_host,$db_user,$db_password,$db_name,$LANGUAGE;
  #$db = mysql_connect($db_host, $db_user, $db_password);
  $db = mysqli_connect($db_host, $db_user, $db_password);
  if ($db == FALSE) db_error();
  #mysql_select_db($db_name, $db) or die ("<b>$LANGUAGE[341]</b><br>".mysqli_error($db));
  mysqli_select_db($db, $db_name) or die ("<b>$LANGUAGE[341]</b><br>".mysqli_error($db));
 }

 function DisconnectDB(){
  global $db,$db_host,$db_user,$db_password,$db_name;
  #mysql_close($db);
  mysqli_close($db);
 }

 function DBQuery($QUERY){
  global $db,$MX,$db_reconnect,$LANGUAGE;
  if ($db_reconnect) {
   DisconnectDB();
   ConnectDB();
  }
  #mysql_query($QUERY,$db) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
  mysqli_query($db,$QUERY) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
 }

 function DBSelect($QUERY,&$RECORDSET){
  global $db,$MX,$db_reconnect,$LANGUAGE;
  if ($db_reconnect) {
   DisconnectDB();
   ConnectDB();
  }
  #$RECORDSET = mysql_query($QUERY,$db) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
  $RECORDSET = mysqli_query($db,$QUERY) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
 }

 function DoQuery($QUERY){
  global $db,$MX,$db_reconnect,$LANGUAGE;
  if ($db_reconnect) {
   DisconnectDB();
   ConnectDB();
  }
  #mysql_query($QUERY,$db) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
  mysqli_query($db,$QUERY) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
 }

 function DoSelect($QUERY,&$RECORDSET){
  global $db,$MX,$db_reconnect,$LANGUAGE;
  if ($db_reconnect) {
   DisconnectDB();
   ConnectDB();
  }
  #$RECORDSET = mysql_query($QUERY,$db) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
  $RECORDSET = mysqli_query($db,$QUERY) or die("<b>$LANGUAGE[341]</b><br>$QUERY<br>".mysqli_error($db));
 }

 function NextRecord(&$RECORDSET,&$RESULT){
#  if ($RESULT = mysql_fetch_array($RECORDSET)){
  if ($RESULT = mysqli_fetch_array($RECORDSET, MYSQLI_BOTH)){
    return TRUE;
  } else return FALSE;
 } 

 function newID($ID_table,$SRC_table){
  DBSelect("SELECT MAX($ID_table) AS IDMAX FROM $SRC_table",$rs);
  if (NextRecord($rs,$r)) return $r['IDMAX']+1; else return 1;
 }
?>