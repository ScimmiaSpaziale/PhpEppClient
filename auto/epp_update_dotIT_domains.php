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

  $WAITING_DOMAINS=check_domains_waiting_contact_updates();
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
  # Aggiornamento Contatti Domini
  ###################################################

  echo "Aggiornamento Contatti Domini .IT.<br>";
  DBSelect("SELECT * FROM queue_bulk_contactupd WHERE (idstatus=0)",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r[id];
   $DOMAIN=$r[domain];
  
   $IDD=find_epp_id($DOMAIN); 
   get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDOLDREG, $IDOLDADM, $IDOLDTECH, $IDOLDBILL);

   $EPPCODE=create_random_eppcode();
   $IDNEWREG=$r[idreg];
   $IDNEWADM=$r[idadm];
   $IDNEWTECH=$r[idtech];

   $xml=epp_change_registrant($eppsock, $DOMAIN, $IDNEWREG, $EPPCODE);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   echo "Aggiornato Registrant $DOMAIN: $RESCODE, $REASONCODE<br>";
   
   $xml=epp_change_admin($eppsock, $DOMAIN, $IDNEWADM, $IDOLDADM);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   echo "Aggiornato Admin $DOMAIN: $RESCODE, $REASONCODE<br>";

   $xml=epp_change_admin($eppsock, $DOMAIN, $IDNEWTECH, $IDOLDTECH);
   $RESCODE=xml_get_resultcode($xml);
   $REASONCODE=xml_get_reasoncode($xml);
   echo "Aggiornato Tech $DOMAIN: $RESCODE, $REASONCODE<br>";
   
   DBQuery("UPDATE queue_bulk_contactupd SET idstatus=1 WHERE (id=$ID)");
  }

  ###################################################
  # Logout EPP Server Normale                       #
  ###################################################

  echo "Logout EPP.<br>";
  $xml=epp_logout($eppsock);
  eppCloseConnection($eppsock);
  $CRD=xml_get_credit($xml);
  webpanel_closeepp($ID_ADMIN,$CRD);

  echo "Script ended.<br>";
 DisconnectDB();
?>