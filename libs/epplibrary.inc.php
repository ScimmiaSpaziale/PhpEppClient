<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 1.4                                     #
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

 ##################################################################
 # Funzioni aggiornate 10/06/2009
 ##################################################################

 function printConnError($error){
  global $LANGUAGE;
  if ($error==1) echo "$LANGUAGE[335]";
   elseif ($error==2) echo "$LANGUAGE[336] $php_errormsg."; 
   elseif ($error==3) echo "$LANGUAGE[337]"; 
   elseif ($error==4) echo "$LANGUAGE[339]"; 
    else echo "$LANGUAGE[338]";
  die();
 }

 function epp_SelectServer($SERVER){
  global $epp_server;
  $epp_server=$SERVER;
 }

 function SocketOpenConnection(&$whoissock, $source_client){
  global $whois_timeout, $whois_server, $whois_port, $whois_timeout_seconds, $whois_timeout_milliseconds;
  $whoissock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  socket_bind($whoissock, $source_client);
  socket_set_option(
   $whoissock, SOL_SOCKET, SO_SNDTIMEO, array('sec'=>$whois_timeout_seconds, 'usec' => $whois_timeout_milliseconds)
  );
  $CONN=@socket_connect($whoissock, $whois_server, $whois_port);
  if ($CONN) return TRUE; else return FALSE;
 }

 function eppOpenConnection(&$eppsock){
  global $epp_ssl, $epp_timeout, $epp_server, $epp_port, $epp_http, $epp_usecurl, $TCP_IP_BINDING, $LANGUAGE;

  $source_client="$TCP_IP_BINDING";
  if ($TCP_IP_BINDING!="") {
   echo "$LANGUAGE[582] <b>$source_client</b> <br>";
   $eppsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
   socket_bind($eppsock, $source_client);
  }

  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   get_eppserver_info($IDES,$TLD,$DESC,$ADDRESS,$USERNAME,$PASSWORD,$PROTO,$PORT);
   $host=$ADDRESS;
   $port=$PORT;
  } else {
   $host=$epp_server;
   $port=$epp_port;
  }
  $timeout = $epp_timeout;
  if ($epp_ssl) $hostname = "ssl://".$host; else $hostname=$host;
  if ($epp_usecurl) {
   eppCurlOpenConnection($eppsock);
  } else {
   
   if ($TCP_IP_BINDING!="") {
    $socket_options = array('socket'=>array('bindto'=>"$source_client"));
    $socket_context = stream_context_create($socket_options);
    print_r($socket_options);
    $eppsock = stream_socket_client("$hostname:$port",$errno,$errstr,$timeout,STREAM_CLIENT_CONNECT,$socket_context);
   } else {
    if ($epp_http=="CLOSE") $eppsock=fsockopen($hostname,$port,$errno,$errstr,$timeout);
     else $eppsock=pfsockopen($hostname,$port,$errno,$errstr,$timeout);
   }

   if (!$eppsock) {
    echo "$errstr ($errno)<br>";
    return FALSE;
    die();
   } else {
    echo "$LANGUAGE[583] $hostname:$port<br>";
    return TRUE;
   }
  }
 }

 function eppOpenConnectionUser(&$eppsock,$IDADMIN){
  global $epp_ssl, $epp_timeout, $epp_server, $epp_port, $epp_http, $epp_usecurl, $TCP_IP_BINDING, $LANGUAGE;

  $source_client="$TCP_IP_BINDING";
  if ($TCP_IP_BINDING!="") {
   echo "$LANGUAGE[582] <b>$source_client</b> <br>";
   $eppsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
   socket_bind($eppsock, $source_client);
  }

  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   get_eppserver_info($IDES,$TLD,$DESC,$ADDRESS,$USERNAME,$PASSWORD,$PROTO,$PORT);
   $host=$ADDRESS;
   $port=$PORT;
  } else {
   $host=$epp_server;
   $port=$epp_port;
  }
  if ($epp_usecurl) {
   eppCurlOpenConnection($eppsock);
  } else {
   $timeout = $epp_timeout;
   if ($epp_ssl) $hostname = "ssl://".$host; else $hostname=$host;
   if ($epp_http=="CLOSE") $eppsock=fsockopen($hostname,$port,$errno,$errstr,$timeout);
    else $eppsock=pfsockopen($hostname,$port,$errno,$errstr,$timeout);
   if (!$eppsock) {
    echo "$errstr ($errno)<br>";
    return FALSE;
    die();
   } else return TRUE;
  }
 }

 function eppCloseConnection(&$eppsock){
  global $epp_usecurl;
  if ($epp_usecurl) {
   eppCurlOpenConnection($eppsock);
  } else {
   fclose($eppsock);
  }
 }

 ##################################################################
 # Funzioni EPP Caricamento XML
 ##################################################################

 function eppReadXMLSchemeOldVer($xmlfilename){
  global $tld_dir;
  $xml=""; 
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   $db_tld=get_eppserver_tld($IDES);
   $tld_dir=$db_tld;
  }
  $filename="XML-EPP/$tld_dir/$xmlfilename.xml";
  if (!file_exists($filename)){
   $filename="../$filename";
  }
  if (file_exists($filename)){
   $fo=fopen($filename,"r");
   $FL=filesize($filename);
   if ($FL>0) $xml=fread($fo,$FL);
   fclose($fo);
  }
  return $xml;
 }

 function eppReadXMLScheme($xmlfilename){
  global $tld_dir,$epp_xml_path,$LANGUAGE;
  $xml=""; 
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   $db_tld=get_eppserver_tld($IDES);
   $tld_dir=$db_tld;
  }
  $filename="XML-EPP/$tld_dir/$xmlfilename.xml";
  if (!file_exists($filename)) $filename="../$filename";
  if (!file_exists($filename)) $filename=$epp_xml_path."XML-EPP/$tld_dir/$xmlfilename.xml";
  if (!file_exists($filename)) $filename="../$filename";
  if (file_exists($filename)){
   $fo=fopen($filename,"r");
   $FL=filesize($filename);
   if ($FL>0) $xml=fread($fo,$FL);
   fclose($fo);
  } else {
   echo "$LANGUAGE[550]";
   die();
  }
  return $xml;
 }

 ##################################################################
 # Funzioni EPP Test Functions
 ##################################################################

 function eppPlainSendCommand(&$eppsock,$xml){
  $httpxml="$xml";
  $rs=fwrite($eppsock,strlen($httpxml));
  return $rs;
 }

 function xml_is_greeting($XML){
  $A=strpos($XML,"<greeting>");
  if ($A===false) return FALSE;
   else return TRUE;
 }

 ##################################################################
 # Funzioni EPP Over TCP
 ##################################################################

 function eppTcpSendCommand(&$eppsock,$xml){
  $rs=fwrite($eppsock,pack('N',(strlen($xml)+4)).$xml);
  sleep(1);
  return $rs;
 }
 
 function eppTcpGetFrame(&$eppsock) {
  if (feof($eppsock)) printConnError(1);
  $hdr = fread($eppsock, 4);
  if (empty($hdr) && feof($eppsock)) {
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
    if (($L>4096)||($L<=0)) return "";
     else return fread($eppsock,$L);
   }
  }
 }

 function eppTcpGetFrameEOF(&$eppsock){
  $cnt=0;
  $xmlread="";
  while ((!feof($eppsock))&&($cnt<4096)){
   $xmlread.=fread($eppsock,1);
   $cnt++;
  }
  return $xmlread;
 }

 ##################################################################
 # Funzioni EPP Over HTTP
 ##################################################################

 function eppHttpGetTextString(&$pos,$txt){
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

 function eppHttpGetChunk(&$eppsock,&$xmlread){
  $chunk=fgets($eppsock);
  $ln=hexdec($chunk);
  if ($ln>0) $xmlread.=fread($eppsock,$ln);
  $CRLF=fread($eppsock,2);
  $xmlread.=$CRLF;
  if ($ln==0) return FALSE;
   else return TRUE;
 }

 function eppHttpGetFrame(&$eppsock){
  $xmlread="";
  $CHUNKED_ENCODING=FALSE;
  $IS_HTTP_HEADER=TRUE; 
  while ((!feof($eppsock))&&($IS_HTTP_HEADER)){
   $xmlline=fgets($eppsock);
   $xmlread.=$xmlline;
   if (trim($xmlline)=="") $IS_HTTP_HEADER=FALSE;
  }
  $HEADING_LENGTH=strlen($xmlread);
  $CONTENT_ENCODING_POS=strpos($xmlread,"Transfer-Encoding:")+19;
  $CONTENT_ENCODING_VALUE=eppHttpGetTextString($CONTENT_ENCODING_POS,$xmlread);
  if($CONTENT_ENCODING_VALUE=="chunked") $CHUNKED_ENCODING=TRUE;
  if ($CHUNKED_ENCODING){
   while ($CHUNKED_ENCODING) {
    $CHUNKED_ENCODING=eppHttpGetChunk($eppsock,$xmlread);
   }
  } else {
   $CONTENT_LENGTH_POS=strpos($xmlread,"Content-Length:")+16;
   $CONTENT_LENGTH_VALUE=eppHttpGetTextString($CONTENT_LENGTH_POS,$xmlread);
   if (!feof($eppsock)) {
    if ($CONTENT_LENGTH_VALUE>0) $xmlread.=fread($eppsock,$CONTENT_LENGTH_VALUE);
   }
  }
  $LN=strlen($xmlread);
  $CHECK=strpos($xmlread, "Connection: close");
  if (($CHECK>0) && ($CHECK<$LN)) eppOpenConnection($eppsock);
  return $xmlread;
 }

 ##########################################################################
 # Funzione aggiornata 10/07/2009, con supporto per Cookie/Sessioni Http. #
 ##########################################################################

 function eppHttpSendCommand(&$eppsock,$xml){
  global $epp_openssl_cert, $epp_openssl_conf, $epp_openssl_expiring, $epp_openssl_passphrase, $epp_openssl_pubkey;
  global $epp_postemail_active, $epp_postemail_to, $epp_postemail_from;
  global $epp_clientname, $epp_clienthost, $epp_http, $LANGUAGE;
  global $epp_SESSIONID, $epp_opensession, $epp_server;
  if ($epp_openssl_cert){
   define("OPEN_SSL_CONF_PATH", $epp_openssl_conf);
   define("OPEN_SSL_CERT_DAYS_VALID", $epp_openssl_expiring);
   define("OPEN_SSL_PASSPHRASE", $epp_openssl_passphrase);
   define("OPEN_SSL_PUBKEY_PATH", $epp_openssl_pubkey);
  }
  
  ##############################################################################################
  # Codice per risolvere un probabile Bug su alcune distro Linux:
  ##############################################################################################
 
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   get_eppserver_info($IDES,$TLD_TMP,$DESC_TMP,$ADDRESS_TMP,$USERNAME_TMP,$PASSWORD_TMP,$PROTO_TMP,$PORT_TMP);
   $epp_server=$ADDRESS_TMP;
  }

  ##############################################################################################

  $http="POST / HTTP/1.1\r\n";
  $http.="Host: $epp_server\r\n";
  if ($epp_opensession) { $http.="Cookie: $epp_SESSIONID\r\n"; }
  $http.="Referer: $epp_clientname\r\n";
  $http.="Content-type: application/x-www-form-urlencoded\r\n";
  $http.="Content-length: ".strlen($xml)."\r\n";
  if ($epp_http=="CLOSE") {
   $http.="Connection: close\r\n";
  } else {
   $http.="Connection: Keep-Alive\r\n";
   $http.="Keep-Alive: 100\r\n";
  }
  $http.="\r\n";
  fputs($eppsock,$http.$xml);
  if ($epp_postemail_active) {
   $TO_B=$epp_postemail_to;
   $FROM=$epp_postemail_from;
   mail($TO_B,"$LANGUAGE[548]",$http.$xml,"From:".$FROM);
  } 
 }

 function eppHttpSendCommandOldVersion(&$eppsock,$xml){
  global $epp_clientname, $epp_clienthost, $epp_http;
  global $epp_SESSIONID, $epp_opensession, $epp_server;

  fputs($eppsock,"POST / HTTP/1.1\r\n");
  fputs($eppsock,"Host: $epp_server\r\n");
  if ($epp_opensession) {
   fputs($eppsock,"Cookie: $epp_SESSIONID\r\n");
  }
  fputs($eppsock,"Referer: $epp_clientname\r\n");
  fputs($eppsock,"Content-type: application/x-www-form-urlencoded\r\n");
  fputs($eppsock,"Content-length: ".strlen($xml)."\r\n");
  if ($epp_http=="CLOSE") {
   fputs($eppsock,"Connection: close\r\n");
  } else {
   fputs($eppsock,"Connection: Keep-Alive\r\n");
   fputs($eppsock,"Keep-Alive: 100\r\n");
  }
  fputs($eppsock,"\r\n");
  fputs($eppsock,$xml);
 }

 function eppHttpSendCommand_nocookie(&$eppsock,$xml){
  global $epp_clientname, $epp_clienthost, $epp_http;
  global $epp_SESSIONID, $epp_opensession, $epp_server;
  fputs($eppsock,"POST / HTTP/1.1\r\n");
  fputs($eppsock,"Host: $epp_server\r\n");
  fputs($eppsock,"Referer: $epp_clientname\r\n");
  fputs($eppsock,"Content-type: application/x-www-form-urlencoded\r\n");
  fputs($eppsock,"Content-length: ".strlen($xml)."\r\n");
  if ($epp_http=="CLOSE") {
   fputs($eppsock,"Connection: close\r\n");
  } else {
   fputs($eppsock,"Connection: Keep-Alive\r\n");
   fputs($eppsock,"Keep-Alive: 100\r\n");
  }
  fputs($eppsock,"\r\n");
  fputs($eppsock,$xml);
 }

 ##################################################################
 # Funzioni EPP Over HTTP Tramite Curl Con Certificati
 ##################################################################

 function eppCurlOpenConnection(&$ch){
  $ch=curl_init();
 }

 function eppCurlCloseConnection(&$ch){
  curl_close($ch);
 }

 function eppCurlGetFrame(&$ch){
  global $LANGUAGE;
  $xmlread=curl_exec($ch);
  if ($xmlread===false){ 
   echo "<b>".curl_error($ch)."</b><br>"; 
   printConnError(4);
  }
  return $xmlread;
 }

 function eppCurlSendCommand(&$ch,$xml){
  global $epp_clientname, $epp_clienthost, $epp_http;
  global $epp_SESSIONID, $epp_opensession, $epp_server;
  global $epp_usecurl, $epp_sslcert, $epp_sslcert_file;
  global $epp_sslcert_privatekey, $epp_sslcert_keypassword;
  global $epp_curl_session_logs;
  $ckfile = $epp_curl_session_logs."/curl_session_".session_id();
  curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch,CURLOPT_SSLCERT,$epp_sslcert_file);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_USERAGENT,$epp_clientname);
  curl_setopt($ch,CURLOPT_POST,false);
  curl_setopt($ch,CURLOPT_URL,"https://$epp_server");
  curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
 }

 ##################################################################
 # Funzioni EPP Over SMTP
 ##################################################################

 function eppSmtpGetFrame(&$eppsock){
  return "";
 }

 function eppSmtpSendCommand($eppsock,$xml){
  global $epp_clientname, $epp_clienthost;
 }

 ##################################################################
 # Funzioni EPP Basic Transport
 ##################################################################

 function eppGetFrame(&$eppsock){
  global $epp_prot, $epp_usecurl;
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   $epp_prot=get_eppserver_proto($IDES);
  }
  if ($epp_usecurl) {
   return eppCurlGetFrame($eppsock);
  } else if ($epp_prot=="TCP") {
   $xml=eppTcpGetFrame($eppsock);
   if (xml_is_greeting($xml)) {
    return eppTcpGetFrame($eppsock);
   } else return $xml;
  } else if ($epp_prot=="HTTP") {
   return eppHttpGetFrame($eppsock);
  } else if ($epp_prot=="SMTP") {
   return eppSmtpGetFrame($eppsock);
  } else if ($epp_prot=="TCP2") {
   return eppTcpGetFrame($eppsock);
  }
 }

 function eppSendCommand($eppsock,$xml){
  global $epp_prot, $epp_postemail_active, $epp_postemail_to, $epp_postemail_from, $epp_usecurl,$LANGUAGE;
  $T=time();
  DbQuery("UPDATE epp_sessions SET updated='$T' WHERE status='Open'");
  DbQuery("UPDATE epp_psessions SET updated='$T' WHERE status='Open'");
  $IDADMIN=id_active_user();
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   $epp_prot=get_eppserver_proto($IDES);
  }
  if ($epp_postemail_active) {
   $TO_B=$epp_postemail_to;
   $FROM=$epp_postemail_from;
   mail($TO_B,"$LANGUAGE[547]",$xml,"From:".$FROM);
  } 
  if ($epp_usecurl) {
   eppCurlSendCommand($eppsock,$xml);
  } else if (($epp_prot=="TCP")||(($epp_prot=="TCP2"))) {
   eppTcpSendCommand($eppsock,$xml);
  } else if ($epp_prot=="HTTP") {
   eppHttpSendCommand($eppsock,$xml);
  } else if ($epp_prot=="SMTP") {
   eppSmtpSendCommand($eppsock,$xml);
  }
 }
?>