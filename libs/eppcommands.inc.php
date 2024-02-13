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


 #################################
 # Funzioni Aggiunte 10/07/2009
 #################################

 function epp_queued_ns_update(&$eppsock,$IDD){
  global $LANGUAGE;
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  $xml=epp_domain_info($eppsock, $DOMAIN);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  xml_get_domain_info_ns($xml,$OLD_NS1,$OLD_NS2,$OLD_NS3,$OLD_NS4,$OLD_NS5,$OLD_NS6);
  $REMOVEOLD=TRUE;
  $xml=epp_update_nameservers($eppsock, $DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $OLD_NS1, $OLD_NS2, $OLD_NS3, $OLD_NS4, $OLD_NS5, $OLD_NS6, $REMOVEOLD);
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE==1000) {
   webpanel_logs_add("EppProto","$LANGUAGE[502] $DOMAIN.");
   update_domain_updating($IDD);
  } else if ($RESCODE==1001) {
   webpanel_logs_add("EppProto","$LANGUAGE[503] $DOMAIN.");
   update_domain_updating($IDD);
  } else {
   webpanel_logs_add("EppProto","$LANGUAGE[504] $DOMAIN, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
  }
 }

 #################################
 # Funzioni Aggiunte 10/07/2009
 #################################

 function epp_http_get_sessionID($xml){
  $S="Set-Cookie:";
  $L=strlen($S);
  $LMAX=strlen($xml); 
  $L1=strpos($xml,"Set-Cookie:")+$L;
  $L2=$L1;
  $CH="";
  while (($CH!=";")&&($L2<=$LMAX)) {
   $L2++;
   $CH=substr($xml,$L2,1);
  }
  $N=$L2-$L1;
  $ID=trim(substr($xml,$L1,$N));
  return $ID;
 }

 function epp_OpenSession(&$eppsock){
  global $epp_SESSIONID, $epp_opensession;
  $xml=epp_login($eppsock);
  $epp_SESSIONID=epp_http_get_sessionID($xml);
  $epp_opensession=TRUE;
  return $epp_SESSIONID;
 }

 function epp_CloseSession(&$eppsock){
  global $epp_SESSIONID, $epp_opensession;
  $xml=epp_logout($eppsock);
  $epp_opensession=FALSE;
 }

 function epp_SelectSession($SESSIONID){
  global $epp_SESSIONID, $epp_opensession;
  $epp_SESSIONID=$SESSIONID;
  $epp_opensession=TRUE;
 }

 #################################
 # Funzioni Aggiunte 09/07/2009
 #################################

 function epp_domain_create(&$eppsock, $DOMAIN, $IDREG, $IDADM, $IDTECH, $NS1, $NS2, $NS3, $NS4, $NS5, $AUTHCODE, $YEARS){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("create-domain-private-user");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  $NSADD="";
  if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName></domain:hostAttr>\n";
  if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName></domain:hostAttr>\n";
  if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName></domain:hostAttr>\n";
  if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName></domain:hostAttr>\n";
  if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName></domain:hostAttr>\n";
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[REGISTRANT-ID]",$IDREG);
  xml_set_variable($xml,"[ADMIN-ID]",$IDADM);
  xml_set_variable($xml,"[TECH-ID]",$IDTECH);
  xml_set_variable($xml,"[DOMAIN-YEARS]",$YEARS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_create_no_ns(&$eppsock, $DOMAIN, $IDREG, $IDADM, $IDTECH, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $AUTHCODE, $YEARS){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("create-domain-no-ns");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  $NSADD="";
  if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName></domain:hostAttr>\n";
  if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName></domain:hostAttr>\n";
  if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName></domain:hostAttr>\n";
  if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName></domain:hostAttr>\n";
  if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName></domain:hostAttr>\n";
  if ($NS6!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS6</domain:hostName></domain:hostAttr>\n";
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[REGISTRANT-ID]",$IDREG);
  xml_set_variable($xml,"[ADMIN-ID]",$IDADM);
  xml_set_variable($xml,"[TECH-ID]",$IDTECH);
  xml_set_variable($xml,"[DOMAIN-YEARS]",$YEARS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_start_transfer_new_registrant(&$eppsock, $DOMAIN, $AUTHCODE, $NEWID, $NEWAUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $AUTHCODE=escape_special_chars($AUTHCODE);
  $xml=eppReadXMLScheme("transfer-domain-new-registrant");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[CONTACT-ID]",$NEWID);
  xml_set_variable($xml,"[NEWAUTHCODE]",$NEWAUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_check(&$eppsock, $ID){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("check-contact");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_check_list(&$eppsock, $IDLIST, $N){
  global $epp_clTRID;
  $IDL="";
  for ($i=1; $i<=$N; $i++) {
   $IDL=$IDL."<contact:id>$IDLIST[$i]</contact:id>".chr(13).chr(10);
  }  
  $xml=eppReadXMLScheme("check-contact-list");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACTLIST]",$IDL);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_check_list(&$eppsock, $DOMLIST, $N){
  global $epp_clTRID;
  $DL="";
  for ($i=1; $i<=$N; $i++) {
   $DL=$DL."<domain:name>$DOMLIST[$i]</domain:name>".chr(13).chr(10);
  }  
  $xml=eppReadXMLScheme("check-domain-list");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAINLIST]",$DL);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_info(&$eppsock, $ID){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("info-contact");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_check(&$eppsock, $DOMAIN){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("check-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_info(&$eppsock, $DOMAIN){
  global $epp_clTRID;
  //$DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("info-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_info_authcode(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  //$DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("info-domain-authcode");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_query_transfer(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $AUTHCODE=escape_special_chars($AUTHCODE);
  $xml=eppReadXMLScheme("transfer-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_query_transfer_auth(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("transfer-domain-auth-query");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_approve_transfer(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  #$DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("transfer-domain-approve");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_cancel_transfer(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("transfer-domain-cancel");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_reject_transfer(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("transfer-domain-reject");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_start_transfer(&$eppsock, $DOMAIN, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $AUTHCODE=escape_special_chars($AUTHCODE);
  $xml=eppReadXMLScheme("transfer-domain-start");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_domain_authinfo(&$eppsock, $DOMAIN, $NEWAUTH){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-domain-authinfo");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$NEWAUTH);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_domain_new_registrant(&$eppsock, $DOMAIN, $NEWIDREG, $NEWAUTH){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-domain-new-registrant");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$NEWAUTH);
  xml_set_variable($xml,"[REGISTRANT-ID]",$NEWIDREG);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_pubblishing_consent(&$eppsock, $ID, $PUBBLISH){
  global $epp_clTRID;
  if ($PUBBLISH==0) $PUB="true"; else $PUB="false";
  $xml=eppReadXMLScheme("update-pubblishing-consent");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  xml_set_variable($xml,"[CONSENT]",$PUB);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_add_nameserver(&$eppsock, $DOMAIN, $NEWNAMESERVER){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-nameserver-add");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[NEWNAMESERVER]",$NEWNAMESERVER);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_del_nameserver(&$eppsock, $DOMAIN, $OLDNAMESERVER){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-nameserver-del");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[OLDNAMESERVER]",$OLDNAMESERVER);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_nameserver(&$eppsock, $DOMAIN, $NEWNAMESERVER, $OLDNAMESERVER){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-nameserver");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[NEWNAMESERVER]",$NEWNAMESERVER);
  xml_set_variable($xml,"[OLDNAMESERVER]",$OLDNAMESERVER);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_ns_vet(&$eppsock, $DOMAIN, &$NSVET, $NNS, &$OLDNSVET, $NOLDNS, $REMOVE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $DOMAIN_STATUS=get_domain_status_byname($DOMAIN);
  $xml=eppReadXMLScheme("update-ns");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="\n";
  $NSREM="\n";
  $NSADDCHECK=($NNS>0);
  if ($NSADDCHECK!="") {
   $NSADD.="<domain:add>\n";
   $NSADD.="<domain:ns>";
   for ($i=1; $i<=$NNS; $i++){
    $NS=$NSVET[$i][ns];
    if ($NS!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS</domain:hostName></domain:hostAttr>\n";
   }
   $NSADD.="</domain:ns>\n";
   $NSADD.="</domain:add>\n";
  }
  if (($DOMAIN_STATUS!=15)&&($REMOVE)){
   $NSREM.="<domain:rem>\n";
   $NSREM.="<domain:ns>";
   for ($i=1; $i<=$NOLDNS; $i++){
    $NS=$NSOLDVET[$i][ns];
    if ($NS!="") $NSREM.="<domain:hostAttr><domain:hostName>$NS</domain:hostName></domain:hostAttr>\n";
   }
   $NSREM.="</domain:ns>\n";
   $NSREM.="</domain:rem>\n";
  } 
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[NSREMLIST]",$NSREM);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_nsips_vet(&$eppsock, $DOMAIN, &$NSVET, $NNS, &$OLDNSVET, $NOLDNS, $REMOVE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $DOMAIN_STATUS=get_domain_status_byname($DOMAIN);
  $xml=eppReadXMLScheme("update-ns-ips");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="\n";
  $NSREM="\n";
  $NSADDCHECK=($NNS>0);
  if ($NSADDCHECK!="") {
   $NSADD.="<domain:add>\n";
   $NSADD.="<domain:ns>";
   for ($i=1; $i<=$NNS; $i++){
    $NS=$NSVET[$i][ns];
    $IPv4=$NSVET[$i][ipv4];
    $IPv6=$NSVET[$i][ipv6];
    if ($IPv4!="") $IPv4ADD="<domain:hostAddr ip=\"v4\">$IPv4</domain:hostAddr>"; else $IPv4ADD="";
    if ($IPv6!="") $IPv6ADD="<domain:hostAddr ip=\"v6\">$IPv6</domain:hostAddr>"; else $IPv6ADD="";
    if ($NS!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS</domain:hostName>".$IPv4ADD.$IPv6ADD."</domain:hostAttr>\n";
   }
   $NSADD.="</domain:ns>\n";
   $NSADD.="</domain:add>\n";
  }
  if (($DOMAIN_STATUS!=15)&&($REMOVE)){
   $NSREM.="<domain:rem>\n";
   $NSREM.="<domain:ns>";
   for ($i=1; $i<=$NOLDNS; $i++){
    $NS=$NSOLDVET[$i][ns];
    if ($NS!="") $NSREM.="<domain:hostAttr><domain:hostName>$NS</domain:hostName></domain:hostAttr>\n";
   }
   $NSREM.="</domain:ns>\n";
   $NSREM.="</domain:rem>\n";
  } 
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[NSREMLIST]",$NSREM);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_nameservers(&$eppsock, $DOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $OLDNS1, $OLDNS2, $OLDNS3, $OLDNS4, $OLDNS5, $OLDNS6, $REMOVE){
  global $epp_clTRID;
  //$DOMAIN=utf8_encode($DOMAIN);
  $DOMAIN_STATUS=get_domain_status_byname($DOMAIN);
  $xml=eppReadXMLScheme("update-ns");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="\n";
  $NSREM="\n";
  $NSADDCHECK=trim($NS1.$NS2.$NS3.$NS4.$NS5.$NS6);
  if ($NSADDCHECK!="") {
   $NSADD.="<domain:add>\n";
   $NSADD.="<domain:ns>";
   if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName></domain:hostAttr>\n";
   if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName></domain:hostAttr>\n";
   if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName></domain:hostAttr>\n";
   if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName></domain:hostAttr>\n";
   if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName></domain:hostAttr>\n"; 
   if ($NS6!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS6</domain:hostName></domain:hostAttr>\n"; 
   $NSADD.="</domain:ns>\n";
   $NSADD.="</domain:add>\n";
  }
  if (($DOMAIN_STATUS!=15)&&($REMOVE)){
   $NSREM.="<domain:rem>\n";
   $NSREM.="<domain:ns>";
   if ($OLDNS1!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS1</domain:hostName></domain:hostAttr>\n";
   if ($OLDNS2!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS2</domain:hostName></domain:hostAttr>\n";
   if ($OLDNS3!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS3</domain:hostName></domain:hostAttr>\n";
   if ($OLDNS4!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS4</domain:hostName></domain:hostAttr>\n";
   if ($OLDNS5!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS5</domain:hostName></domain:hostAttr>\n";
   if ($OLDNS6!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS6</domain:hostName></domain:hostAttr>\n";
   $NSREM.="</domain:ns>\n";
   $NSREM.="</domain:rem>\n";
  } 
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[NSREMLIST]",$NSREM);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_nameservers_full(&$eppsock, $DOMAIN, &$NS, &$OLDNS, &$IPV4, &$IPV6, $REMOVE){
  global $epp_clTRID;
  //$DOMAIN=utf8_encode($DOMAIN);
  $DOMAIN_STATUS=get_domain_status_byname($DOMAIN);
  $xml=eppReadXMLScheme("update-ns");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="\n";
  $NSREM="\n";
  $NSADDCHECK="";
  for ($i=1; $i<=6; $i++) {
   $NSVALUE=$NS[$i];
   $NSADDCHECK.=trim($NSVALUE);
  } 
  if ($NSADDCHECK!="") {
   $NSADD.="<domain:add>\n";
   $NSADD.="<domain:ns>\n";
   for ($i=1; $i<=6; $i++) {
    $IPV4ADDR="";
    $IPV6ADDR="";
    $NSVALUE=$NS[$i];
    $IPVALUE=$IPV4[$i];
    $IPV6VALUE=$IPV6[$i];
    if ($IPVALUE!="") $IPV4ADDR="<domain:hostAddr ip=\"v4\">$IPVALUE</domain:hostAddr>"; else $IPV4ADDR="";
    if ($IPV6VALUE!="") $IPV6ADDR="<domain:hostAddr ip=\"v6\">$IPV6VALUE</domain:hostAddr>"; else $IPV6ADDR="";
    if ($NSVALUE!="") $NSADD.="<domain:hostAttr><domain:hostName>$NSVALUE</domain:hostName>".$IPV4ADDR.$IPV6ADDR."</domain:hostAttr>\n";
   } 
   $NSADD.="</domain:ns>\n";
   $NSADD.="</domain:add>\n";
  }
  if (($DOMAIN_STATUS!=15)&&($REMOVE)){
   $NSREM.="<domain:rem>\n";
   $NSREM.="<domain:ns>\n";
   for ($i=1; $i<=6; $i++) {
    if ($OLDNS[$i]!="") $NSREM.="<domain:hostAttr><domain:hostName>$OLDNS[$i]</domain:hostName></domain:hostAttr>\n";
   } 
   $NSREM.="</domain:ns>\n";
   $NSREM.="</domain:rem>\n";
  } 
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[NSREMLIST]",$NSREM);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_update_nameserver_ips(&$eppsock, $DOMAIN, $NEWNAMESERVER, $IP, $OLDNAMESERVER){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("update-nameserver-ips");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[NEWNAMESERVER]",$NEWNAMESERVER);
  xml_set_variable($xml,"[OLDNAMESERVER]",$OLDNAMESERVER);
  xml_set_variable($xml,"[SERVER-IP]",$IP);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_change_registrant(&$eppsock, $DOMAIN, $IDREG, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("change-registrant");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[REGISTRANT-ID]",$IDREG);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_change_admin(&$eppsock, $DOMAIN, $IDNEWADM, $IDOLDADM){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("change-admin");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[ADMIN-ID-NEW]",$IDNEWADM);
  xml_set_variable($xml,"[ADMIN-ID-OLD]",$IDOLDADM);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_change_tech(&$eppsock, $DOMAIN, $IDNEWTECH, $IDOLDTECH){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("change-tech");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[TECH-ID-NEW]",$IDNEWTECH);
  xml_set_variable($xml,"[TECH-ID-OLD]",$IDOLDTECH);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_change_admin_registrant(&$eppsock, $DOMAIN, $IDREG, $IDADM, $AUTHCODE){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("change-admin-registrant");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[REGISTRANT-ID]",$IDREG);
  xml_set_variable($xml,"[ADMIN-ID]",$IDADM);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_remove_nameserver(&$eppsock, $DOMAIN, $NAMESERVER){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("remove-nameserver");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[NAMESERVER]",$NAMESERVER);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 #################################
 # Funzioni Aggiunte 27/06/2009
 #################################

 function epp_domain_delete(&$eppsock, $DOMAIN){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("delete-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_restore(&$eppsock, $DOMAIN){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("restore-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_delete(&$eppsock, $ID){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("delete-contact");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_set_status(&$eppsock, $ID, $STATUS){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("update-lock");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACTID]",$ID);
  xml_set_variable($xml,"[CONTACTSTATUS]",$STATUS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_update_tel(&$eppsock, $ID, $TEL){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("update-telephone");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  xml_set_variable($xml,"[TELEPHONE]",$TEL);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_update_fax(&$eppsock, $ID, $FAX){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("update-fax");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  xml_set_variable($xml,"[FAX]",$FAX);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_update_telfax(&$eppsock, $ID, $TEL, $FAX){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("update-contact-telfax");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  xml_set_variable($xml,"[TELEPHONE]",$TEL);
  xml_set_variable($xml,"[FAX]",$FAX);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_contact_update_nofee(&$eppsock, $ID, $TEL, $FAX, $PUBBLISH, 
  $ADDRESS, $ZIP, $CITY, $STATE, $COUNTRY, $EMAIL
 ){
  global $epp_clTRID;
  if ($PUBBLISH==0) $PUB="true"; else $PUB="false";
  $xml=eppReadXMLScheme("update-contact-nofee");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$ID);
  xml_set_variable($xml,"[TELEPHONE]",$TEL);
  xml_set_variable($xml,"[FAX]",$FAX);
  xml_set_variable($xml,"[CONSENT]",$PUB);
  xml_set_variable($xml,"[ADDRESS]",$ADDRESS);
  xml_set_variable($xml,"[CITY]",$CITY);
  xml_set_variable($xml,"[STATE]",$STATE);
  xml_set_variable($xml,"[ZIPCODE]",$ZIP);
  xml_set_variable($xml,"[COUNTRY]",$COUNTRY);
  xml_set_variable($xml,"[EMAIL]",$EMAIL);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_set_status(&$eppsock, $DOMAIN, $STATUS){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("set-status");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[DOMAINSTATUS]",$STATUS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_remove_status(&$eppsock, $DOMAIN, $STATUS){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("remove-status");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[DOMAINSTATUS]",$STATUS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_domain_set_status_msg(&$eppsock, $DOMAIN, $STATUS, $MSG){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("set-status-msg");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  xml_set_variable($xml,"[DOMAINSTATUS]",$STATUS);
  xml_set_variable($xml,"[STATUSMSG]",$MSG);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_newpassword(&$eppsock, $NEWPASSWORD){
  global $epp_username, $epp_password;
  $xml=eppReadXMLScheme("new-password");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[NEWPASSWORD]",$NEWPASSWORD);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_newpassword_ext(&$eppsock, $USERNAME, $PASSWORD, $NEWPASSWORD){
  $xml=eppReadXMLScheme("new-password");
  xml_set_variable($xml,"[EPPUSERNAME]",$USERNAME);
  xml_set_variable($xml,"[EPPPASSWORD]",$PASSWORD);
  xml_set_variable($xml,"[NEWPASSWORD]",$NEWPASSWORD);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_polling_ack(&$eppsock, $MSGID){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("polling-ack");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[MSGID]",$MSGID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_polling_request(&$eppsock){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("polling-request");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_logout(&$eppsock){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("logout");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_create_contact(
  &$eppsock, $CID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $PW
 ){
  global $epp_clTRID;
  $NAME=utf8_encode($NAME);
  $ORG=utf8_encode($ORG);
  $ADDRESS=utf8_encode($ADDRESS);
  $CITY=utf8_encode($CITY);
  $PW=utf8_encode($PW);
  $xml=eppReadXMLScheme("create-contact");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$CID);
  xml_set_variable($xml,"[CONTACT-NAME]",$NAME);
  xml_set_variable($xml,"[CONTACT-ORG]",$ORG);
  xml_set_variable($xml,"[ADDRESS]",$ADDRESS);
  xml_set_variable($xml,"[CITY]",$CITY);
  xml_set_variable($xml,"[STATE]",$STATE);
  xml_set_variable($xml,"[ZIPCODE]",$ZIPCODE);
  xml_set_variable($xml,"[COUNTRY]",$COUNTRY);
  xml_set_variable($xml,"[TELEPHONE]",$TEL);
  xml_set_variable($xml,"[FAX]",$FAX);
  xml_set_variable($xml,"[EMAIL]",$EMAIL);
  xml_set_variable($xml,"[PUBBLISH]",$PUB);
  xml_set_variable($xml,"[PASSWORD]",$PW);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_create_registrant(
  &$eppsock, $IDC, $CID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CF, $PW
 ){
  global $epp_clTRID;
  $NAME=utf8_encode($NAME);
  $ORG=utf8_encode($ORG);
  $ADDRESS=utf8_encode($ADDRESS);
  $CITY=utf8_encode($CITY);
  $PW=utf8_encode($PW);

  if (strlen($FAX)<7) $FAXLESS="_nofax"; else $FAXLESS=""; 

  if (trim($SCHOOLCODE)!="") {
   get_edu_extcon_xml($IDC,$NT,$TYPE,$CF,$SCHOOLCODE);
   $xml=eppReadXMLScheme("create-registrant-edu".$FAXLESS);
  } else {
   $xml=eppReadXMLScheme("create-registrant".$FAXLESS);
  }
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[CONTACT-ID]",$CID);
  xml_set_variable($xml,"[CONTACT-NAME]",$NAME);
  xml_set_variable($xml,"[CONTACT-ORG]",$ORG);
  xml_set_variable($xml,"[ADDRESS]",$ADDRESS);
  xml_set_variable($xml,"[CITY]",$CITY);
  xml_set_variable($xml,"[STATE]",$STATE);
  xml_set_variable($xml,"[ZIPCODE]",$ZIPCODE);
  xml_set_variable($xml,"[COUNTRY]",$COUNTRY);
  xml_set_variable($xml,"[TELEPHONE]",$TEL);
  xml_set_variable($xml,"[FAX]",$FAX);
  xml_set_variable($xml,"[EMAIL]",$EMAIL);
  xml_set_variable($xml,"[PUBBLISH]",$PUB);
  xml_set_variable($xml,"[CONTACT-NT]",$NT);
  xml_set_variable($xml,"[CONTACT-TYPE]",$TYPE);
  xml_set_variable($xml,"[CONTACT-CF]",$CF);
  xml_set_variable($xml,"[CONTACT-SCHOOLCODE]",$SCHOOLCODE);
  xml_set_variable($xml,"[PASSWORD]",$PW);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_create_domain(
  &$eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $REGISTRANT, $ADMIN, $TECH, $AUTHCODE
 ){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("create-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="";
  if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName></domain:hostAttr>\n";
  if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName></domain:hostAttr>\n";
  if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName></domain:hostAttr>\n";
  if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName></domain:hostAttr>\n";
  if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName></domain:hostAttr>\n";
  if ($NS6!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS6</domain:hostName></domain:hostAttr>\n";
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[REGISTRANT-ID]",$REGISTRANT);
  xml_set_variable($xml,"[ADMIN-ID]",$ADMIN);
  xml_set_variable($xml,"[TECH-ID]",$TECH);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[DOMAIN-YEARS]",$YEARS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_create_domain_idn(
  &$eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $REGISTRANT, $ADMIN, $TECH, $AUTHCODE
 ){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("create-domain");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="";
  if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName></domain:hostAttr>\n";
  if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName></domain:hostAttr>\n";
  if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName></domain:hostAttr>\n";
  if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName></domain:hostAttr>\n";
  if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName></domain:hostAttr>\n";
  if ($NS6!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS6</domain:hostName></domain:hostAttr>\n";
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[REGISTRANT-ID]",$REGISTRANT);
  xml_set_variable($xml,"[ADMIN-ID]",$ADMIN);
  xml_set_variable($xml,"[TECH-ID]",$TECH);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[DOMAIN-YEARS]",$YEARS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_create_domain_with_ips(
  &$eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $REGISTRANT, $ADMIN, $TECH, $AUTHCODE
 ){
  global $epp_clTRID;
  $DOMAIN=utf8_encode($DOMAIN);
  $xml=eppReadXMLScheme("create-domain-with-ips");
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  xml_set_variable($xml,"[DOMAIN]",$DOMAIN);
  $NSADD="";
  if ($IP1!="") $IPADDR1="<domain:hostAddr ip=\"v4\">$IP1</domain:hostAddr>"; else $IPADDR1="";
  if ($IP2!="") $IPADDR2="<domain:hostAddr ip=\"v4\">$IP2</domain:hostAddr>"; else $IPADDR2="";
  if ($IP3!="") $IPADDR3="<domain:hostAddr ip=\"v4\">$IP3</domain:hostAddr>"; else $IPADDR3="";
  if ($IP4!="") $IPADDR4="<domain:hostAddr ip=\"v4\">$IP4</domain:hostAddr>"; else $IPADDR4="";
  if ($IP5!="") $IPADDR5="<domain:hostAddr ip=\"v4\">$IP5</domain:hostAddr>"; else $IPADDR5="";
  if ($IP6!="") $IPADDR6="<domain:hostAddr ip=\"v4\">$IP6</domain:hostAddr>"; else $IPADDR6="";
  if ($NS1!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS1</domain:hostName>$IPADDR1</domain:hostAttr>\n";
  if ($NS2!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS2</domain:hostName>$IPADDR2</domain:hostAttr>\n";
  if ($NS3!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS3</domain:hostName>$IPADDR3</domain:hostAttr>\n";
  if ($NS4!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS4</domain:hostName>$IPADDR4</domain:hostAttr>\n";
  if ($NS5!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS5</domain:hostName>$IPADDR5</domain:hostAttr>\n";
  if ($NS6!="") $NSADD.="<domain:hostAttr><domain:hostName>$NS6</domain:hostName>$IPADDR6</domain:hostAttr>\n";
  xml_set_variable($xml,"[NSADDLIST]",$NSADD);
  xml_set_variable($xml,"[REGISTRANT-ID]",$REGISTRANT);
  xml_set_variable($xml,"[ADMIN-ID]",$ADMIN);
  xml_set_variable($xml,"[TECH-ID]",$TECH);
  xml_set_variable($xml,"[AUTHCODE]",$AUTHCODE);
  xml_set_variable($xml,"[DOMAIN-YEARS]",$YEARS);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 #################################
 # Funzioni aggiornate 10/06/2009
 #################################

 function epp_hello(&$eppsock,$IDADMIN){
  global $epp_prot;
  $IDES=get_servers_ides($IDADMIN);
  if ($IDES>0) {
   $epp_prot=get_eppserver_proto($IDES);
  }
  $xml=eppReadXMLScheme("hello");
  eppSendCommand($eppsock,$xml);
  if ($epp_prot!="TCP") $xml=eppGetFrame($eppsock);
   else $xml=eppTcpGetFrame($eppsock);
  return $xml;
 }

 function epp_login(&$eppsock){
  global $epp_username, $epp_password,$epp_clTRID;
  $xml=eppReadXMLScheme("login");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_login_ext(&$eppsock, $epp_username, $epp_password){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("login");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_login_db_account(&$eppsock,$IDADMIN){
  global $epp_clTRID;
  $IDES=get_servers_ides($IDADMIN);
  get_eppserver_info($IDES,$TLD,$DESC,$ADDRESS,$epp_username,$epp_password,$PROTO,$PORT);
  $xml=eppReadXMLScheme("login");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_login_newpassword(&$eppsock, $epp_newpassword){
  global $epp_username, $epp_password, $epp_clTRID;
  $xml=eppReadXMLScheme("new-password");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[NEWPASSWORD]",$epp_newpassword);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_login_newpassword_ext(&$eppsock, $epp_username, $epp_password, $epp_newpassword){
  global $epp_clTRID;
  $xml=eppReadXMLScheme("new-password");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[NEWPASSWORD]",$epp_newpassword);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }

 function epp_login_newpassword_db_account(&$eppsock, $epp_newpassword, $IDADMIN){
  global $epp_clTRID;
  $IDES=get_servers_ides($IDADMIN);
  get_eppserver_info($IDES,$TLD,$DESC,$ADDRESS,$epp_username,$epp_password,$PROTO,$PORT);
  $xml=eppReadXMLScheme("new-password");
  xml_set_variable($xml,"[EPPUSERNAME]",$epp_username);
  xml_set_variable($xml,"[EPPPASSWORD]",$epp_password);
  xml_set_variable($xml,"[NEWPASSWORD]",$epp_newpassword);
  xml_set_variable($xml,"[CLIENTTRID]",$epp_clTRID);
  eppSendCommand($eppsock,$xml);
  $xml=eppGetFrame($eppsock);
  return $xml;
 }
?>