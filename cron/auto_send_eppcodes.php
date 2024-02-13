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
 include("../libs/automails.inc.php");
 ConnectDB();

  polling_authinfo_requests($ID,$DOMAIN);
  if ($ID>0){
   notify_epp_domain_authinfo($DOMAIN);
   remove_authinfo_request($ID);
  }

 DisconnectDB();
?>