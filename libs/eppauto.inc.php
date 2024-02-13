<?
 function check_domains_waiting_contact_updates(){
  DBSelect("SELECT * FROM queue_bulk_contactupd WHERE (idstatus=0)",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }

 function check_domains_deleting_dotIT(){
  DBSelect("SELECT * FROM t_payservice_domains WHERE (idstatus=5) AND (tld='.IT')",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }

 function check_domains_waiting_transfer(){
  DBSelect("SELECT * FROM t_payservice_auto WHERE (idstatus=16)",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }

 function check_domains_waiting_trade(){
  DBSelect("SELECT * FROM t_payservice_auto WHERE (idstatus=43)",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }

 function check_domains_waiting(){
  DBSelect("SELECT * FROM t_payservice_auto WHERE (idstatus=4)",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }

 function get_domain($IDDOMAIN){
  DoSelect("SELECT * FROM t_payservice_domains WHERE iddomain=$IDDOMAIN",$rs);
  if (NextRecord($rs,$r)) return $r['domain']; else return "";
 }

 function find_epp_id($DOMAIN){
  DBSelect("SELECT * FROM domain_names WHERE (name='$DOMAIN')",$rs);
  if (NextRecord($rs,$r)) return $r['idd']; else return 0;
 }

 function get_usertype($CID){
  DBSelect("SELECT * FROM domain_contacts WHERE (contact_id='$CID')",$rs);
  if (NextRecord($rs,$r)) return $r['usertype']; else return 0;
 }

 function is_registrant($CID){
  DBSelect("SELECT * FROM domain_contacts WHERE (contact_id='$CID')",$rs);
  if (NextRecord($rs,$r)) return TRUE; else return FALSE;
 }
?>