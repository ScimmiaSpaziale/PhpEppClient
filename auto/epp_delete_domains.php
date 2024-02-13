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

  $DELETING_DOMAINS_gTLD=check_domains_deleting_gTLD();
  if ($DELETING_DOMAINS_dotIT) {

   ###################################################
   # Cancellazione Domini non .IT
   ###################################################

   echo "Cancellazione Domini non .IT.<br>";
   DBSelect("SELECT * FROM t_payservice_domains WHERE (idstatus=5) AND (tld<>'.IT')",$rs);
   while (NextRecord($rs,$r)) {
    $IDDOMAIN=$r[iddomain];
    $DOMAIN=$r[domain];
    echo "Rimozione dominio: $DOMAIN <br>";
   }

  }

  $DELETING_DOMAINS_dotIT=check_domains_deleting_dotIT();
  if ($DELETING_DOMAINS_dotIT) {

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
   # Cancellazione Domini .IT
   ###################################################

   echo "Cancellazione Domini .IT.<br>";
   DBSelect("SELECT * FROM t_payservice_domains WHERE (idstatus=5) AND (tld='.IT')",$rs);
   while (NextRecord($rs,$r)) {
    $IDDOMAIN=$r[iddomain];
    $DOMAIN=$r[domain];
    echo "Rimozione dominio: $DOMAIN <br>";
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