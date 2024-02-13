<?
 include("conf/config.inc.php");
 include("lang/language.it.php");
 include("conf/webpanel.db.php");
 include("libs/webpanel.database.php");
 include("libs/webpanel.interface.php");
 include("libs/webpanel.login.php");
 include("libs/webpanel.functions.php");
 include("libs/xmlutility.inc.php");
 include("libs/epplibrary.inc.php");
 include("libs/eppcommands.inc.php");
 include("libs/epphtml.inc.php");
 include("libs/output.inc.php");
 ConnectDB();

  DBSelect("SELECT * FROM epp_polling WHERE opcode=0",$rs);
  while (NextRecord($rs,$r)) {
   $DOMAIN=$r[domain];
   update_domain_status_byname($DOMAIN,12);
  }

 DisconnectDB();
?>