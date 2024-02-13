<?
 global $epp_clTRID,$xml_check_domain_list;
 $SCRIPT_PATH="D:/WebServer/preorder";
 $SCRIPT_PATH_XML="$SCRIPT_PATH/XML-EPP/it";
 include("$SCRIPT_PATH/conf/config-com.inc.php");
 include("$SCRIPT_PATH/conf/webpanel.db.php");
 include("$SCRIPT_PATH/libs/webpanel.database.php");
 include("$SCRIPT_PATH/libs/webpanel.interface.php");
 include("$SCRIPT_PATH/libs/webpanel.login.php");
 include("$SCRIPT_PATH/libs/webpanel.functions.php");
 include("$SCRIPT_PATH/libs/xmlutility.inc.php");
 include("$SCRIPT_PATH/libs/epplibrary-com.inc.php");
 include("$SCRIPT_PATH/libs/eppcommands.inc.php");
 include("$SCRIPT_PATH/libs/epphtml.inc.php");
 include("$SCRIPT_PATH/whois/whois.lang.php");
 include("$SCRIPT_PATH/whois/server_list_das.php");
 include("$SCRIPT_PATH/whois/whois_das_class.php");
 include("$SCRIPT_PATH/libs/preorders.lib.php");
 ConnectDB();
  $CPU_TRASH_OPERATIONS=250;
  echo "<br> Inizio Controllo Lista Domini: <br><br>";
  $IDS1=EppOpenConnExtendedNoLogs(1,$eppsock);

  EppCreatePreCacheArray($CACHED_XML);
  epp_preload_checklistcode();

  function CountRunningSecontds($MICRO_START){
   $MICRO_CURRENT=microtime_float();
   $MICRO=$MICRO_CURRENT-$MICRO_START;
   return $C;
  }

  #################################################################################
  # Controllo Sul Server
  #################################################################################

  $MICRO_START=microtime_float();
  $TOTSECONDS=0;
  while ($TOTSECONDS<=60) {
   get_domain_list(9,$DOMAIN_LIST,$N_DOMAINS);
   $MICRO1=microtime_float();
   EppCheckDomainListNoLogs(1,$eppsock,$DOMAIN_LIST,$N_DOMAINS,$RESCODE,$REASONCODE,$xml);
   $MICRO2=microtime_float();
   $MICRO=$MICRO2-$MICRO1;
   webpanel_logs_add("EppProto","[Microtime] $MICRO");
   if ($RESCODE!=1000) EppErrorExtendedReLogin($eppsock,1,$RESCODE,$REASONCODE); else {
    xml_domain_availability_list($xml,$DOMLIST,$DOMAVAILABLE,$NDOMS);
    EppPreCachedRegister($eppsock,$xml,$START_TIME,$DOMLIST,$DOMAVAILABLE,$NDOMS,$CACHED_XML);
   }
   webpanel_logs_add("EppProto","[DotCOM] Time: $TOTSECONDS - Check Completato.");
   WaitSlowCycleCheckFlag($CPU_TRASH_OPERATIONS,$eppsock,$CACHED_XML);
   $TOTSECONDS=CountRunningSecontds($MICRO_START);
  }

  #################################################################################
  # (8) Fine Script
  #################################################################################

  EppCloseConnExtendedNoLogs(1,$eppsock);
 DisconnectDB();
?>