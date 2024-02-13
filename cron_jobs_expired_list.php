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
  
 function webpanel_domain_list_expiring_clear($PAG){
  global $epp_professional,$LANGUAGE;
  $today=time()-32700000;
  $N=1500;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_expiring();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;
  DBSelect("
   SELECT * FROM domain_names ORDER BY expire ASC LIMIT $START,$N
  ",$rs);
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r[idd];
   $N=$r[name];
   $TC=$r[created];
   $TU=$r[updated];
   $TE=$r[expire];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r[status];
   $EPPCOD=$r[eppcode];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r[idregistrant];
   $IDADM=$r[idadmin];
   $IDTECH=$r[idtech];
   $IDBILL=$r[idbill];
   echo "$N $EPPCOD <br>";
  }
  crea_navigator($PAG,$TOTPAG,8,"admin_domini_expiring.php?bar=true");
 } 

 webpanel_domain_list_expiring_clear($PAG);

 DisconnectDB();
?>