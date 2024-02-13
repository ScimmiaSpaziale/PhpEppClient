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

 ########################################################################
 # Funzioni aggiornate 14/01/2011
 ########################################################################

 function is_valid_numeric_char($CH){
  if (($CH>='0')&&($CH<='9')) return TRUE;
   else return FALSE;
 }

 function validate_tel($s){
  $str="";
  for ($i=0;$i<strlen($s);$i++){
   $ch=substr($s,$i,1);
   if (is_valid_numeric_char($ch)) $str=$str.$ch;
  }
  return $str;
 }

 ########################################################################
 # Funzioni aggiornate 10/09/2010
 ########################################################################

 function mask_password_underscore($PASSWORD){
  $MASKED=""; 
  $L=strlen($PASSWORD);
  for ($i=1; $i<=$L; $i++) $MASKED.="-";
  return $MASKED;
 }

 function validate_char($VAL){
  return addslashes($VAL);
 }

 function validate_unsigned($VAL){
  if (!is_numeric($VAL)) $VAL=0; 
  return $VAL;
 }

 function validate_string($VAL){
  return addslashes($VAL);
 }

 ########################################################################
 # Funzioni aggiornate 10/09/2010
 ########################################################################
 
 function microtime_float() {
  list($usec, $sec) = explode(" ", microtime()); 
  return ((float)$usec + (float)$sec); 
 }

 function chMaiusc($ch){
   if (($ch>='a')&&($ch<='z')) return chr(ord($ch)-32);
    else return $ch;
 }

 function chMinusc($ch){
   if (($ch>='A')&&($ch<='Z')) return chr(ord($ch)+32);
    else return $ch;
 }

 function strMaiusc($s){
  $l=strlen($s);
  $newS="";
  for ($i=0;$i<$l;$i++) $newS.=chMaiusc(substr($s,$i,1));
  return $newS;
 }

 function strMinusc($s){
  $l=strlen($s);
  $newS="";
  for ($i=0;$i<$l;$i++) $newS.=chMinusc(substr($s,$i,1));
  return $newS;
 }

 ########################################################################
 # Funzioni aggiornate 10/09/2010
 ########################################################################

 function crea_navigator($pagina,$totale_pagine,$limite,$url) {
  global $LANGUAGE;
  if (($pagina=="")||($pagina<1)) $pagina=1;
  $pagine = "";
  $previous = "";
  $next = "";
  $navigator = "";
  if ($totale_pagine>1) {
   $lowlimit=$pagina-$limite;
   $higlimit=$pagina+$limite;
   if ($lowlimit<1) $higlimit=$higlimit+(-1*$lowlimit);
   if ($higlimit>$totale_pagine) $lowlimit=$lowlimit-($higlimit-$totale_pagine);  
   for ($c=1;$c<=$totale_pagine;$c++) {
    if (($c>=$lowlimit)&&($c<=$higlimit)){
    if ($c!=$pagina) $pagine .= "[<a href=\"".$url."&pag=$c\">$c</a>] ";
     else $pagine .= "[$c] ";
    }
   }
   $page_next = $pagina+1;
   $page_prev = $pagina-1;
   if ($pagina<$totale_pagine) $next = " &nbsp;<a href=\"".$url."&pag=".$page_next."\">$LANGUAGE[58]</a> ";
   if ($pagina>1) $previous = " <a href=\"".$url."&pag=".$page_prev."\">$LANGUAGE[59]</a>&nbsp; ";
   $navigator = "".$previous.$pagine.$next."";
  }
  echo "<center>$navigator</center>";
 }

 function crypt_key_change($OLDKEY,$NEWKEY){
  global $EPP_CRYPTKEY, $LANGUAGE;
  if ($EPP_CRYPTKEY!=$OLDKEY) {
   echo "$LANGUAGE[342] <br>";
   echo "$LANGUAGE[343] <br>";
   logout();
   webpanel_logs_add("Security","$LANGUAGE[344]");
   die();
  }
  DBSelect("SELECT * FROM admin_users",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r['ida'];
   $PW=decrypt_webpanel_string_by_key($r['password'],$OLDKEY);
   $NEWPW=crypt_webpanel_string_by_key($PW,$NEWKEY);
   DBQuery("UPDATE admin_users SET password='$NEWPW' WHERE ida=$ID");
  }
  DBSelect("SELECT * FROM domain_names",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r['idd']; 
   $PW=decrypt_webpanel_string_by_key($r['eppcode'],$OLDKEY);
   $NEWPW=crypt_webpanel_string_by_key($PW,$NEWKEY);
   DBQuery("UPDATE domain_names SET eppcode='$NEWPW' WHERE idd=$ID");
  }
  DBSelect("SELECT * FROM servers_epp",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r['ides']; 
   $PW=decrypt_webpanel_string_by_key($r['password'],$OLDKEY);
   $NEWPW=crypt_webpanel_string_by_key($PW,$NEWKEY);
   DBQuery("UPDATE servers_epp SET password='$NEWPW' WHERE ides=$ID");
  }
 }

 function mask_password($S){
  $NEW="";
  $L=strlen($S);
  for ($I=0; $I<$L; $I++) {
   $NEW=$NEW."*";
  }
  return $NEW;
 }

 function crypt_webpanel_char($A,$B,$N){
  $AB=Ord($A);
  $BB=Ord($B);
  $N=$N%256;
  $CB=($AB+$BB+$N)%256;
  $C=Chr($CB);
  return $C;
 }

 function decrypt_webpanel_char($A,$B,$N){
  $AB=Ord($A);
  $BB=Ord($B);
  $N=$N%256;
  $CB=($AB-$BB-$N)%256;
  $C=Chr($CB);
  return $C;
 }

 function crypt_webpanel_string($S){
  global $EPP_CRYPTKEY,$EPP_NOCRYPT;
  if (!$EPP_NOCRYPT){
   $I=0;
   $L=strlen($S);
   $CH="";
   $N="";
   for ($I=0; $I<$L; $I++) { 
    $CH=substr($S,$I,1);
    $KH=substr($EPP_CRYPTKEY,$I,1);
    $DH=crypt_webpanel_char($CH,$KH,$I);
    $N=$N.$DH;
   }
   return addslashes($N);
  } else return $S;
 }

 function decrypt_webpanel_string($S){
  global $EPP_CRYPTKEY,$EPP_NOCRYPT;
  if (!$EPP_NOCRYPT){
   $S=stripslashes($S);
   $I=0;
   $L=strlen($S);
   $CH="";
   $N="";
   for ($I=0; $I<$L; $I++) { 
    $CH=substr($S,$I,1);
    $KH=substr($EPP_CRYPTKEY,$I,1);
    $DH=decrypt_webpanel_char($CH,$KH,$I);
    $N=$N.$DH;
   }
   return $N;
  } else return $S;
 }

 function crypt_webpanel_string_by_key($S,$CRYPTKEY){
  global $EPP_NOCRYPT;
  if ($CRYPTKEY=="") {
   return $S;
  } else if (!$EPP_NOCRYPT){
   $I=0;
   $L=strlen($S);
   $CH="";
   $N="";
   for ($I=0; $I<$L; $I++) { 
    $CH=substr($S,$I,1);
    $KH=substr($CRYPTKEY,$I,1);
    $DH=crypt_webpanel_char($CH,$KH,$I);
    $N=$N.$DH;
   }
   return addslashes($N);
  } else return $S;
 }

 function decrypt_webpanel_string_by_key($S,$CRYPTKEY){
  global $EPP_NOCRYPT;
  if ($CRYPTKEY=="") {
   return $S;
  } else if (!$EPP_NOCRYPT){
   $S=stripslashes($S);
   $I=0;
   $L=strlen($S);
   $CH="";
   $N="";
   for ($I=0; $I<$L; $I++) { 
    $CH=substr($S,$I,1);
    $KH=substr($CRYPTKEY,$I,1);
    $DH=decrypt_webpanel_char($CH,$KH,$I);
    $N=$N.$DH;
   }
   return $N;
  } else return $S;
 }

 function in_str($str,$search){
  if (($str!="")&&($search=="")) return TRUE;
   else if (($str=="")&&($search=="")) return FALSE;
    else {
     $str=strtolower($str);
     $search=strtolower($search);
     $pos = strpos($str, $search);
     if ($pos === FALSE) return FALSE; else return TRUE;
    }
 }

 function extract_tld($DOMAIN){
  $FOUND=FALSE;
  $NEWSTR="";
  $L=strlen($DOMAIN);
  for ($i=0; $i<=$L; $i++) { 
   $CH=substr($DOMAIN,$i,1);
   if ($CH==".") $FOUND=TRUE;
   if ($FOUND) $NEWSTR.=$CH;
  }
  return strtolower($NEWSTR);
 }

 function extract_tld_nodot($DOMAIN){
  $FOUND=FALSE;
  $NEWSTR="";
  $L=strlen($DOMAIN);
  for ($i=0; $i<=$L; $i++) { 
   $CH=substr($DOMAIN,$i,1);
   if ($CH==".") $FOUND=TRUE;
   if ($FOUND) {
    if ($CH!=".") $NEWSTR.=$CH;
   }
  }
  return strtolower($NEWSTR);
 }

 function remove_tld($DOMAIN){
  $n=strlen($DOMAIN);
  $i=$n;
  $c=0;
  $ch="";
  while (($i>=0)&&($ch!=".")) {
   $i--;
   $c++;
   $ch=substr($DOMAIN,$i,1);
  }
  return substr($DOMAIN,0,$i);
 }

 function create_contactID($PREFIX,$ID,$POSTFIX){
  global $epp_contactid_lenght;
  $CIDL=$epp_contactid_lenght;
  if ($CIDL<8) $CIDL=8;
  if ($CIDL>16) $CIDL=16;
  $SID="".$ID;
  $LP=strlen($PREFIX);
  $LID=strlen($SID);
  $LPF=strlen($POSTFIX);
  $TOTZEROS=$CIDL-$LP-$LID-$LPF;
  $C=0;
  while ($C<$TOTZEROS) {
   $C++;
   $SID="0".$SID;
  }
  $NID=$PREFIX.$SID.$POSTFIX;
  return $NID;
 }

 #########################################################################################################################
 # funzioni generiche per gestire files di testo 01/01/2004
 #########################################################################################################################

 function Get_TextFile($FileName){
  $FileOpen=@fopen($FileName,"r");
  $Text=fread($FileOpen,filesize($FileName));
  fclose($FileOpen);
  return $Text;
 }

 function File_Get_Text(&$f){
  $C="";
  $Str="";
  while ( (!feof($f)) && ( ($C!=chr(13))&&($C!=chr(10)) ) ){
   $C=fgetc($f);
   if (($C!=chr(13))&&($C!=chr(10))) $Str.=$C;
  }
  if ( ($C==chr(13)) && (!feof($f)) ) $C=fgetc($f);
  return $Str;
 }

 function File_Open(&$f,$filename,$mode){
  $f=fopen($filename,$mode);
 }

 function File_Eof(&$f){
  if (feof($f)) return TRUE;
   else return FALSE;
 }

 function File_Close(&$f){
  fclose($f);
 }
 
 function File_ReWrite($FileName){
  global $REQUEST_URI;
  $c=count_ch($REQUEST_URI,"/")-1;
  $Path="";
  for ($i=1; $i<=$c; $i++) $Path.="../";
  $FileName=$Path.$FileName;
  $f=fopen($FileName,"w+");
  fputs($f,$Str);
  fclose($f);
 }

 function File_Append($FileName,$Str){
  global $REQUEST_URI;
  $c=count_ch($REQUEST_URI,"/")-1;
  $Path="";
  for ($i=1; $i<=$c; $i++) $Path.="../";
  $FileName=$Path.$FileName;
  $Str.=chr(13).chr(10);
  if (file_exists($FileName)){
   $f=fopen($FileName,"a+");
   fputs($f,$Str);
   fclose($f);
  } else {
   $f=fopen($FileName,"w+");
   fputs($f,$Str);
   fclose($f);
  }
 }

?>