<?
  function remove_domain_name($IDD){
   global $EXTERNAL_CALLS_ACTIVE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    del_domain_dns($IDD);
    del_domain_name($IDD);
    del_domain_flags($IDD);
    del_domain_status($IDD);
   }
  }

  function external_domain_delete($DOMAIN){
   global $EXTERNAL_CALLS_ACTIVE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    DBQuery("DELETE FROM t_payservice_domains WHERE domain LIKE '$DOMAIN'");
   }
  }

  function notify_normal_panel_possible_mistake($DOMAIN){
   global $epp_postemail_to, $epp_postemail_from, $EXTERNAL_CALLS_ACTIVE, $LANGUAGE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    $TO_B=$epp_postemail_to;
    $FROM=$epp_postemail_from;
    $MSG="$LANGUAGE[574] $DOMAIN\n";
    mail($TO_B,"$LANGUAGE[575] $DOMAIN",$MSG,"From:".$FROM);
   }
  }

  function notify_normal_panel_notfound($DOMAIN){
   global $epp_postemail_to, $epp_postemail_from, $EXTERNAL_CALLS_ACTIVE, $LANGUAGE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    $TO_B=$epp_postemail_to;
    $FROM=$epp_postemail_from;
    $MSG="$LANGUAGE[576] $DOMAIN\n";
    mail($TO_B,"$LANGUAGE[577] $DOMAIN",$MSG,"From:".$FROM);
   }
  }

  function notify_normal_panel_autorenew($DOMAIN){
   global $epp_postemail_to, $epp_postemail_from, $EXTERNAL_CALLS_ACTIVE, $LANGUAGE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    $TO_B=$epp_postemail_to;
    $FROM=$epp_postemail_from;
    $MSG="$LANGUAGE[578] $DOMAIN\n";
    mail($TO_B,"$LANGUAGE[579] $DOMAIN",$MSG,"From:".$FROM);
   }
  }

  function check_normal_panel_existing_domain($DOMAIN){
   global $EXTERNAL_CALLS_ACTIVE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    DBSelect("SELECT * FROM t_payservice_domains WHERE domain LIKE '$DOMAIN'",$rs);
    if (NextRecord($rs,$r)) return TRUE; else return FALSE;
   } else return TRUE;
  }

  function get_normal_panel_expiring_time($DOMAIN){
   global $EXTERNAL_CALLS_ACTIVE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    DBSelect("SELECT * FROM t_payservice_domains WHERE domain LIKE '$DOMAIN'",$rs);
    if (NextRecord($rs,$r)) return $r['expire_data']; else return 0;
   } else return 0;
  }

  function security_double_check_domains(){
   global $epp_professional,$LANGUAGE, $EXTERNAL_CALLS_ACTIVE, $LANGUAGE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    $today=time()+1296000; 
    $START=0; $N=50;
    DBSelect("SELECT * FROM domain_names WHERE (expire<$today) AND (status=1) ORDER BY expire DESC LIMIT $START,$N",$rs);
    $C=0;
    while (NextRecord($rs,$r)){
     $C++;
     $IDD=$r['idd'];
     $N=$r['name'];
     $E=$r['expire']-mktime(0,0,0,1,1,2000);
     $P=get_normal_panel_expiring_time($N);
     if ($E<$P) {
      $T=$P-$E;
     } else $T=0;
     if ($T>1296000){
      renew_domain_name($IDD,1);
      notify_normal_panel_autorenew($N);
     }
     if (!check_normal_panel_existing_domain($N)){
      notify_normal_panel_notfound($N);
     }
     echo "$LANGUAGE[581] $N [$T] $LANGUAGE[580]<br>";
    }
   }
  }

  function security_double_check_deleted(){
   global $epp_professional, $LANGUAGE, $EXTERNAL_CALLS_ACTIVE, $LANGUAGE;
   if ($EXTERNAL_CALLS_ACTIVE) {
    $today=time()+1296000; 
    DBSelect("SELECT * FROM domain_names WHERE (status<>1)",$rs);
    $C=0;
    while (NextRecord($rs,$r)){
     $C++;
     $IDD=$r['idd'];
     $N=$r['name'];
     $S=$r['status'];
     if (check_normal_panel_existing_domain($N)){
      $SOLVED=FALSE;
      if ($S==4) {
       remove_domain_name($IDD);
       $SOLVED=TRUE;
      }
      if (!$SOLVED) notify_normal_panel_possible_mistake($N);
     } else {
      if ($S==5) {
       remove_domain_name($IDD);
      }
     }
     echo "$LANGUAGE[581] $N $LANGUAGE[580]<br>";
    }
   }
  }
?>