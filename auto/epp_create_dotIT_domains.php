<?
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
 include("../libs/eppauto.inc.php");
 ConnectDB();
  session_start();

  $WAITING_DOMAINS=check_domains_waiting();
  if (!$WAITING_DOMAINS) { DisconnectDB(); die(); }

  echo "Script started.<br>";

  $ID_ADMIN=1; $ID_UTENTE=1;
  eppOpenConnection($eppsock);

  ###################################################
  # Login EPP Server                                #
  ###################################################

  echo "Login EPP.<br>";
  $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
  $RESCODE=xml_get_resultcode($xml);
  $REASONCODE=xml_get_reasoncode($xml);
  if ($RESCODE!=1000) {
   echo "$LANGUAGE[508]<br>";  die();
  } else {
   $CRD=xml_get_credit($xml);
   client_update_eppcredit($ID_ADMIN,$CRD);
   echo "Connessione avvenuta. Credito: $CRD<br>";
  }
  $SESSIONID=epp_http_get_sessionID($xml);
  epp_SelectSession($SESSIONID);
  webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

  ###################################################
  # Creazione Contatti
  ###################################################
   
  echo "Creazione Contatti.<br>";
  DBSelect("SELECT * FROM domain_contacts WHERE (status='Pending')",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r[idc]; $IDC=$ID; $CID=get_extended_id($ID); $PW="";
   get_contact_info($ID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $SEX);
   if (is_registrant($CID)){
    $xml=epp_create_registrant($eppsock, $CID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CF, $PW);
   } else {
    $xml=epp_create_contact($eppsock, $CID, $NAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $PW);
   }
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE==1000) {
    echo "Contatto $CID creato con successo.<br>";
    webpanel_logs_add("Security","$LANGUAGE[470] $CID.");
    update_contact_status($IDC,"Active");
   } else {
    echo "Contatto $CID fallimento.<br>";
    webpanel_logs_add("Security","$LANGUAGE[469] $CID, $LANGUAGE[250] $RESCODE, $LANGUAGE[251] $REASONCODE.");
    update_contact_status($IDC,"Errors");
   }
  } 

  ###################################################
  # Creazione Domini
  ###################################################

  echo "Creazione Domini .IT.<br>";
  DBSelect("SELECT * FROM t_payservice_auto WHERE (idstatus=4) AND (iddomain>0)",$rs);
  while (NextRecord($rs,$r)) {
   $IDDOMAIN=$r[iddomain]; $YEARS=1;
   $DOMAIN=get_domain($IDDOMAIN);
   $ID=find_epp_id($DOMAIN); 
   get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
   get_domain_dnsinfo($ID, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
   $UT=get_usertype($IDREG);
   if ($UT==1) { $IDADM=$IDREG; } 

   echo "<pre>Domain: $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $IDREG, $IDADM, $IDTECH, $EPPCODE</pre>";
  
   $xml=epp_create_domain($eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $IDREG, $IDADM, $IDTECH, $EPPCODE);
   echo "<pre>$xml</pre>";
   $RESCODE=xml_get_resultcode($xml); $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE==1000) {
    echo "Creazione dominio: $DOMAIN avvenuta con successo.<br>";
    webpanel_logs_add("EppProto","$LANGUAGE[437] $DOMAIN.");
    update_domain_status($ID,15);
    update_domain_creation($ID);
    DBQuery("UPDATE t_payservice_auto SET idstatus=6 WHERE iddomain=$IDDOMAIN");
    DBQuery("UPDATE t_payservice_domains SET idstatus=1, domain_status=2 WHERE iddomain=$IDDOMAIN");
   } else {
    echo "Creazione dominio: $DOMAIN fallita, $LANGUAGE[384] $RESCODE, $LANGUAGE[385] $REASONCODE.<br>";
    webpanel_logs_add("EppProto","$LANGUAGE[438] $DOMAIN, $LANGUAGE[384] $RESCODE, $LANGUAGE[385] $REASONCODE.");
    if (($RESCODE==2308) && ($REASONCODE==9078)) {
     DBQuery("UPDATE t_payservice_auto SET idstatus=21 WHERE iddomain=$IDDOMAIN");
    } else  {
     DBQuery("UPDATE t_payservice_auto SET idstatus=8 WHERE iddomain=$IDDOMAIN");
    } 
   }
  }

  ###################################################
  # Logout EPP Server Normale                       #
  ###################################################

  echo "Logout EPP.<br>";
  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

  ###################################################
  # Procedura per domini Deleted                    #
  ###################################################

  $DELETED_DOMAINS_FOUND=check_domains_deleted_waiting();
  if ($DELETED_DOMAINS_FOUND) {

   ###################################################
   # Login EPP Server Deleted                        #
   ###################################################

   $epp_server="epp-deleted.nic.it";

   echo "Login EPP Deleted.<br>";
   $xml=epp_login_ext($eppsock, "$epp_username_A", "$epp_password_A");
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   if ($RESCODE!=1000) {
    echo "$LANGUAGE[508]<br>";  die();
   } else {
    $CRD=xml_get_credit($xml);
    client_update_eppcredit($ID_ADMIN,$CRD);
    echo "Connessione avvenuta. Credito: $CRD<br>";
   }
   $SESSIONID=epp_http_get_sessionID($xml);
   epp_SelectSession($SESSIONID);
   webpanel_openepp($ID_ADMIN,$SESSIONID,$CRD);

   ###################################################
   # Creazione Domini
   ###################################################

   echo "Creazione Domini Deleted .IT.<br>";
   DBSelect("SELECT * FROM t_payservice_auto WHERE (idstatus=21) AND (iddomain>0)",$rs);
   while (NextRecord($rs,$r)) {
    $IDDOMAIN=$r[iddomain]; $YEARS=1;
    $DOMAIN=get_domain($IDDOMAIN);
    $ID=find_epp_id($DOMAIN); 
    get_domain_info($ID, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
    get_domain_dnsinfo($ID, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
    $UT=get_usertype($IDREG);
    if ($UT==1) { $IDADM=$IDREG; } 
    echo "<pre>Domain: $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $IDREG, $IDADM, $IDTECH, $EPPCODE</pre>";
    $xml=epp_create_domain($eppsock, $DOMAIN, $YEARS, $NS1, $IP1, $NS2, $IP2, $NS3, $IP3, $NS4, $IP4, $NS5, $IP5, $NS6, $IP6, $IDREG, $IDADM, $IDTECH, $EPPCODE);
    echo "<pre>$xml</pre>";
    $RESCODE=xml_get_resultcode($xml); $REASONCODE=xml_get_reasoncode($xml);
    if ($RESCODE==1000) {
     echo "Creazione dominio: $DOMAIN avvenuta con successo.<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[437] $DOMAIN.");
     update_domain_status($ID,15);
     update_domain_creation($ID);
     DBQuery("UPDATE t_payservice_auto SET idstatus=6 WHERE iddomain=$IDDOMAIN");
     DBQuery("UPDATE t_payservice_domains SET idstatus=1, domain_status=2 WHERE iddomain=$IDDOMAIN");
    } else {
     echo "Creazione dominio: $DOMAIN fallita, $LANGUAGE[384] $RESCODE, $LANGUAGE[385] $REASONCODE.<br>";
     webpanel_logs_add("EppProto","$LANGUAGE[438] $DOMAIN, $LANGUAGE[384] $RESCODE, $LANGUAGE[385] $REASONCODE.");
     DBQuery("UPDATE t_payservice_auto SET idstatus=8 WHERE iddomain=$IDDOMAIN");
    }
   }

   ###################################################
   # Logout EPP Server Normale                       #
   ###################################################

   echo "Logout EPP.<br>";
   $xml=epp_logout($eppsock);
   eppCloseConnection($eppsock);
   $CRD=xml_get_credit($xml);
   webpanel_closeepp($ID_ADMIN,$CRD);

  ###################################################
  # Fine Procedura per domini Deleted               #
  ###################################################

  }

  echo "Script ended.<br>";
 DisconnectDB();
?>