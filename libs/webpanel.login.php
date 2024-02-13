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

 function security_code(){
  $str="";
  randomize(); 
  for ($i==0;$i<12;$i++) {
     $rndvalue=mt_rand(1,3);
     $rndvalue2=mt_rand(1,1000);
     if ($rndvalue==1) $ch=chr(($rndvalue2 % 10)+48);
     if ($rndvalue==2) $ch=chr(($rndvalue2 % 26)+65);
     if ($rndvalue==3) $ch=chr(($rndvalue2 % 26)+97);
     $str="$str$ch";
   }
  return $str;
 } 

 function in_login($USERNAME,$PASSWORD){
  $PASSWORD=crypt_webpanel_string($PASSWORD);
  if (($USERNAME=="")||($PASSWORD=="")) return FALSE;
   else {
    DBSelect("SELECT * FROM admin_users WHERE (username='$USERNAME') AND (password='$PASSWORD')",$rs);
    if (NextRecord($rs,$r)) return TRUE; else return FALSE;
   }
 }

 function get_admin_user($USERNAME,$PASSWORD){
  $PASSWORD=crypt_webpanel_string($PASSWORD);
  if (($USERNAME=="")||($PASSWORD=="")) return 0;
   else {
    DBSelect("SELECT * FROM admin_users WHERE (username='$USERNAME') AND (password='$PASSWORD')",$rs);
    if (NextRecord($rs,$r)) return $r['ida']; else return 0;
   }
 }

 function create_login_session($ID){
  $_SESSION['IDADMIN']=$ID; 
 }

 function id_active_user(){
  if (isset($_SESSION['IDADMIN'])) {
   return $_SESSION['IDADMIN'];
  } else return 0;
 }

 function get_userlevel(){
  $IDADMIN=id_active_user();
  if (($IDADMIN=="")||($IDADMIN==0)) {
   #header("Location: errore.php?E=5");
   #die();
  }
  DBSelect("SELECT idlevel FROM admin_users WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) return $r['idlevel'];
   else return FALSE;
 }

 function get_userlevel_noredir(){
  $IDADMIN=id_active_user();
  DBSelect("SELECT idlevel FROM admin_users WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) return $r['idlevel'];
   else return FALSE;
 }
 
 function user_protection(){
  $ID_UTENTE=id_active_user();
  if (($IDADMIN=="")||($IDADMIN==0)) {
   header("Location: errore.php?E=5");
   die();
  }
  return $IDADMIN;
 }

 function admin_protection(){
  $Livello=get_userlevel();
  if ($Livello<=0) {
   header("Location: errore.php?E=6");
   die();
  } else {
   return id_active_user();
  }
 }

 function logout(){
  session_start();
  $_SESSION['IDADMIN']=0;
  session_unset();
 }

 function get_admin_info($ID,&$NOME,&$COGNOME){
  DBSelect("SELECT * FROM admin_users WHERE ida=$ID",$rs);
  if (NextRecord($rs,$r)) {
   $NOME=$r['nome'];
   $COGNOME=$r['cognome'];
  } else {
   $NOME="";
   $COGNOME="";
  }
 }
?>