<?
 ########################################################################
 # Funzioni aggiunte in precedenza.
 ########################################################################

 function print_msg($MSG){
  echo "<div>$MSG</div>";
 }

 function print_login_box_new(){
  echo login_box();
 } 

 function print_html_top_new($TITOLO_PAG){
  session_start();
  echo " 
   <!DOCTYPE html> 
   <HTML>
    <HEAD>
     <TITLE>$TITOLO_PAG</TITLE>
     <link rel=stylesheet href=\"css/stile.css\" type=\"text/css\">
    </HEAD>
    <BODY>
     <div class=main_container>
  ";
 } 

 function print_html_down_new(){
  echo "
     </div>
    </BODY>
   </HTML>
  ";
  session_write_close();
 }

 function print_html_menu_admin_new(){
  $ID_UTENTE=id_active_user();
  if ($ID_UTENTE>0) {
   $LOG="<a href=\"scripts/logout.php\">LOGOUT</a>";
   $TIPO_UTENTE=get_userlevel($ID_UTENTE);
  } else {
   $LOG="<a href=\"login.php\">LOGIN</a>";
   $TIPO_UTENTE="";
  }
  if ($ID_UTENTE>0) {
   get_admin_info($ID_UTENTE,$NOME,$COGNOME);
   $TRD="<div>Hai effettuato il login come: <br><br> <b>$NOME $COGNOME</b> ($LOG) <br><br> Tipo Utente: <b>$TIPO_UTENTE</b></div>";
  }  
  echo "
   <div>
    <hr> 
    <ul id=linkmenu_vert>
    <li><a class=small href=\"admin_backups.php\"    >Backups</a></li>
    </ul>
   </div>
   <hr>
   <div>
    <ul id=linkmenu_vert>
    <li><a class=small href=\"admin_tutorials.php\"  >Tutorials</a></li>
    </ul>
   </div>
   <hr>
   $TRD
   <hr>
  ";
 }

 function print_html_menu_new(){
  $IDADM=id_active_user();
  if ($IDADM==0) {  
   echo "<div class=header><b>Inserisci username e password per effettuare il login.</b></div>";
  } else {
   echo "
    <div class=\"header\">
     <div id=\"linkmenu\"><ul>
      <li><a href=\"admin_index.php\">Home Page</a></li>
      <li><a href=\"admin_info.php\">Informazioni Utente</a></li>
      <li><a href=\"admin_logs.php\">Log Operazioni</a></li>
      <li><a href=\"admin_default.php\">Amministra Dati Default</a></li>
      <li><a href=\"admin_password.php\">Password Pannello</a></li>
      <li><a href=\"scripts/logout.php\">Logout</a></li>
     </ul></div> 
     <hr>
    </div>
   ";
  }
 }

 ##########################################################################################################
 # Funzioni per la gestione di HTML HardCoded Aggiornate 29/08/2012
 ##########################################################################################################

 function print_span($TAG_ID,$TAG_CSS,$TAG_CONTENT){
  if ($TAG_ID!="") $IDTAG=" id=\"$TAG_ID\""; else $IDTAG="";
  if ($TAG_CSS!="") $CSSTAG=" class=\"$TAG_CSS\""; else $CSSTAG="";
  echo "<span".$IDTAG.$CSSTAG.">$TAG_CONTENT</span>";
 }

 function print_div($DIV_ID,$DIV_CSS,$DIV_CONTENT){
  if ($DIV_ID!="") $IDDIV=" id=\"$DIV_ID\""; else $IDDIV="";
  if ($DIV_CSS!="") $CSSDIV=" class=\"$DIV_CSS\""; else $CSSDIV="";
  echo "<div".$IDDIV.$CSSDIV.">$DIV_CONTENT</div>";
 }

 function get_bold($TXT){
  return "<b>$TXT</b>";
 }

 function get_cursive($TXT){
  return "<i>$TXT</i>";
 }

 function get_underlined($TXT){
  return "<u>$TXT</u>";
 }

 function print_bold($TXT){
  echo "<b>$TXT</b>";
 }

 function print_corsive($TXT){
  echo "<i>$TXT</i>";
 }

 function print_underlined($TXT){
  echo "<u>$TXT</u>";
 }

 function print_choose_link($L1,$L2) {
  print_link("IdChooseYes",$CSSCLASS,"$L1","$LANGX[52]");
  echo " - ";
  print_link("IdChoiseNo",$CSSCLASS,"$L2","$LANGX[53]");
 }

 function get_product_techinfos_row($FIELD,$VALUE){
  return "<tr><td width=80%>$FIELD</td><td width=20%>$VALUE</td></tr>";
 }

 function print_product_techinfos($object_no) {
  global $PRODUCTX;
  $IDC=get_idc_object($object_no);
  DoSelect("SELECT * FROM t_objects_options WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   $R="<div class=txtleft>";
   $R.="<br><div><b>Scheda Tecnica Riassuntiva per questo Pacchetto:</b></div><br><table width=98%>";
   $R.=get_product_techinfos_row("Dimensione Backup:",$r['backup_size']);
   $R.=get_product_techinfos_row("Tipo di Backup:",$r['backup_type']);
   $R.=get_product_techinfos_row("Copie Max di Backup:",$r['backup_copies']);
   $R.=get_product_techinfos_row("Descrizione Backup:",$r['backup_desc']);
   $R.=get_product_techinfos_row("Dimensione di Default Caselle EMail:",$r['mailbox_size']);
   $R.=get_product_techinfos_row("Numero di Database MySQL all'Attivazione:",$r['n_mysql']);
   $R.=get_product_techinfos_row("Dimensione Massima Database MySQL:",$r['mysql_size']);
   $R.=get_table_close(1).get_div_close(1);
   echo $R; 
  }
 }

 ##########################################################################################################
 # Funzioni per la gestione di HTML HardCoded Aggiornate 29/08/2012
 ##########################################################################################################

 function print_message_string($MESSAGE_CODE){
  global $MESSAGE;
  if (($MESSAGE_CODE==0) || ($MESSAGE_CODE=="")) echo $MESSAGE[0];
   else echo $MESSAGE[$MESSAGE_CODE];
 }

 function print_error_string($ERROR_CODE){
  global $ERRORS;
  if (($ERROR_CODE==0) || ($ERROR_CODE=="")) echo $ERRORS[0];
   else echo $ERRORS[$ERROR_CODE];
 }

 function fattura_middle_text(){
  $s="
   <TABLE WIDTH=740 cellpadding=4 cellspacing=1 class=t1><TR>
    <TD WIDTH=12%> &nbsp; </TD>
    <TD WIDTH=40%> &nbsp; </TD>
    <TD WIDTH=12%> &nbsp; </TD>
    <TD WIDTH=12%> &nbsp; </TD>
    <TD WIDTH=12%> &nbsp; </TD>
    <TD WIDTH=12%> &nbsp; </TD>
   </TR></TABLE>  
  ";
  return $s;
 }

 function print_bottom_info(){ 
  global $LNK;
  if (is_set_config("bottom_stats")){
   $UV=get_univisitors_yesterday();
   $PV=get_pageviews_yesterday();
   get_listing_cnt($E_CNT,$I_CNT,$D_CNT,$F_CNT,$S_CNT,$R_CNT,$H_CNT,$A_CNT,$K_CNT);
   $TOT_CNT=$E_CNT+$S_CNT+$R_CNT+$I_CNT+$F_CNT+$D_CNT+$H_CNT+$A_CNT+$K_CNT;
   $STAT_STR="$LNK[12]";
   $T="$TOT_CNT";
   $STAT_STR=ereg_replace("\[T\]",$T,$STAT_STR);
   $STAT_STR=ereg_replace("\[UV\]",$UV,$STAT_STR);
   $STAT_STR=ereg_replace("\[PV\]",$PV,$STAT_STR);
   $STAT_BAR="
    [ $LNK[1] - <span class=smallblack>".timestamp_to_str(time())."</span> ] 
    <b>$LNK[2]</b> <b>$E_CNT</b> $LNK[3], <b>$I_CNT</b> $LNK[4], <b>$D_CNT</b> $LNK[5],
    <b>$F_CNT</b> $LNK[6], <b>$S_CNT</b> $LNK[7], <b>$R_CNT</b> $LNK[8],
    <b>$H_CNT</b> $LNK[9], <b>$K_CNT</b> $LNK[10], <b>$A_CNT</b> $LNK[11]. <br>
   ";
  } else {
   $STAT_BAR="";
   $STAT_STR="";
  }
  if (is_set_config("bottom_links")){
   text_values_get_links(31,$LINK_STR);
  } else {
   $LINK_STR="";
  }
  echo "<div class=d1>$STAT_BAR $STAT_STR $LINK_STR</div>";
 }

 function language_bar(){
  global $COUNTRYCODE,$LANGUAGE,$PAYSERVICES,$base_url,$UPMENU;
  if (is_set_config("language_bar")){
   $customer_code=user_active_login();
   echo "<div>";
   DoSelect("SELECT * FROM admin_langbar WHERE actived='True'",$rs);
   while (NextRecord($rs,$r)){
    if (is_set_config("flag_languagelinks")) $img=$r['img_cl']; else $img="";
    if ($COUNTRYCODE<>$r['idlang']) echo " $img <a href=\"http://$base_url/".$r['url_link']."\">".$r['text_link']."</a> ";
     else echo " $img <b>".$r['text_link']."</b> ";
   }
   print_div_close(1);
   if (is_set_config("customer_bar")){
    if (($customer_code!="")&&($customer_code>0)){
     get_customer_session_name($customer_code, $first_name, $last_name);
     echo " <div class=\"txtleft\"><b class=\"lightblack\">$LANGUAGE[85]</b> <b class=\"lightblack\">".stripslashes(ucwords("$first_name $last_name"))."</b></div> ";
     menu_type_box();
    } else {
     menu_type_box();
    }
   }
  } else {
       
   $services="[<a href=\"mydomains.php\">$UPMENU[31]</a>]";
   $logout="(<a href=\"bot/bot_signout.php\">$UPMENU[9]</a>)";
   if (is_set_config("customer_bar")){
    $customer_code=user_active_login();
    if (in_str($HTTP_HOST,"9euro")){
     if (($customer_code!="")&&($customer_code>0)){
      get_customer_session_name($customer_code, $first_name, $last_name);
      echo "<table width=\"98%\" class=\"t0\"><tr><td width=\"32%\" class=\"t0\"><div><b class=\"lightblack\">$LANGUAGE[85]</b> <b class=\"lightblack\">".stripslashes(ucwords("$first_name $last_name"))."</b><br> <b class=\"lightblack\">$services $logout</b> </div></td>";
      echo "<td width=\"68%\" class=\"t0\">";
      menu_type_box();
      echo "</td></tr></table>"; 
     } else {
      echo "<table width=\"98%\" class=\"t0\"><tr><td width=\"32%\" class=\"t0\"><div><b>$PAYSERVICES[130]</b></div></td>";
      echo "<td width=\"68%\" class=\"t0\">";
      menu_type_box();
      echo "</td></tr></table>"; 
     }
    } else {
     if (($customer_code!="")&&($customer_code>0)){
      get_customer_session_name($customer_code, $first_name, $last_name);
      echo "<table width=\"98%\" class=\"t0\"><tr><td width=\"32%\" class=\"t0\"><div><b class=\"lightblack\">$LANGUAGE[85]</b> <b class=\"lightblack\">".stripslashes(ucwords("$first_name $last_name"))."</b> <br> <b class=\"lightblack\">$services $logout</b> </div></td>";
      echo "<td width=\"68%\" class=\"t0\">";
      menu_type_box();
      echo "</td></tr></table>"; 
     } else {
      echo "<table width=\"98%\" class=\"t0\"><tr><td width=\"32%\" class=\"t0\"><div><b>$PAYSERVICES[130]</b></div></td>";
      echo "<td width=\"68%\" class=\"t0\">";
      menu_type_box();
      echo "</td></tr></table>"; 
     }
    }
   }
  }
 }

 function forced_language_bar(){
  global $COUNTRYCODE,$LANGUAGE,$base_url;
  DoSelect("SELECT * FROM admin_langbar WHERE actived='True'",$rs);
  while (NextRecord($rs,$r)){
   if (is_set_config("flag_languagelinks")) $img=$r['img_cl']; else $img="";
   if ($COUNTRYCODE<>$r['idlang']) echo " &nbsp; $img <a href=\"http://$base_url/".$r['url_link']."\">".$r['text_link']."</a> ";
    else echo " &nbsp; $img <b>".$r['text_link']."</b> ";
  }
 }

 ##########################################################################################################
 # Funzioni per la gestione di HTML HardCoded Aggiornate 29/08/2012
 ##########################################################################################################

 function lnk($ID,$CSSCLASS,$URL,$LINK){
  if ($ID!="") $ID_FIELD=" id=\"$ID\""; else $ID_FIELD="";
  if ($CSSCLASS!="") $CSSCLASS_VALUE=" class=\"$CSSCLASS\""; else $CSSCLASS_VALUE="";
  $L="<a".$ID_FIELD.$CSS_FIELD." href=\"$URL\">$LINK</a>";
  return $L;
 }

 function get_link($ID,$CSSCLASS,$URL,$LINK){
  if ($ID!="") $ID_FIELD=" id=\"$ID\""; else $ID_FIELD="";
  if ($CSSCLASS!="") $CSSCLASS_VALUE=" class=\"$CSSCLASS\""; else $CSSCLASS_VALUE="";
  $L="<a".$ID_FIELD.$CSS_FIELD." href=\"$URL\">$LINK</a>";
  return $L;
 }

 function get_html_open(){
  return "<html>";
 }
 
 function get_html_close(){
  return "</html>";
 }

 function get_body_open(){
  return "<body>";
 }
 
 function get_body_close(){
  return "</body>";
 }

 function get_table_close($N){
  $HTML="";
  for ($i=1; $i<=$N; $i++) $HTML.="</table>";
  return $HTML;
 }

 function get_div_open($ID,$CSSCLASS){
  if ($ID!="") $CSS_ID=" id=\"$ID\""; else $CSS_ID="";
  if ($CSSCLASS!="") $CSS_CLASS=" class=\"$CSSCLASS\""; else $CSS_CLASS="";
  $HTML="<div".$CSS_ID.$CSS_CLASS.">";
  return $HTML;
 }

 function get_div_open_simple($N){
  $HTML="";
  for ($i=1; $i<=$N; $i++) $HTML.="<div>";
  return $HTML;
 }

 function get_div_close($N){
  $HTML="";
  for ($i=1; $i<=$N; $i++) $HTML.="</div>";
  return $HTML;
 }

 function get_clearline($N){
  $HTML="";
  for ($i=1; $i<=$N; $i++) $HTML.="<br>";
  return $HTML;
 }
 
 function get_input_file($NAME,$SIZE,$CSSCLASS){
  return "<input type=\"file\" name=\"$NAME\" size=\"$SIZE\">";
 }

 function get_image($SRC,$DX,$DY,$CSSCLASS){
  return "<img class=\"$CSSCLASS\" src=\"$SRC\" width=\"$DX\" height=\"$DY\">";
 }

 function get_input_textarea($NAME,$VALUE,$COLS,$ROWS,$CSSCLASS){
  return "<textarea class=\"$CSSCLASS\" name=\"$NAME\" cols=\"$COLS\" rows=\"$ROWS\">$VALUE</textarea>";
 }

 function get_input_text($NAME,$VALUE,$SIZE,$CSSCLASS){
  return "<input class=\"$CSSCLASS\" type=\"text\" size=\"$SIZE\" name=\"$NAME\" value=\"$VALUE\">";
 }

 function get_input_checkbox($NAME,$VALUE,$CSSCLASS){
  return "<input class=\"$CSSCLASS\" type=\"checkbox\" name=\"$NAME\">";
 }

 function get_input_submit($NAME,$VALUE,$CSSCLASS){
  return "<input class=\"$CSSCLASS\" name=\"$NAME\" type=\"submit\" value=\"$VALUE\">";
 }

 function get_form_start($NAME,$METHOD,$SCRIPT,$CSSCLASS,$UPLOADS){
  if ($UPLOADS) $ENCTYPE="enctype=\"multipart/form-data\""; else $ENCTYPE="";
  return "<form name=\"$NAME\" class=\"$CSSCLASS\" method=\"POST\" action=\"$SCRIPT\" $ENCTYPE>";
 }

 function get_form_end(){
  return "</form>";
 }

 ##########################################################################################################
 # Funzioni per la gestione di HTML HardCoded Aggiornate 29/08/2012
 ##########################################################################################################
 
 function print_link($ID,$CSSCLASS,$URL,$LINK){
  if ($ID!="") $ID_FIELD=" id=\"$ID\""; else $ID_FIELD="";
  if ($CSSCLASS!="") $CSSCLASS_VALUE=" class=\"$CSSCLASS\""; else $CSSCLASS_VALUE="";
  $L="<a".$ID_FIELD.$CSS_FIELD." href=\"$URL\">$LINK</a>";
  echo $L;
 }

 function print_tbl_field($ID,$CCSCLASS,$VALIGN,$SIZE,$VALUE){
  if ($VALUE=="") $VALUE="&nbsp;";
  echo "<td id=\"$ID\" class=\"$CSSCLASS\" width=\"$SIZE\" valign=\"$VALIGN\"> $VALUE </td>";
 }
 
 function print_print_open(){
  echo "<html>";
 }
 
 function print_print_close(){
  echo "</html>";
 }

 function print_body_open(){
  echo "<body>";
 }
 
 function print_body_close(){
  echo "</body>";
 }

 function print_table_open($ID,$CSSCLASS,$WIDTH){
  if ($ID!="") $CSS_ID=" id=\"$ID\""; else $CSS_ID="";
  if ($CSSCLASS!="") $CSS_CLASS=" class=\"$CSSCLASS\""; else $CSS_CLASS="";
  if ($WIDTH!="") $WIDTH_FIELD=" width=\"$WIDTH\"";
  $HTML="<table".$CSS_ID.$CSS_CLASS.$WIDTH_FIELD.">";
  echo $HTML;
 }

 function print_table_close($N){
  for ($i=1; $i<=$N; $i++) echo "</table>";
 }

 function print_tr_open($N){
  for ($i=1; $i<=$N; $i++) echo "<tr>";
 }

 function print_tr_close($N){
  for ($i=1; $i<=$N; $i++) echo "</tr>";
 }

 function print_td_close($N){
  for ($i=1; $i<=$N; $i++) echo "</td>";
 }

 function print_div_open($ID,$CSSCLASS){
  if ($ID!="") $CSS_ID=" id=\"$ID\""; else $CSS_ID="";
  if ($CSSCLASS!="") $CSS_CLASS=" class=\"$CSSCLASS\""; else $CSS_CLASS="";
  $HTML="<div".$CSS_ID.$CSS_CLASS.">";
  echo $HTML;
 }

 function print_div_open_simple($N){
  for ($i=1; $i<=$N; $i++) echo "<div>";
 }

 function print_div_close($N){
  for ($i=1; $i<=$N; $i++) echo "</div>";
 }

 function print_clearline($N){
  for ($i=1; $i<=$N; $i++) echo "<br>";
 }
 
 function print_input_file($NAME,$SIZE,$CSSCLASS){
  echo "<input type=\"file\" name=\"$NAME\" size=\"$SIZE\">";
 }

 function print_image($SRC,$DX,$DY,$CSSCLASS){
  echo "<img class=\"$CSSCLASS\" src=\"$SRC\" width=\"$DX\" height=\"$DY\">";
 }

 function print_input_textarea($NAME,$VALUE,$COLS,$ROWS,$CSSCLASS){
  echo "<textarea class=\"$CSSCLASS\" name=\"$NAME\" cols=\"$COLS\" rows=\"$ROWS\">$VALUE</textarea>";
 }

 function print_input_text($NAME,$VALUE,$SIZE,$CSSCLASS){
  echo "<input class=\"$CSSCLASS\" type=\"text\" size=\"$SIZE\" name=\"$NAME\" value=\"$VALUE\">";
 }

 function print_input_checkbox($NAME,$VALUE,$CSSCLASS){
  echo "<input class=\"$CSSCLASS\" type=\"checkbox\" name=\"$NAME\">";
 }

 function print_input_submit($NAME,$VALUE,$CSSCLASS){
  echo "<input class=\"$CSSCLASS\" name=\"$NAME\" type=\"submit\" value=\"$VALUE\">";
 }

 function print_form_start($NAME,$METHOD,$SCRIPT,$CSSCLASS,$UPLOADS){
  if ($UPLOADS) $ENCTYPE="enctype=\"multipart/form-data\""; else $ENCTYPE="";
  echo "<form name=\"$NAME\" class=\"$CSSCLASS\" method=\"POST\" action=\"$SCRIPT\" $ENCTYPE>";
 }

 function print_form_end(){
  echo "</form>";
 }
?>