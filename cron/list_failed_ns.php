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
 include("../libs/external.inc.php");
 ConnectDB();
 
  $POLLING_ID=9490;
  DBSelect("
   SELECT domain FROM `epp_polling` 
    WHERE title LIKE 'DNS check ended unsuccessfully' AND idp>$POLLING_ID
  ",$rs); 
  while (NextRecord($rs,$r)) {
   echo "$r[domain]\n";
  }

 DisconnectDB();
?>