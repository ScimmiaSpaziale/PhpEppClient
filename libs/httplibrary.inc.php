<?
 ########################################################################
 #                                                                      #
 # "Http Ceglia Tools" - version 1.4                                    #
 # Useful Functions and Tools for http Registrar Operations             #
 #                                                                      #
 # Copyright (C) 2009 - 2010 by Giovanni Ceglia                         #
 #                                                                      #
 # This file is part of "http Ceglia Tools".                            #
 #                                                                      #
 # "Http Ceglia Tools" is free software: you can redistribute it and/or #
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

 ##################################################################
 # Funzioni aggiornate 10/06/2009
 ##################################################################

 function OpenConnection(&$sock){
  global $http_ssl, $http_timeout, $http_server, $http_port, $http_http;
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  $host=$http_server;
  $port=$http_port;
  $timeout = $http_timeout;
  if ($http_ssl) $hostname = "ssl://".$host; else $hostname=$host;
  if ($http_http=="CLOSE") $sock=fsockopen($hostname,$port,$errno,$errstr,$timeout);
   else $sock=pfsockopen($hostname,$port,$errno,$errstr,$timeout);
  if (!$sock) {
   echo "$errstr ($errno)<br>";
   return FALSE;
   die();
  } else return TRUE;
 }

 function CloseConnection(&$sock){
  fclose($sock);
 }

 ##################################################################
 # Funzioni Test Functions
 ##################################################################

 function PlainSendCmd(&$sock,$data){
  $rs=fwrite($sock,strlen($httpdata));
  return $rs;
 }

 ##################################################################
 # Funzioni TCP
 ##################################################################

 function TcpSendCmd(&$sock,$data){
  $rs=fwrite($sock,pack('N',(strlen($data)+4)).$data);
  return $rs;
 }
 
 function TcpGetFrame(&$sock) {
  if (feof($sock)) printConnError(1);
  $hdr = fread($sock, 4);
  if (empty($hdr) && feof($sock)) {
   printConnError(1);
  } elseif (empty($hdr)) {
   printConnError(2);
  } else {
   $unpacked = unpack('N', $hdr);
   $length = $unpacked[1];
   if ($length<5) {
    printConnError(3);
   } else {
    $L=$length-4;
    if (($L>4096)||($L<0)) return "";
     else return fread($sock,$L);
   }
  }
 }

 function TcpGetFrameEOF(&$sock){
  $cnt=0;
  $dataread="";
  while ((!feof($sock))&&($cnt<4096)){
   $dataread.=fread($sock,1);
   $cnt++;
  }
  return $dataread;
 }

 ##################################################################
 # Funzioni http Over HTTP
 ##################################################################

 function HttpGetTxt(&$pos,$txt){
  $e="";
  $ch="";
  $l=strlen($txt);
  while (($ch!=chr(13))&&($pos<=$l)){
   $ch=substr($txt,$pos,1);
   $e.=$ch;
   $pos++;
  }
  return trim($e);
 }

 function HttpGetChunk(&$sock,&$dataread){
  $chunk=fgets($sock);
  $ln=hexdec($chunk);
  $dataread.=fread($sock,$ln);
  $CRLF=fread($sock,2);
  $dataread.=$CRLF;
  if ($ln==0) return FALSE;
   else return TRUE;
 }

 function HttpGetFrame(&$sock){
  $dataread="";
  $CHUNKED_ENCODING=FALSE;
  $IS_HTTP_HEADER=TRUE; 
  while ((!feof($sock))&&($IS_HTTP_HEADER)){
   $dataline=fgets($sock);
   $dataread.=$dataline;
   if (trim($dataline)=="") $IS_HTTP_HEADER=FALSE;
  }
  $HEADING_LENGTH=strlen($dataread);
  $CONTENT_ENCODING_POS=strpos($dataread,"Transfer-Encoding:")+19;
  $CONTENT_ENCODING_VALUE=HttpGetTxt($CONTENT_ENCODING_POS,$dataread);
  if($CONTENT_ENCODING_VALUE=="chunked") $CHUNKED_ENCODING=TRUE;
  if ($CHUNKED_ENCODING){
   while ($CHUNKED_ENCODING) {
    $CHUNKED_ENCODING=HttpGetChunk($sock,$dataread);
   }
  } else {
   $CONTENT_LENGTH_POS=strpos($dataread,"Content-Length:")+16;
   $CONTENT_LENGTH_VALUE=HttpGetTxt($CONTENT_LENGTH_POS,$dataread);
   if (!feof($sock)) $dataread.=fread($sock,$CONTENT_LENGTH_VALUE);
  }
  $LN=strlen($dataread);
  $CHECK=strpos($dataread, "Connection: close");
  if (($CHECK>0) && ($CHECK<$LN)) OpenConnection($sock);
  return $dataread;
 }

 ##########################################################################
 # Funzione aggiornata 10/07/2009, con supporto per Cookie/Sessioni Http. #
 ##########################################################################

 function HttpPostCommand(&$sock,$data){
  global $http_openssl_cert, $http_openssl_conf, $http_openssl_expiring, $http_openssl_passphrase, $http_openssl_pubkey;
  global $http_postemail_active,$http_postemail_to,$http_postemail_from;
  global $http_clientname, $http_clienthost, $http_http, $LANGUAGE;
  global $http_SESSIONID, $http_opensession, $http_server;
  if ($http_openssl_cert){
   define("OPEN_SSL_CONF_PATH", $http_openssl_conf);
   define("OPEN_SSL_CERT_DAYS_VALID", $http_openssl_expiring);
   define("OPEN_SSL_PASSPHRASE", $http_openssl_passphrase);
   define("OPEN_SSL_PUBKEY_PATH", $http_openssl_pubkey);
  }
  $http="POST / HTTP/1.1\r\n";
  $http.="Host: $http_server\r\n";
  if ($http_opensession) { $http.="Cookie: $http_SESSIONID\r\n"; }
  $http.="Referer: $http_clientname\r\n";
  $http.="Content-type: application/x-www-form-urlencoded\r\n";
  $http.="Content-length: ".strlen($data)."\r\n";
  if ($http_http=="CLOSE") {
   $http.="Connection: close\r\n";
  } else {
   $http.="Connection: Keep-Alive\r\n";
   $http.="Keep-Alive: 100\r\n";
  }
  $http.="\r\n";
  fputs($sock,$http.$data);
  if ($http_postemail_active) {
   $TO_B=$http_postemail_to;
   $FROM=$http_postemail_from;
   mail($TO_B,"$LANGUAGE[548]",$http.$data,"From:".$FROM);
  } 
 }

 function HttpPostCMD_NoCookie(&$sock,$data){
  global $http_clientname, $http_clienthost, $http_http;
  global $http_SESSIONID, $http_opensession, $http_server;
  fputs($sock,"POST / HTTP/1.1\r\n");
  fputs($sock,"Host: $http_server\r\n");
  fputs($sock,"Referer: $http_clientname\r\n");
  fputs($sock,"Content-type: application/x-www-form-urlencoded\r\n");
  fputs($sock,"Content-length: ".strlen($data)."\r\n");
  if ($http_http=="CLOSE") {
   fputs($sock,"Connection: close\r\n");
  } else {
   fputs($sock,"Connection: Keep-Alive\r\n");
   fputs($sock,"Keep-Alive: 100\r\n");
  }
  fputs($sock,"\r\n");
  fputs($sock,$data);
 }

 ##################################################################
 # Funzioni http Basic Transport
 ##################################################################

 function HttpGetResponse(&$sock){
  return HttpGetFrame($sock);
 }

 function HttpPostCMD($sock,$data){
  global $http_postemail_active, $http_postemail_to, $http_postemail_from, $LANGUAGE;
  $T=time();
  if ($http_postemail_active) {
   $TO_B=$http_postemail_to;
   $FROM=$http_postemail_from;
   mail($TO_B,"$LANGUAGE[547]",$data,"From:".$FROM);
  } 
  HttpPostCommand($sock,$data);
 }
?>