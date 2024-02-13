<?
 function get_registrant_info_by_domain($DOMAIN,&$REG_NAME,&$ADM_NAME,&$REG_EMAIL,&$ADM_EMAIL){
  DBSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
  } else {
   $IDREG=0;
   $IDADM=0;
  }
  if ($IDREG!=0) {
   DBSelect("SELECT * FROM domain_contacts WHERE contact_id LIKE '$IDREG'",$rs);
   if (NextRecord($rs,$r)) {
    $REG_NAME=$r['name'].$r['surname'];
    $REG_EMAIL=$r['email'];
   }   
  }
  if ($IDADM!=0) {
   DBSelect("SELECT * FROM domain_contacts WHERE contact_id LIKE '$IDADM'",$rs);
   if (NextRecord($rs,$r)) {
    $ADM_NAME=$r['name'].$r['surname'];
    $ADM_EMAIL=$r['email'];
   }   
  }
 }

 function get_auth_info_by_domain($DOMAIN,&$EPPCODE){
  DBSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   $EPPCODE=$r['eppcode'];
   return TRUE;
  } else {
   $EPPCODE="";
   return FALSE;
  }
 }

 function polling_authinfo_requests(&$ID,&$DOMAIN){
  DBSelect("SELECT * FROM queue_bulk_authinfo WHERE (tld LIKE '.IT') AND (status=0) ORDER BY id ASC LIMIT 0,1",$rs);
  if (NextRecord($rs,$r)) {
   $ID=$r['id'];
   $DOMAIN=$r['domain'];
   return $r['id'];
  } else {
   $ID=0;
   $DOMAIN="";
   return 0;
  }
 }

 function remove_authinfo_request($ID){
  DBQuery("UPDATE queue_bulk_authinfo SET status=1 WHERE id=$ID");
 }

 function notify_epp_domain_authinfo($DOMAIN){
  global $epp_postemail_to, $epp_postemail_from;
  get_registrant_info_by_domain(
   $DOMAIN,$REG_NAME,$ADM_NAME,$REG_EMAIL,$ADM_EMAIL
  );
  get_auth_info_by_domain($DOMAIN,$EPPCODE);
  $TO_B=$epp_postemail_to;
  $FROM=$epp_postemail_from;
  $FileName="../mails/it/mail_title_4.html";
  $TLE=Get_TextFile($FileName); 
  $FileName="../mails/it/mail_body_4.html";
  $MSG=Get_TextFile($FileName);
  $TLE=str_replace("<DOMAIN>","$DOMAIN",$TLE);
  $MSG=str_replace("<DOMAIN>","$DOMAIN",$MSG);
  $TLE=str_replace("<EPPCODE>","$EPPCODE",$TLE);
  $MSG=str_replace("<EPPCODE>","$EPPCODE",$MSG);
  mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  if ($REG_EMAIL!=""){
   $TO_B=$REG_EMAIL;
   mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  } 
  if ($ADM_EMAIL!=""){
   $TO_B=$ADM_EMAIL;
   mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  }
  return TRUE;
 }
  
 function notify_epp_domain_deletion($DOMAIN){
  global $epp_postemail_to, $epp_postemail_from;
  get_registrant_info_by_domain(
   $DOMAIN,$REG_NAME,$ADM_NAME,$REG_EMAIL,$ADM_EMAIL
  );
  $TO_B=$epp_postemail_to;
  $FROM=$epp_postemail_from;
  $FileName="../mails/it/mail_title_3.html";
  $TLE=Get_TextFile($FileName); 
  $FileName="../mails/it/mail_body_3.html";
  $MSG=Get_TextFile($FileName);
  $TLE=str_replace("<DOMAIN>","$DOMAIN",$TLE);
  $MSG=str_replace("<DOMAIN>","$DOMAIN",$MSG);
  mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  if ($REG_EMAIL!=""){
   $TO_B=$REG_EMAIL;
   mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  } 
  if ($ADM_EMAIL!=""){
   $TO_B=$ADM_EMAIL;
   mail($TO_B,"$TLE",$MSG,"From:".$FROM);
  }
 }
?>