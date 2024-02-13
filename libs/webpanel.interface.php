<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 0.9                                     #
 # Useful Functions and Tools for EPP Registrar Operations              #
 #                                                                      #
 # Copyright (C) 2009 - 2010 by Giovanni Ceglia                         #
 #                                                                      #
 # This file is part of "EPP Ceglia Tools".                             #
 #                                                                      #
 # "EPP Ceglia Tools" is free software: you can redistribute it and/or  #
 # modify it under the terms of the GNU General Public License as       # 
 # published by the Free Software Foundation, either version 3 of the   #
 # License, or (at your option) any later version.                      #
 #                                                                      #
 # This program is distributed in the hope that it will be useful,      #
 # but WITHOUT ANY WARRANTY; without even the implied warranty of       # 
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         #
 # GNU General Public License for more details.                         #
 #                                                                      #
 # You should have received a copy of the GNU General Public License    #
 # along with this program. If not, see <http://www.gnu.org/licenses/>. #
 #                                                                      #
 ########################################################################

 ########################################################################
 #                                                                      #
 # This software is available at http://www.giovanniceglia.com          #
 # Comments and suggestions: http://www.giovanniceglia.com              #
 #                                                                      #
 # All contact info to contact Ceglia Giovanni can be found on:         # 
 # http://www.ceglia.tel, you can also write:                           #
 # giovanni.ceglia@frazionabile.it or giovanniceglia@xungame.com              #
 #                                                                      #
 ########################################################################

 function form_delete_domain($ID_ADMIN, $IDD) {
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[627] <br><br>
   <form method=POST action=\"scripts/delete_domain.php?id=$IDD\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 }

 function form_remove_domain($ID_ADMIN, $IDD) {
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[628] <br><br>
   <form method=POST action=\"scripts/delete_domain.php?id=$IDD\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 }

 function form_delete_domain_on_expire_starting($ID_ADMIN, $IDD) {
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[625] <br><br>
   <form method=POST action=\"scripts/delete_domain_on_expire_starting.php?id=$IDD\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 }

 function form_delete_domain_on_expire_ending($ID_ADMIN, $IDD) {
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[629] <br><br>
   <form method=POST action=\"scripts/delete_domain_on_expire_ending.php?id=$IDD\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 }

 function webpanel_domain_list_deleting_on_end_expiring($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()-1296000+86400; 
  $today_start=time()-1296000;

  DBSelect("SELECT * FROM domain_names WHERE (expire<$today) AND (status=1000) $AND_IDA ORDER BY expire DESC",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update_idn.php?idd=$IDD\">$LANGUAGE[122]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/renew_domain.php?idd=$IDD&pag=$PAG\">$LANGUAGE[147]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }
   if ($STATUS=="1000") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }
   if ($STATUS=="1001") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  echo "$LANGUAGE[1]";
 }

 function webpanel_domain_list_deleting_on_start_expiring($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()+86400; 
  $today_start=time();

  DBSelect("SELECT * FROM domain_names WHERE (expire<$today) AND (status=1001) $AND_IDA ORDER BY expire DESC",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update_idn.php?idd=$IDD\">$LANGUAGE[122]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/renew_domain.php?idd=$IDD&pag=$PAG\">$LANGUAGE[147]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }
   if ($STATUS=="1000") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }
   if ($STATUS=="1001") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  echo "$LANGUAGE[1]";
 }

 function webpanel_domain_list_deleting_queued($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()-1296000+86400; 
  $today_start=time()-1296000;

  DBSelect("SELECT * FROM domain_names WHERE ((status=1000) OR (status=1001)) $AND_IDA ORDER BY expire DESC",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update_idn.php?idd=$IDD\">$LANGUAGE[122]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/renew_domain.php?idd=$IDD&pag=$PAG\">$LANGUAGE[147]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }
   if ($STATUS=="1000") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }
   if ($STATUS=="1001") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  echo "$LANGUAGE[1]";
 }

 ########################################################################
 # Nuove Funzioni 12/09/2020.
 ########################################################################

 function get_registrant_name($DOMAIN) {
  $REG_INFO="---";
  DoSelect("SELECT idregistrant FROM domain_names WHERE (name LIKE '$DOMAIN')",$rs);
  if (NextRecord($rs,$r)) {
   $ID_REG=$r['idregistrant'];
   DoSelect("SELECT * FROM domain_contacts WHERE (contact_id LIKE '$ID_REG')",$rs);
   if (NextRecord($rs,$r)) {
    $REG_INFO=$r['name']." ".$r['surname']." ".$r['company'];
   }
  } else $ID_REG=""; 
  return $REG_INFO;
 }

 ########################################################################
 # Pulizia e reset della lista domini 05/09/2020.
 ########################################################################

 function clean_domains_list() {
  DoQuery("
   DELETE FROM domain_names WHERE 
    (status=0) OR ((status>=4) AND (status<=8)) OR ((status>=11) AND (status<=12))
  "); 
 }

 function reset_domains_list() {
  DoQuery("TRUNCATE TABLE domain_names"); 
  DoQuery("TRUNCATE TABLE domain_nameservers"); 
 }

 function form_confirm_list_cleaning(){
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[595] <br><br>
   <form method=POST action=\"scripts/clean_domain_list.php\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 } 

 function form_confirm_list_resetting(){
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[596] <br><br>
   <form method=POST action=\"scripts/reset_domain_list.php\" enctype=\"multipart/form-data\">
    <input type=submit value=\" $LANGUAGE[597] \">
   </form>
  ";
 } 

 ########################################################################
 # Multiuser Credit Management 28/10/2019.
 ########################################################################

 function credits_history($ID_USER, $N, $PAG) {
  $START=0;
  DoSelect("SELECT * FROM admin_eppresellerlogs WHERE (id_user=$ID_USER) ORDER BY id DESC LIMIT $START, $N",$rs);
  while (NextRecord($rs,$r)) {
  }
 }

 function log_used_crd($ID_USER, $CRD, $OP_DESC) {
  $T=time();
  $OP_DESC=addslashes($OP_DESC);
  DoQuery("
   INSERT INTO admin_eppresellerlogs 
     (t_added, ida, crd, description)
    VALUES 
	 ($T, '$ID_USER', '$CRD', '$OP_DESC')
  ");
 } 

 function upd_crd_prices($N_CRD, $T_CRD, $R_CRD, $F_CRD) {
  DoQuery("
   UPDATE admin_cfgcredits SET
    crd_new=$N_CRD, 
    crd_transfer=$T_CRD, 
    crd_restore=$R_CRD, 
    crd_renew=$F_CRD
     WHERE (id=1)
  ");
 }

 function get_crd_prices(&$N_CRD, &$T_CRD, &$R_CRD, &$F_CRD) {
  DoSelect("SELECT * FROM admin_cfgcredits WHERE (id=1)",$rs);
  if (NextRecord($rs,$r)) {
   $N_CRD=$r['crd_new'];
   $T_CRD=$r['crd_transfer'];
   $R_CRD=$r['crd_restore'];
   $F_CRD=$r['crd_renew'];
  } else {
   $N_CRD=0;
   $T_CRD=0;
   $R_CRD=0;
   $F_CRD=0;
  } 
 } 

 function upd_credits($ID_USER, $CRD) {
  DoQuery("
   UPDATE admin_users SET
    crd='$CRD' 
     WHERE (ida=$ID_USER)
  ");
  log_used_crd($ID_USER, $CRD, "Modifica credito in: $CRD");
 }

 function dec_credits($ID_USER, $CRD) {
  DoQuery("UPDATE admin_users SET crd=crd-$CRD WHERE (ida=$ID_USER)");
  DoQuery("UPDATE admin_users SET used_crd=used_crd+$CRD WHERE (ida=$ID_USER)");
 }

 function add_credits($ID_USER, $CRD) {
  DoQuery("UPDATE admin_users SET crd=crd+$CRD WHERE (ida=$ID_USER)");
  log_used_crd($ID_USER, $CRD, "Aggiunta credito: $CRD");
 }

 function get_available_credits($ID_USER) {
  if (!is_numeric($ID_USER)) $ID_USER=0;
  DoSelect("SELECT * FROM admin_users WHERE (ida=$ID_USER)",$rs);
  if (NextRecord($rs,$r)) {
   $CRD=$r['crd'];
  } else {
   $CRD=0;
  } 
  return $CRD;
 }

 function get_used_credits($ID_USER) {
  if (!is_numeric($ID_USER)) $ID_USER=0;
  DoSelect("SELECT * FROM admin_users WHERE (ida=$ID_USER)",$rs);
  if (NextRecord($rs,$r)) {
   $CRD=$r['used_crd'];
  } else {
   $CRD=0;
  } 
  return $CRD;
 }

 function form_upd_credit($ID_USER){
  $CRD=get_available_credits($ID_USER);
  echo "
   <form method=POST action=\"scripts/upd_credits.php?id_user=$ID_USER\">
    <table width=320>
     <tr><td width=50%><b>Nuovo credito</b></td>
     <td width=50%> <input type=\"text\" name=\"crd\" size=\"12\" value=\"$CRD\"> </td>
    </table>
    <input type=submit value=\" Aggiorna Crediti \">
   </form>
  ";
 }

 function form_add_credit($ID_USER){
  echo "
   <form method=POST action=\"scripts/add_credits.php?id_user=$ID_USER\">
    <table width=320>
     <tr><td width=50%><b>Crediti da aggiungere</b></td>
     <td width=50%> <input type=\"text\" name=\"crd\" size=\"12\"> </td>
    </table>
    <input type=submit value=\" Aggiungi Crediti \">
   </form>
  ";
 }

 function form_upd_opcredits(){
  get_crd_prices($N_CRD, $T_CRD, $R_CRD, $F_CRD);
  echo "
   <form method=POST action=\"scripts/upd_opcredits.php\">
    <table width=320>
     <tr><td width=50%><b>Costo Registrazione</b></td><td width=50%> <input type=\"text\" name=\"crd_new\" value=\"$N_CRD\" size=\"12\"> </td></tr>
     <tr><td width=50%><b>Costo Trasferimento</b></td><td width=50%> <input type=\"text\" name=\"crd_trf\" value=\"$T_CRD\" size=\"12\"> </td></tr>
     <tr><td width=50%><b>Costo Ripristino</b></td><td width=50%> <input type=\"text\" name=\"crd_restore\" value=\"$R_CRD\" size=\"12\"> </td></tr>
     <tr><td width=50%><b>Costo Rinnovo</b></td><td width=50%> <input type=\"text\" name=\"crd_renew\" value=\"$F_CRD\" size=\"12\"> </td></tr>
    </table>
    <input type=submit value=\" Aggiorna costo Crediti \">
   </form>
  ";
 }

 ########################################################################
 # Edu 21/08/2012.
 ########################################################################

 function select_schooltype($SCHOOL_TYPE){
  global $LANGUAGE;
  $SEL="";
  $V="<select class=select name=\"status\" size=1>";
   if ($SCHOOL_TYPE==2) $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"2\">Ist. paritario gestito da ente con fini di lucro.</option>";
   if ($SCHOOL_TYPE==4) $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"4\">Istituto paritario gestito da ente no profit.</option>";
   if ($SCHOOL_TYPE==5) $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"5\">Istituto gestito da un ente pubblico</option>";
  $V.="</select>";
  return $V;
 }

 function del_edu_extcon_xml() {
  DoQuery("
   DELETE FROM domain_contacts_edu WHERE idc=$IDC
  ");
 }

 function add_edu_extcon_xml($IDC,&$ISO,&$TYP,&$REGC,&$SCHOOLCODE) {
  if (is_compiled_edu_contact($ISO,$TYP,$REGC,$SCHOOLCODE)) {
   DoQuery("INSERT INTO domain_contacts_edu VALUES ($IDC,'$ISO','$TYP','$REGC','$SCHOOLCODE')");
  }
 }

 function upd_edu_extcon_xml($IDC,&$ISO,&$TYP,&$REGC,&$SCHOOLCODE) {
  DoQuery("
   UPDATE domain_contacts_edu SET 
    nationalitycode='$ISO', entitytype='$TYP', regcode='$REGC', schoolcode='$SCHOOLCODE' 
     WHERE idc=$IDC
  ");
 }

 function get_edu_extcon_xml($IDC,&$ISO,&$TYP,&$REGC,&$SCHOOLCODE) {
  DoSelect("
   SELECT * FROM domain_contacts_edu WHERE idc='$IDC'
  ",$rs);
  if (NextRecord($rs,$r)) {
   $ISO=$r['nationalitycode'];
   $TYP=$r['entitytype'];
   $REGC=$r['regcode'];
   $SCHOOLCODE=$r['schoolcode'];
   return TRUE;
  } else {
   $ISO="";
   $TYP="";
   $REGC="";
   $SCHOOLCODE="";
   return FALSE;
  }
 }

 function is_compiled_edu_contact($ISO,$TYP,$REGC,$SCHOOLCODE) {
  $compiled=TRUE;
  if ($ISO!="IT") $compiled=FALSE;
  if ( ( ($TYP!=2) && ($TYP!=4) ) && ($TYP!=5) ) $compiled=FALSE;
  if ($REGC=="") $compiled=FALSE;
  if ($SCHOOLCODE=="") $compiled=FALSE;
  return $compiled;
 }

 function is_edu_contact($IDC) {
  DoSelect("
   SELECT * FROM domain_contacts_edu WHERE idc='$IDC'
  ",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

 function get_edu_xml($IDC) {
  get_edu_extcon_xml($IDC,$ISO,$TYP,$REGC,$SCHOOLCODE);
  $XML_LN="";
  $XML_LN.="<extcon:registrant>";
  $XML_LN.=" <extcon:nationalityCode>IT</extcon:nationalityCode>";
  $XML_LN.=" <extcon:entityType>5</extcon:entityType>";
  $XML_LN.=" <extcon:regCode>80231570583</extcon:regCode>";
  $XML_LN.=" <extcon:schoolCode>RMIC8BK005</extcon:schoolCode>";
  $XML_LN.="</extcon:registrant>";
  return $XML_LN;
 }

 ########################################################################
 # Funzioni aggiunte 21/08/2012.
 ########################################################################

 function get_quickly_idd($DOMAIN){
  DoSelect("SELECT * FROM domain_names WHERE (name LIKE '$DOMAIN')",$rs);
  if (NextRecord($rs,$r)) {
   return $r['idd'];
  } else return 0;
 }

 function get_quickly_eppcode($DOMAIN){
  DoSelect("SELECT * FROM domain_names WHERE (name LIKE '$DOMAIN')",$rs);
  if (NextRecord($rs,$r)) {
   return $r['eppcode'];
  } else return "";
 }

 function is_transfered_domain($IDD){
  DoSelect("SELECT * FROM domain_names WHERE (idd=$IDD) AND (status=1)",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }
 
 function does_exists_eppqueue() {
  DoSelect("SHOW TABLES LIKE 'epp_queue_ns'",$rs);
  if (NextRecord($rs,$r)) return TRUE;
   else return FALSE;
 } 

 function webpanel_check_queued_ns_update(&$eppsock){
  if (does_exists_eppqueue()) {
   DoSelect("SELECT * FROM epp_queue_ns WHERE idstatus=0",$rs);
   while (NextRecord($rs,$r)) {
    $IDD=$r['idd'];
    if (is_transfered_domain($IDD)) {
     epp_queued_ns_update($eppsock,$IDD);
     update_queued_ns($IDD,1);
    }
   }
  }
 }

 ########################################################################
 # Funzioni aggiunte 21/08/2012.
 ########################################################################

 function update_queued_ns($IDD,$IDSTATUS){
  DoQuery("UPDATE epp_queue_ns SET idstatus=$IDSTATUS WHERE idd=$IDD");
 }

 function is_queued_ns_update($IDD){
  DoSelect("SELECT * FROM epp_queue_ns WHERE idd=$IDD",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }

 function queue_ns_update_on_trf($IDD){
  DoQuery("INSERT INTO epp_queue_ns VALUES ($IDD,0)");
 }

 ########################################################################
 # Funzioni aggiunte 21/08/2012.
 ########################################################################

 function extract_domain_from_list(&$pos,$list){
  $e="";
  $ch="";
  $l=strlen($list);
  while (($ch!=chr(13))&&($pos<=$l)){
   $ch=substr($list,$pos,1);
   $e.=$ch;
   $pos++;
  }
  return trim($e);
 }

 function form_bulk_restore($IDADMIN){
  global $LANGUAGE;
  echo "
   $LANGUAGE[620] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_restore.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml="";
  $bulk_cnt="";
  print_xml_textarea($bulk_cnt,"domainlist",60,12);  
  echo "
      <br><br>
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[621]\">
   </form>
  ";
 }

 function form_bulk_delete($IDADMIN){
  global $LANGUAGE;
  echo "
   $LANGUAGE[607] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_delete.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml="";
  $bulk_cnt="";
  print_xml_textarea($bulk_cnt,"domainlist",60,12);  
  echo "
      <br><br>
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[608]\">
   </form>
  ";
 }

 function form_bulk_contacts_update($IDADMIN){
  global $LANGUAGE;
  echo "
   $LANGUAGE[606] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_contacts_update.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  $bulk_cnt="";
  print_xml_textarea($bulk_cnt,"domainlist",60,12);  
  echo "
      <br><br>
      $LANGUAGE[605]
      <br><br>
      Codice Registrant: <input type=text value=\"\" size=20 name=\"newidreg\"> <br>
      Codice Admin: <input type=text value=\"\" size=20 name=\"newidadm\"> <br>
      Codice Tech: <input type=text value=\"\" size=20 name=\"newidtech\"> <br>
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[604]\">
   </form>
  ";
 }

 function form_bulk_registration($IDADMIN){
  global $LANGUAGE;
  $bulk_reg=""; 
  echo "
   $LANGUAGE[602] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_register.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_reg,"domainlist",60,12);  
  echo "
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[603]\">
   </form>
  ";
 }

 function form_bulk_transfer_trade($IDADMIN){
  global $LANGUAGE;
  $bulk_trf="";
  echo "
   $LANGUAGE[619] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_transfer_trade.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_trf,"domainlist",60,12);  
  echo "
      <br>
      Codice Registrant: <input type=text value=\"\" size=20 name=\"newidreg\"> <br>
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[585]\">
   </form>
  ";
 }

 function form_bulk_transfer($IDADMIN){
  global $LANGUAGE;
  $bulk_trf="";
  echo "
   $LANGUAGE[618] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_transfer.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_trf,"domainlist",60,12);  
  echo "
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[585]\">
   </form>
  ";
 }

 function form_bulk_transfer_approve($IDADMIN){
  global $LANGUAGE;
  $bulk_trf="";
  echo "
   $LANGUAGE[616] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_trf_approve.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_trf,"domainlist",60,12);  
  echo "
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[617]\">
   </form>
  ";
 }

 function form_bulk_transfer_getepp($IDADMIN){
  global $LANGUAGE;
  $bulk_trf="";
  echo "
   $LANGUAGE[614] <br>
   <br> 
   <form method=POST action=\"scripts/bulk_domain_getepp.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_trf,"domainlist",60,12);  
  echo "
     </td>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[615]\">
   </form>
  ";
 }

 function form_bulk_nsupdate($IDADMIN){
  global $LANGUAGE;
  $bulk_ns="";
  $NS1="";
  $NS2="";
  $NS3="";
  $NS4="";
  $NS5="";
  $NS6="";
  echo "
   <form method=POST action=\"scripts/bulk_nsupdate.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($bulk_ns,"domainlist",40,12);  
  echo "
     </td>
    </table>
    <br>
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[180]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$NS1\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[178]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$NS2\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$NS3\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$NS4\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$NS5\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$NS6\"></td></tr>
    </table>
    <br>
    <input type=submit value=\"$LANGUAGE[584]\">
   </form>
  ";
 }

 ########################################################################
 # Funzioni aggiunte 12/02/2011.
 ########################################################################

 function encode_domain_HTML($STR){
  $NEWSTR="";
  $L=strlen($STR);
  for ($i=0; $i<=$L; $i++) { 
   $CH=substr($STR,$i,1);
   if ($CH=="à") $CH="a";
   if ($CH=="è") $CH="&egrave;";
   if ($CH=="é") $CH="&egrave;";
   if ($CH=="ì") $CH="i";
   if ($CH=="ò") $CH="o";
   if ($CH=="ù") $CH="u";
   $NEWSTR.=$CH;
  }
  return $NEWSTR;
 }


 function fix_contact_IDNs($STR){
  $NEWSTR="";
  $L=strlen($STR);
  for ($i=0; $i<=$L; $i++) { 
   $CH=substr($STR,$i,1);
   if ($CH=="&") $CH="&amp;";
   if ($CH=="à") $CH="a'";
   if ($CH=="è") $CH="e'";
   if ($CH=="ì") $CH="i'";
   if ($CH=="ò") $CH="o'";
   if ($CH=="ù") $CH="u'";
   $NEWSTR.=$CH;
  }
  return $NEWSTR;
 }

 function fix_domain_IDNs($STR){
  $NEWSTR="";
  $L=strlen($STR);
  for ($i=0; $i<=$L; $i++) { 
   $CH=substr($STR,$i,1);
   if ($CH=="à") $CH="a";
   if ($CH=="è") $CH="e";
   if ($CH=="ì") $CH="i";
   if ($CH=="ò") $CH="o";
   if ($CH=="ù") $CH="u";
   $NEWSTR.=$CH;
  }
  return $NEWSTR;
 }

 function form_update_status($ID_ADMIN,$IDD){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/update_domain_status.php?idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[559]</b></td>
     <td width=50%> <input type=\"text\" name=\"idstatus\" size=\"4\"> </td>
    </table>
    <input type=submit value=\" $LANGUAGE[558] \">
   </form> <br>
   $LANGUAGE[1]
  ";
 }

 ########################################################################
 # Funzioni aggiunte 12/01/2011.
 ########################################################################

 function form_delete_panel_user($ID_ADMIN,$ID){
  echo "<a href=\"scripts/cancella_utente.php?ID=$ID\">Conferma Cancellazione Utente</a>";
 }

 function form_update_panel_user($ID_ADMIN,$ID){
 }

 ########################################################################
 # Funzioni aggiunte 26/07/2010.
 ########################################################################

 function get_idregistrant($IDC){
  DBSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) { 
   return $r['contact_id'];
  } else return "";
 }

 function get_domain_list($STATUS,&$DOMAIN_LIST, &$N_DOMAINS){
  DBSelect("SELECT * FROM domain_names WHERE status=$STATUS",$rs);
  $N_DOMAINS=0;
  while (NextRecord($rs,$r)){
   $N_DOMAINS++;
   $DOMAIN_LIST[$N_DOMAINS]=$r['name'];
  }
 }

 ########################################################################
 # Funzioni aggiunte 25/06/2010.
 ########################################################################

 function print_html_menu_links(){
  global $LANGUAGE;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN<=1) { 
  echo "
   <DIV>
    <TABLE width=99%>
     <TR><TD width=50% valign=top>

      <TABLE width=99%>
       <TR><TD><DIV> $LANGUAGE[329] </div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://rain.nic.it\">$LANGUAGE[334]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://rain-ng.nic.it\">$LANGUAGE[333]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"https://arp.nic.it\">$LANGUAGE[332]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.nic.it\">$LANGUAGE[331]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.registro.it\">$LANGUAGE[330]</a></div></TD></TR>
      </TABLE>
      
     </TD><TD width=50% valign=top> 

      <TABLE width=99%>
       <TR><TD><DIV> $LANGUAGE[328] </div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.hostingtalk.it\">$LANGUAGE[325]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.domainers.it\">$LANGUAGE[324]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.alverde.net\">$LANGUAGE[323]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.trovahosting.eu\">$LANGUAGE[322]</a></div></TD></TR>

       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.programmatore.eu\">$LANGUAGE[521]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.consulente.eu\">$LANGUAGE[522]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.aspmonkey.com\">$LANGUAGE[523]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.cplusplus.eu\">$LANGUAGE[524]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.phpitaly.it\">$LANGUAGE[525]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.html.it\">$LANGUAGE[526]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.webhostingforum.it\">$LANGUAGE[527]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.webhostingtalk.com\">$LANGUAGE[528]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.dnforum.com\">$LANGUAGE[529]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://forums.sitepoint.com\">$LANGUAGE[530]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://forums.digitalpoint.com\">$LANGUAGE[531]</a></div></TD></TR>
      </TABLE>

     </TD></TR>
     <TR><TD width=50% valign=top>

      <TABLE width=99%>
       <TR><TD><DIV> $LANGUAGE[327] </div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.hexonet.com\">$LANGUAGE[321]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.centralnic.com\">$LANGUAGE[320]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.nic.ir\">$LANGUAGE[319]</a></div></TD></TR>
      </TABLE>

     </TD><TD width=50% valign=top> 

      <TABLE width=99%>
       <TR><TD><DIV> $LANGUAGE[326] </div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.giovanniceglia.com\">$LANGUAGE[318]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.eppscript.com\">$LANGUAGE[317]</a></div></TD></TR>
       <TR><TD class=lightblue><div align=left><a target=_Blank href=\"http://www.programmatore.eu\">$LANGUAGE[316]</a></div></TD></TR>
      </TABLE>

     </TD></TR>
    </TABLE>
   </DIV>
  ";
  }
 }

 ###fix###

 ########################################################################
 # Funzioni aggiunte 20/04/2010.
 ########################################################################

 function is_private_registrant($IDREG){
  DbSelect("SELECT * FROM domain_contacts WHERE contact_id='$IDREG'",$rs); 
  if (NextRecord($rs,$r)) {
   $UT=$r['usertype'];
   if ($UT==1) return TRUE;
    else return FALSE; 
  } else return FALSE;
 }

 function mail_notify_msg($TYPE,$DOMAIN,$TITLE){
  global $epp_postemail_to, $epp_postemail_from, $epp_postemail_polling_notify;
  global $LANGUAGE;
  $T=time();
  if ($epp_postemail_polling_notify) {
   $TO_B=$epp_postemail_to;
   $FROM=$epp_postemail_from;
   $T="[EPP-DotIT] $DOMAIN - $TITLE";
   $B="$LANGUAGE[315] $TITLE\n\nDominio: $DOMAIN";
   mail($TO_B,$T,$B,"From:".$FROM);
  } 
 }

 ########################################################################
 # Funzioni aggiunte 18/03/2010.
 ########################################################################

 function get_client_version(){
  global $LANGUAGE;
  $IDADMIN=id_active_user();
  DbSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   $V=$r['client_version'];
   return $V; 
  } else return "$LANGUAGE[314]";
 }

 function form_select_forcensupd_transfert(){
  global $LANGUAGE;
  $T="False";
  echo "
   <table width=320><tr><td> 
    <br> $LANGUAGE[588] <br><br> ".select_option("forcensupd","$T")." <br><br>
   </td></tr></table><br>
  ";
 }

 function form_select_contract_transfert(){
  global $LANGUAGE;
  $T="True";
  echo "
   <table width=320><tr><td> 
    <br> $LANGUAGE[3] <br><br> ".select_option("contract","$T")." <br><br>
   </td></tr></table><br>
  ";
 }

 ########################################################################
 # Funzioni aggiunte 18/03/2010.
 ########################################################################

 function form_change_registrant_contact($IDD){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/update_domain_registrant.php?idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[313]</b></td>
     <td width=50%> <input type=\"text\" name=\"newreg\" size=\"12\"> </td>
    </table>
    <input type=submit value=\" $LANGUAGE[312] \">
   </form>
  ";
 }

 function form_change_admin_contact($IDD){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/update_domain_admin.php?idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[311]</b></td>
     <td width=50%> <input type=\"text\" name=\"newadmin\" size=\"12\"> </td>
    </table>
    <input type=submit value=\" $LANGUAGE[310] \">
   </form>
  ";
 }

 function form_change_tech_contact($IDD){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/update_domain_tech.php?idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[309]</b></td>
     <td width=50%> <input type=\"text\" name=\"newtech\" size=\"12\"> </td>
    </table>
    <input type=submit value=\" $LANGUAGE[308] \">
   </form>
  ";
 }

 ########################################################################
 # Funzioni aggiunte 10/03/2010.
 ########################################################################

 function renew_domain_name($IDD,$YEARS){
  $AT=$YEARS*365*24*60*60;
  DBQuery("UPDATE domain_names SET expire=expire+$AT WHERE idd=$IDD");
 }

 function renew_domain_name_byname($DOM,$YEARS){
  $AT=$YEARS*365*24*60*60;
  DBQuery("UPDATE domain_names SET expire=expire+$AT WHERE name LIKE '$DOM'");
 }

 ########################################################################
 # Funzioni aggiunte 14/02/2010.
 ########################################################################

 function get_imported_contact(&$CONTACT_ID){
  DbSelect("SELECT * FROM domain_contacts WHERE (name LIKE 'mnt') AND (surname LIKE 'mnt') LIMIT 0,1",$rs);
  if (NextRecord($rs,$r)) {
   $CONTACT_ID=$r['contact_id'];
   return $r['idc'];
  } else {
   $CONTACT_ID="";
   return 0;
  }
 }

 function form_contact_search(){
  global $LANGUAGE;
  echo "
   <br>
   <form method=POST action=\"admin_contacts_search.php\">
    <input type=\"text\" name=\"key\" size=\"12\"> <input type=submit value=\" $LANGUAGE[306] \">
   </form>
  ";
 } 

 function webpanel_profiles_navbar($PAG) {
  global $LANGUAGE;
  $TP=count_total_contacts();
  echo "<table width=99%><tr>";
   echo "<td width=20%><u><b>$LANGUAGE[307]</u></b> $TP</td>";
   echo "<td width=15%> &nbsp; - &nbsp; </td>";
   echo "<td width=20%> &nbsp; - &nbsp; </td>";
   echo "<td width=15%> &nbsp; - &nbsp; </td>";
   echo "<td width=30%>";
    form_contact_search();
   echo "</td>";
  echo "</tr></table>";
  echo "<br>";
 } 

 ########################################################################
 # Funzioni aggiunte 12/02/2010.
 ########################################################################

 function form_domain_search(){
  global $LANGUAGE;
  echo "
   <br>
   <form method=POST action=\"admin_domini_search.php\">
    <input type=\"text\" name=\"domseek\" size=\"12\"> <input type=submit value=\" $LANGUAGE[306] \">
   </form>
  ";
 } 

 function webpanel_domain_navbar($PAG) {
  global $LANGUAGE;
  $TDOMS=count_total_domains();
  echo "<table width=99%><tr>";
   echo "<td><u><b>$LANGUAGE[305]</u></b> $TDOMS</td>";
   echo "<td>[ <a href=\"admin_domini_expiring.php\">$LANGUAGE[304]</a> ]</td>";
   echo "<td>[ <a href=\"admin_domini_trasferimenti.php\">$LANGUAGE[303]</a> ]</td>";
   echo "<td>[ <a href=\"admin_domini_attivazioni.php\">$LANGUAGE[302]</a> ]</td>";
   echo "<td>[ <a href=\"admin_domini_cancellati.php\">$LANGUAGE[301]</a> ]</td>";
   echo "<td>";
    form_domain_search();
   echo "</td>";
  echo "</tr></table>";
  echo "<br>";
 } 

 function import_domain_contact($contact_id,$cidtype){
  $IDA=id_active_user();
  $usertype=0;
  $name="mnt";
  $surname="mnt";
  $company="mnt";
  $address="mnt";
  $zipcode="mnt";
  $city="mnt";
  $province="mnt";
  $country="mnt";
  $nationality="mnt";
  $fiscalcode="mnt";
  $vatcode="mnt";
  $tel="mnt";
  $fax="mnt";
  $email="mnt";
  $pub="True";
  $sex="";
  if (!is_numeric($usertype)) $usertype=0;
  DBSelect("SELECT * FROM domain_contacts WHERE contact_id='$contact_id'",$rs);
  if (!NextRecord($rs,$r)) {
   DBQuery("
    INSERT INTO domain_contacts 
    (
     contact_id, status, name, surname, company, address, zipcode, city, province, 
     country, nationality, usertype, cidtype, vatcode, fiscalcode, tel, fax, email,
     pubblish, sex, ida
    ) 
     VALUES
    (
     '', 'Pending', '$name', '$surname', '$company', '$address', '$zipcode', '$city', '$province',
     '$country', '$nationality', '$usertype', '$cidtype', '$vatcode', '$fiscalcode', '$tel', '$fax', '$email',
     '$pub', '$sex', '$IDA'
    )
   ");
   DBSelect("SELECT * FROM domain_contacts ORDER BY idc DESC LIMIT 0,1",$rs);
   if (NextRecord($rs,$r)) {
    $IDC=$r['idc'];
    $CID=$contact_id;
   } else {
    $IDC=0;
    $CID=$contact_id;
   }
   DBQuery("UPDATE domain_contacts SET contact_id='$CID' WHERE idc=$IDC");
  }
 }

 function get_imported_domain(){
  DbSelect("SELECT * FROM domain_names WHERE (status=12) OR (status=14) OR (status=15) LIMIT 0,1",$rs);
  if (NextRecord($rs,$r)) {
   return $r['idd'];
  } else {
   return 0;
  }
 }

 function extract_domain_name_by_str($STR){
  $L=strlen($STR);
  $CH="";
  $NEWSTR="";
  $N=0;
  $SC=FALSE;
  while (($N<$L) && (!$SC)) {
   $CH=substr($STR,$N,1);
   $N++;
   if (($CH!=";")&&($CH!=",")){
    if ($CH!="\"") $NEWSTR=$NEWSTR.$CH;
   } else $SC=TRUE; 
  }
  return $NEWSTR;
 }

 function import_domain_name($DOMAIN){
  global $LANGUAGE;
  if (($DOMAIN!="")&&($DOMAIN!=$LANGUAGE[4])){
   $IDREG="0"; 
   $IDADM="0"; 
   $IDTECH="0"; 
   $IDBILL="0"; 
   $NS1="-";
   $NS2="-";
   $IP1="0";
   $IP2="0";
   create_domain_to_import($DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL,$NS1,$NS2,$IP1,$IP2);
  }
 }

 function extract_mnt_list($PATH,$FILENAME){
  $filename=$PATH."/".$FILENAME;
  $mode="r+";
  File_Open($f,$filename,$mode);
  $N=0;
  while (!File_Eof($f)) {
   $N++;
   $t=File_Get_Text($f);
   $DOMAIN=extract_domain_name_by_str($t);
   echo "Checking: $DOMAIN <br>";
   $IDREG="0"; 
   $IDADM="0"; 
   $IDTECH="0"; 
   $IDBILL="0"; 
   $NS1="-";
   $NS2="-";
   $IP1="0";
   $IP2="0";
   create_domain_to_import($DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL);
  }
  File_Close($f);
  return $N;
 }

 function import_mnt_filelist($PATH){
  global $_FILES;
  if(is_uploaded_file($_FILES["mntlist"]['tmp_name'])) {
   $i=trim($_FILES["mntlist"]['name']);
   move_uploaded_file($_FILES["mntlist"]['tmp_name'], "$PATH/$i");
  }
  $FILENAME=$i;
  return extract_mnt_list($PATH,$FILENAME);
 }

 function form_importa_mnt_list(){
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[300] <br><br>
   <form method=POST action=\"scripts/import_domain_mnt_list.php\" enctype=\"multipart/form-data\">
    <table width=600><tr>
     <td width=60%><b>$LANGUAGE[299]</b></td>
     <td width=40%> <input type=\"file\" name=\"mntlist\" size=\"25\"> </td>
    </tr></table>
    <input type=submit value=\" $LANGUAGE[298] \">
   </form>
  ";
 } 

 ########################################################################
 # Funzioni aggiunte 04/01/2010.
 ########################################################################

 function domain_update_authinfo($IDDOMAIN,$NEWAUTH){
  $NEWAUTH=crypt_webpanel_string($NEWAUTH);
  DBQuery("UPDATE domain_names SET eppcode='$NEWAUTH' WHERE idd=$IDDOMAIN");
 }

 function form_update_authinfo($IDDOMAIN){
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[297] <br><br>
   <form method=POST action=\"scripts/change_domain_eppcode.php?iddomain=$IDDOMAIN\">
    <table width=600><tr>
     <td width=60%><b>$LANGUAGE[296]</b></td>
     <td width=40%><input type=text size=48 name=\"eppcode\"></td>
    </tr></table>
    <input type=submit value=\" $LANGUAGE[295] \">
   </form>
  ";
 }

 ########################################################################
 # Funzioni aggiunte 04/01/2010.
 ########################################################################

 function update_password_epp_server($IDES,$NEWPWD){
  $PWD=crypt_webpanel_string($NEWPWD);
  DBQuery("UPDATE servers_epp SET password='$PWD' WHERE ides=$IDES");
 }

 function form_update_security_key(){
  global $LANGUAGE;
  echo "
   <br><br> $LANGUAGE[294] <br><br>
   <form method=POST action=\"scripts/update_security_key.php\">
    <table width=600>
     <tr><td width=20%><b>$LANGUAGE[293]</b></td><td width=80%><input type=text size=48 name=\"OLDKEY\"></td></tr>
     <tr><td width=20%><b>$LANGUAGE[292]</b></td><td width=80%><input type=text size=48 name=\"NEWKEY\"></td></tr>
    </table>
    <input type=submit value=\"$LANGUAGE[291]\">
   </form>
  ";
 }

 ########################################################################
 # Funzioni aggiunte 28/12/2009.
 ########################################################################

 function get_dnsserver_info($IDDS,&$DESC,&$NS1,&$IP1,&$NS2,&$IP2,&$NS3,&$IP3,&$NS4,&$IP4,&$NS5,&$IP5,&$NS6,&$IP6){
  DBSelect("SELECT * FROM servers_dns WHERE idds=$IDDS",$rs);
  if (NextRecord($rs,$r)) {
   $DESC=$r['description'];
   $NS1=$r['ns1'];
   $IP1=$r['ip1'];
   $NS2=$r['ns2'];
   $IP2=$r['ip2'];
   $NS3=$r['ns3'];
   $IP3=$r['ip3'];
   $NS4=$r['ns4'];
   $IP4=$r['ip4'];
   $NS5=$r['ns5'];
   $IP5=$r['ip5'];
   $NS6=$r['ns6'];
   $IP6=$r['ip6'];
  } else {
   $DESC="";
   $NS1="";
   $IP1="";
   $NS2="";
   $IP2="";
   $NS3="";
   $IP3="";
   $NS4="";
   $IP4="";
   $NS5="";
   $IP5="";
   $NS6="";
   $IP6="";
  }
 }

 function domain_add_status($IDDOMAIN,$STATUS){
  DBQuery("INSERT INTO domain_flags (idd,status) VALUES ($IDDOMAIN,'$STATUS')");
 }

 function domain_del_status($IDDOMAIN,$STATUS){
  DBQuery("DELETE FROM domain_flags WHERE (idd=$IDDOMAIN) AND (status='$STATUS')");
 }

 function webpanel_domain_list_status($IDDOMAIN){
  global $LANGUAGE;
  echo "<table width=320>";
  DBSelect("SELECT * FROM domain_flags WHERE idd=$IDDOMAIN ORDER BY idf ASC",$rs);
  while (NextRecord($rs,$r)) {
   $IDD=$r['idd'];
   $STATUS=$r['status'];
   $REMOVE_STATUS_LINK="<a href=\"scripts/update_domain_del_status.php?idd=$IDD&status=$STATUS\">$LANGUAGE[267]</a>";
   echo "<tr><td width=50%><b>".$r['status']."</b></td><td width=50%>[ $REMOVE_STATUS_LINK ]</td>";
  }
  echo "</table>";
 }

 function select_domain_status(){
  global $LANGUAGE;
  DBSelect("SELECT * FROM epp_domstatus ORDER BY ids ASC",$rs);
  $V="<select class=select name=\"status\" size=1>";
  $V.="<option value=\"\">$LANGUAGE[290]</option>";
  while (NextRecord($rs,$r)) {
   $V.="<option value=\"".$r['status']."\">".$r['status']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function get_domain_iddomain($DOMAIN){
  DBSelect("SELECT idd FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) return $r['idd'];
   else return 0;
 }

 function get_domain_usertype($DOMAIN){
  DBSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) return $r['usertype'];
   else return 0;
 }

 function get_contact_waiting($SEL){
  DBSelect("SELECT * FROM domain_contacts WHERE status='Pending' ORDER BY idc ASC LIMIT $SEL,1",$rs);
  if (NextRecord($rs,$r)) return $r['idc'];
   else return 0;
 }

 function get_domain_waiting($SEL){
  DBSelect("SELECT * FROM domain_names WHERE status=0 ORDER BY idd ASC LIMIT $SEL,1",$rs);
  if (NextRecord($rs,$r)) return $r['idd'];
   else return 0;
 }

 function get_domain_backorder($SEL){
  DBSelect("SELECT * FROM domain_names WHERE status=9 ORDER BY idd ASC LIMIT $SEL,1",$rs);
  if (NextRecord($rs,$r)) return $r['idd'];
   else return 0;
 }

 function webpanel_domain_info($IDD){
  global $LANGUAGE;
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  echo "
   <table width=320>
    <tr><td width=50%><b>$LANGUAGE[193]</b></td><td width=50%>$DOMAIN</td>
    <tr><td width=50%><b>$LANGUAGE[192]</b></td><td width=50%>$IDREG</td>
    <tr><td width=50%><b>$LANGUAGE[191]</b></td><td width=50%>$IDADM</td>
    <tr><td width=50%><b>$LANGUAGE[190]</b></td><td width=50%>$IDTECH</td>
    <tr><td width=50%><b>$LANGUAGE[189]</b></td><td width=50%>$IDBILL</td>
   </table>
   <br>
   <table width=320>
    <tr><td width=50%><b>$LANGUAGE[187]</b></td><td width=50%>$NS1</td>
    <tr><td width=50%><b>$LANGUAGE[185]</b></td><td width=50%>$IP1</td>
    <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%>$NS2</td>
    <tr><td width=50%><b>$LANGUAGE[184]</b></td><td width=50%>$IP2</td>
    <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%>$NS3</td>
    <tr><td width=50%><b>$LANGUAGE[536]</b></td><td width=50%>$IP3</td>
    <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%>$NS4</td>
    <tr><td width=50%><b>$LANGUAGE[538]</b></td><td width=50%>$IP4</td>
    <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%>$NS5</td>
    <tr><td width=50%><b>$LANGUAGE[540]</b></td><td width=50%>$IP5</td>
   </table>
  ";
 }

 function form_add_domain_status($IDD){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/update_domain_add_status.php?idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[289]</b></td><td width=50%>".select_domain_status()."</td>
    </table>
    <input type=submit value=\" $LANGUAGE[288] \">
   </form>
  ";
  echo "
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left>
     <br> $LANGUAGE[287]
    </div></td>
   </tr></table> 
  ";
 }

 ########################################################################
 # Funzioni aggiunte 28/12/2009.
 ########################################################################

 function get_eppserver_tld($IDES){
  global $tld_dir;
  DBSelect("SELECT tld FROM servers_epp WHERE ides=$IDES",$rs);
  if (NextRecord($rs,$r)) {
   return $r['tld'];
  } else {
   if ($IDES==0) return $tld_dir;
    else return "DEFAULT";
  }
 }

 function get_eppserver_proto($IDES){
  global $epp_prot;
  DBSelect("SELECT proto FROM servers_epp WHERE ides=$IDES",$rs);
  if (NextRecord($rs,$r)) {
   $proto=$r['proto'];
   if ($proto=="EPPoHTTP") return "HTTP";
    else if ($proto=="EPPoTCP") return "TCP";
     else if ($proto=="EPPoSMTP") return "SMTP";
      else if ($proto=="EPPoTCPv2") return "TCP2";
       else if ($proto=="EPPoCURL") return "CURL";
  } else {
   return $epp_prot;
  }
 }

 function get_eppserver_info($IDES,&$TLD,&$DESC,&$ADDRESS,&$USERNAME,&$PASSWORD,&$PROTO,&$PORT){
  global $epp_prot,$epp_port,$epp_server,$tld_dir,$epp_username,$epp_password;
  DBSelect("SELECT * FROM servers_epp WHERE ides=$IDES",$rs);
  if (NextRecord($rs,$r)) {
   $TLD=$r['tld'];
   $DESC=$r['description'];
   $ADDRESS=$r['address'];
   $USERNAME=$r['username'];
   $PASSWORD=decrypt_webpanel_string($r['password']);
   $PROTO=$r['proto'];
   $PORT=$r['port'];
  } else {
   $TLD=$tld_dir;
   $DESC="DEFAULT";
   $ADDRESS=$epp_server;
   $USERNAME=$epp_username;
   $PASSWORD=$epp_password;
   $PROTO=$epp_prot;
   $PORT=$epp_port;
  }
 }

 function update_servers_idds($IDDS){
  $IDADMIN=id_active_user();
  DBQuery("UPDATE admin_eppconfig SET idds=$IDDS WHERE ida=$IDADMIN");
 }

 function update_servers_ides($IDES){
  $IDADMIN=id_active_user();
  DBQuery("UPDATE admin_eppconfig SET ides=$IDES WHERE ida=$IDADMIN");
 }

 function get_servers_idds(){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) return $r['idds'];
   else return 0;
 }

 function get_servers_ides($IDADMIN){
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) return $r['ides'];
   else return 0;
 }

 function client_select_dns_removecheck(){
  global $LANGUAGE;
  $V="<select class=select name=\"nsdel\" size=1>";
   $V.="<option selected value=\"V\">$LANGUAGE[562]</option>";
   $V.="<option value=\"F\">$LANGUAGE[563]</option>";
  $V.="</select>";
  return $V;
 }

 function client_select_dns_server($IDDS){
  global $LANGUAGE;
  DBSelect("SELECT * FROM servers_dns ORDER BY idds ASC",$rs);
  $V="<select class=select name=\"idds\" size=1>";
  if ($IDDS==0) $SEL="selected"; else $SEL="";
  $V.="<option $SEL value=\"0\">$LANGUAGE[286]</option>";
  while (NextRecord($rs,$r)) {
   if ($IDDS==$r['idds']) $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"".$r['idds']."\">[Usa] [ ".$r['description']." ] ".$r['ns1']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function client_select_epp_server($IDES){
  global $LANGUAGE;
  DBSelect("SELECT * FROM servers_epp ORDER BY ides ASC",$rs);
  $V="<select class=select name=\"ides\" size=1>";
  if ($IDES==0) $SEL="selected"; else $SEL="";
  $V.="<option $SEL value=\"0\">$LANGUAGE[285]</option>";
  while (NextRecord($rs,$r)) {
   if ($IDES==$r['ides']) $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"".$r['ides']."\">[ ".$r['tld']." ] ".$r['description']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 ########################################################################
 # Funzioni aggiunte 28/12/2009.
 ########################################################################

 function del_dnsserver($IDDS){
  DBQuery("DELETE FROM servers_dns WHERE idds=$IDDS");
 }

 function del_eppserver($IDES){
  DBQuery("DELETE FROM servers_epp WHERE ides=$IDES");
 }

 function webpanel_dnsserver_list(){
  global $LANGUAGE;
  DBSelect("SELECT * FROM servers_dns ORDER BY idds DESC",$rs);
  echo "
   <table width=80%>
    <tr>
     <td class=lightgrey width=8%><b>$LANGUAGE[259]</b></td>
     <td class=lightgrey width=40%><b>$LANGUAGE[261]</b></td>
     <td class=lightgrey width=50%><b>$LANGUAGE[284]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[267]</b></td>
    </tr>
  ";
  $C=0;
  $REMOVE_LINK="";
  while (NextRecord($rs,$r)){
   $C++;
   if ($C%2==0) $cl="lightwhite1";
    else $cl="lightwhite2";
   $ID=$r['idds'];
   $DESC=$r['description'];
   $NS1=$r['ns1'];
   $NS2=$r['ns2'];
   $NS3=$r['ns3'];
   $NS4=$r['ns4'];
   $NS5=$r['ns5'];
   $IP1=$r['ip1'];
   $IP2=$r['ip2'];
   $IP3=$r['ip3'];
   $IP4=$r['ip4'];
   $IP5=$r['ip5'];
   $REMOVE_LINK=" [ <a href=\"scripts/admin_dnsserver_del.php?idds=$ID\">$LANGUAGE[267]</a> ] ";
   echo "
    <tr>
     <td class=$cl width=8%>$ID</td>
     <td class=$cl width=40%>$DESC</td>
     <td class=$cl width=50%>
      $NS1 -> $IP1 <br>
      $NS2 -> $IP2 <br>
      $NS3 -> $IP3 <br>
      $NS4 -> $IP4 <br>
      $NS5 -> $IP5 <br>
     </td>
     <td class=$cl width=12%>$REMOVE_LINK</td>
    </tr>
   ";
  }
  echo "</table>";
 }

 function add_dnsserver($DESC,$NS1,$IP1,$NS2,$IP2,$NS3,$IP3,$NS4,$IP4,$NS5,$IP5){
  $IDA=id_active_user();
  DbQuery("
   INSERT INTO servers_dns
   (
    description, ns1, ip1, ns2, ip2, ns3, ip3, ns4, ip4, ns5, ip5, ida
   )
    VALUES
   (
    '$DESC', '$NS1', '$IP1', '$NS2', '$IP2', '$NS3', '$IP3', '$NS4', '$IP4', '$NS5', '$IP5', '$IDA'
   )
  ");
 }

 function form_custom_dns_config_add($IDADMIN){
  global $LANGUAGE;
  $D="";
  $ns1=""; $ns2=""; $ns3=""; $ns4=""; $ns5="";  
  $ip1=""; $ip2=""; $ip3=""; $ip4=""; $ip5="";  
  echo "
   <form method=POST action=\"scripts/admin_custom_dns_add.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[270]</b></td><td width=50%><input type=text size=16 name=\"desc\" value=\"$D\"></td>
     <tr><td width=50%><b>$LANGUAGE[180]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$ns1\"></td>
     <tr><td width=50%><b>$LANGUAGE[179]</b></td><td width=50%><input type=text size=16 name=\"ip1\" value=\"$ip1\"></td>
     <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$ns2\"></td>
     <tr><td width=50%><b>$LANGUAGE[177]</b></td><td width=50%><input type=text size=16 name=\"ip2\" value=\"$ip2\"></td>
     <tr><td width=50%><b>$LANGUAGE[278]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$ns3\"></td>
     <tr><td width=50%><b>$LANGUAGE[279]</b></td><td width=50%><input type=text size=16 name=\"ip3\" value=\"$ip3\"></td>
     <tr><td width=50%><b>$LANGUAGE[280]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$ns4\"></td>
     <tr><td width=50%><b>$LANGUAGE[281]</b></td><td width=50%><input type=text size=16 name=\"ip4\" value=\"$ip4\"></td>
     <tr><td width=50%><b>$LANGUAGE[282]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[283]</b></td><td width=50%><input type=text size=16 name=\"ip5\" value=\"$ip5\"></td>
    </table>
    <input type=submit value=\" $LANGUAGE[277] \">
   </form>
  ";
 }

 function add_eppserver($TLD,$DESC,$ADDRESS,$USERNAME,$PASSWORD,$PROTO,$PORT){
  $PASSWORD=crypt_webpanel_string($PASSWORD);
  DbQuery("
   INSERT INTO servers_epp 
   (
    tld, description, address, username, password, proto, port
   )
    VALUES
   (
    '$TLD', '$DESC', '$ADDRESS', '$USERNAME', '$PASSWORD', '$PROTO', '$PORT'
   )
  ");
 }

 function select_epp_protocol($T){
  global $LANGUAGE;
  $V="";
  $V="<select class=select name=\"proto\" size=1>";
   if ($T=="EPPoTCP") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"EPPoTCP\">$LANGUAGE[272]</option>";
   if ($T=="EPPoHTTP") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"EPPoHTTP\">$LANGUAGE[273]</option>";
   if ($T=="EPPoSMTP") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"EPPoSMTP\">$LANGUAGE[274]</option>";
   if ($T=="EPPoTCPv2") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"EPPoTCPv2\">$LANGUAGE[275]</option>";
   if ($T=="EPPoCURL") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"EPPoCURL\">$LANGUAGE[276]</option>";
  $V.="</select>";
  return $V;
 }

 function webpanel_form_add_eppserver(){
  global $LANGUAGE;
  $EPP_PROTO=""; 
  $TLD="";
  $D="";
  $ADDRESS="";
  $U="";
  $P="";
  $U=""; 
  $EPP_PROTO="";
  echo "
   <form method=POST action=\"scripts/admin_add_eppserver.php\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[271]</b></td><td width=50%><input type=text size=16 name=\"tld\" value=\"$TLD\"></td>
     <tr><td width=50%><b>$LANGUAGE[270]</b></td><td width=50%><input type=text size=16 name=\"desc\" value=\"$D\"></td>
     <tr><td width=50%><b>$LANGUAGE[269]</b></td><td width=50%><input type=text size=16 name=\"address\" value=\"$ADDRESS\"></td>
     <tr><td width=50%><b>$LANGUAGE[264]</b></td><td width=50%><input type=text size=16 name=\"username\" value=\"$U\"></td>
     <tr><td width=50%><b>$LANGUAGE[265]</b></td><td width=50%><input type=text size=16 name=\"password\" value=\"$P\"></td>
     <tr><td width=50%><b>$LANGUAGE[266]</b></td><td width=50%>".select_epp_protocol($EPP_PROTO)."</td>
     <tr><td width=50%><b>$LANGUAGE[263]</b></td><td width=50%><input type=text size=16 name=\"port\" value=\"$U\"></td>
    </table>
    <input type=submit value=\" $LANGUAGE[268] \">
   </form>
  ";
 }

 function webpanel_eppserver_list(){
  global $LANGUAGE;
  DBSelect("SELECT * FROM servers_epp ORDER BY ides DESC",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=4%><b>$LANGUAGE[259]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[260]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[261]</b></td>
     <td class=lightgrey width=14%><b>$LANGUAGE[262]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[263]</b></td>
     <td class=lightgrey width=14%><b>$LANGUAGE[264]</b></td>
     <td class=lightgrey width=14%><b>$LANGUAGE[265]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[266]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[267]</b></td>
    </tr>
  ";
  $C=0;
  $REMOVE_LINK="";
  while (NextRecord($rs,$r)){
   $C++;
   if ($C%2==0) $cl="lightwhite1";
    else $cl="lightwhite2";
   $ID=$r['ides'];
   $TLD=$r['tld'];
   $DESC=$r['description'];
   $ADDRESS=$r['address'];
   $USERNAME=$r['username'];
   $PASSWORD=$r['password'];
   $PASSWORD=decrypt_webpanel_string($PASSWORD);
   $PASSWORD=mask_password($PASSWORD);
   $PROTO=$r['proto'];
   $PORT=$r['port'];
   $REMOVE_LINK=" [ <a href=\"scripts/admin_eppserver_del.php?ides=$ID\">$LANGUAGE[267]</a> ] ";
   echo "
    <tr>
     <td class=$cl width=4%>$ID</td>
     <td class=$cl width=8%>$TLD</td>
     <td class=$cl width=20%>$DESC</td>
     <td class=$cl width=14%>$ADDRESS</td>
     <td class=$cl width=8%>$PORT</td>
     <td class=$cl width=14%>$USERNAME</td>
     <td class=$cl width=14%>$PASSWORD</td>
     <td class=$cl width=10%>$PROTO</td>
     <td class=$cl width=8%>$REMOVE_LINK</td>
    </tr>
   ";
  }
  echo "</table>";
 }

 ########################################################################
 # Funzioni aggiunte 07/11/2009.
 ########################################################################

 function test_form_update_config(){
  global $LANGUAGE;
  test_client_get_info_A($U1,$P1,$S1);
  test_client_get_info_B($U2,$P2,$S2);
  echo "
   <form method=POST action=\"admin_nictest_update_config_do.php\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[252]</b></td><td width=50%><input type=text size=16 name=\"server1\" value=\"$S1\"></td>
     <tr><td width=50%><b>$LANGUAGE[253]</b></td><td width=50%><input type=text size=16 name=\"username1\" value=\"$U1\"></td>
     <tr><td width=50%><b>$LANGUAGE[254]</b></td><td width=50%><input type=text size=16 name=\"password1\" value=\"$P1\"></td>
     <tr><td width=50%><b>$LANGUAGE[255]</b></td><td width=50%><input type=text size=16 name=\"server2\" value=\"$S2\"></td>
     <tr><td width=50%><b>$LANGUAGE[256]</b></td><td width=50%><input type=text size=16 name=\"username2\" value=\"$U2\"></td>
     <tr><td width=50%><b>$LANGUAGE[257]</b></td><td width=50%><input type=text size=16 name=\"password2\" value=\"$P2\"></td>
    </table>
    <input type=submit value=\"$LANGUAGE[258]\">
   </form>
  ";
 }

 function test_client_debug_info($XML,$RESCODE,$REASONCODE){
  global $LANGUAGE;
  $xml=$XML;
  $DEBUG=is_debug_on();
  if ($DEBUG) {
   echo "<br><br>"; 
   print_xml_textarea($xml,"debugform",80,12);
   echo "<br><br>"; 
   if ($RESCODE!="") echo "<b>$LANGUAGE[250]</b> $RESCODE <br>";
   if ($REASONCODE!="") echo "<b>$LANGUAGE[251]</b> $REASONCODE <br>";
  }
 }

 function test_client_get_info_A(&$USERNAME,&$PASSWORD,&$SERVER){
  DbSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) {
   $USERNAME=$r['username1'];
   $PASSWORD=$r['password1'];
   $SERVER=$r['server1'];
  } else {
   $USERNAME="";
   $PASSWORD="";
   $SERVER="";
  }
 }

 function test_client_get_info_B(&$USERNAME,&$PASSWORD,&$SERVER){
  DbSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) {
   $USERNAME=$r['username2'];
   $PASSWORD=$r['password2'];
   $SERVER=$r['server2'];
  } else {
   $USERNAME="";
   $PASSWORD="";
   $SERVER="";
  }
 }

 function test_client_get_sessionid_A(){
  DbSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) return $r['https1'];
   else return "";
 }

 function test_client_get_sessionid_B(){
  DbSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) return $r['https2'];
   else return "";
 }

 function test_client_get_polling_id(){
  DbSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) return $r['polling_id'];
   else return "";
 }

 function test_client_update_polling_id($IDMSG){
  DbQuery("UPDATE epp_test SET polling_id='$IDMSG' WHERE idtest=1");
 }

 function test_client_update_info_A($SERVER,$USERNAME,$PASSWORD){
  DbQuery("UPDATE epp_test SET server1='$SERVER', username1='$USERNAME', password1='$PASSWORD' WHERE idtest=1");
 }

 function test_client_update_info_B($SERVER,$USERNAME,$PASSWORD){
  DbQuery("UPDATE epp_test SET server2='$SERVER', username2='$USERNAME', password2='$PASSWORD' WHERE idtest=1");
 }

 function test_client_update_sessionid_A($SESSIONID){
  DbQuery("UPDATE epp_test SET https1='$SESSIONID' WHERE idtest=1");
 } 

 function test_client_update_sessionid_B($SESSIONID){
  DbQuery("UPDATE epp_test SET https2='$SESSIONID' WHERE idtest=1");
 } 

 function client_update_eppcredit($IDA,$CRD){
  DbQuery("UPDATE admin_eppconfig SET eppcredit='$CRD' WHERE ida=$IDA");
 }

 ########################################################################
 # Funzioni aggiunte 07/11/2009.
 ########################################################################

 function actived_domain_name($DOMAIN){
  DbSelect("SELECT * FROM domain_names WHERE (name LIKE '$DOMAIN') AND (status<>0)",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }

 function exist_domain_name($DOMAIN){
  DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }

 function print_full_eppcode($IDD){
  global $LANGUAGE;
  DbSelect("SELECT * FROM domain_names WHERE idd=$IDD",$rs);
  if (NextRecord($rs,$r)) $EPPCODE=decrypt_webpanel_string($r['eppcode']);
   else $EPPCODE="";
  echo "$LANGUAGE[5]: <b>$EPPCODE</b>";
 }
 
 function polling_get_xml($IDP){
  DbSelect("SELECT * FROM epp_polling WHERE idp=$IDP",$rs);
  if (NextRecord($rs,$r)) {
   $XML=stripslashes($r['xml']);
   return $XML;
  } else {
   return "";
  }
 }

 function polling_get_deqxml($IDP){
  DbSelect("SELECT * FROM epp_polling WHERE idp=$IDP",$rs);
  if (NextRecord($rs,$r)) {
   $XML=stripslashes($r['xmldeq']);
   return $XML;
  } else {
   return "";
  }
 }

 function polling_set_status($IDP,$NEWSTATUS){
  DbQuery("UPDATE epp_polling SET status='$NEWSTATUS' WHERE idp=$IDP");
 }

 function polling_msg_upd_domain($IDP,$DOMAIN){
  global $LANGUAGE;
  if (!exist_domain_name($DOMAIN)){
   if ($DOMAIN!=$LANGUAGE[4]){
    import_domain_name($DOMAIN);
   }
  }
  if ($DOMAIN!="") {
   DbQuery("
    UPDATE epp_polling SET 
     domain='$DOMAIN'
      WHERE idp=$IDP
   ");
  }
 }

 function polling_msg_upd_xmldeq($IDP,$XMLDEQ){
  $XMLDEQ=addslashes($XMLDEQ);
  DbQuery("
   UPDATE epp_polling SET 
    xmldeq='$XMLDEQ'
     WHERE idp=$IDP
  ");
 }

 function get_iddomain($HOST){
  $HOST=strMinusc($HOST);
  $L=StrLen($HOST); 
  $WWW=SubStr($HOST,0,4);
  if ($WWW=="www.") $DOMAIN=SubStr($HOST,4,$L);
   else $DOMAIN=$HOST;
  DBSelect("SELECT * FROM domain_names WHERE name LIKE '$HOST'",$rs);
  if (NextRecord($rs,$r)) return $r['idd']; else return 0;
 }

 function process_polling_opcode($DOMAIN,$OPCODE){
  $IDD=get_iddomain($DOMAIN);
  if ($OPCODE==1) {
   $ST=get_domain_status($IDD);
   if ($ST==0) update_domain_status_byname($DOMAIN,15);
  }
  if ($OPCODE==2) {
   $ST=get_domain_status($IDD);
   update_domain_status_byname($DOMAIN,1);
  }
  if ($OPCODE==13) {
   $ST=get_domain_status($IDD);
   update_domain_status_byname($DOMAIN,1);
  }
  if ($OPCODE==3) {
   if ($ST!=15) update_domain_status_byname($DOMAIN,12);
  }
  if ($OPCODE==5) {
   renew_domain_name_byname($DOMAIN,1);
  }
  if ($OPCODE==6) {
   update_domain_status_byname($DOMAIN,7);
  }
  if ($OPCODE==10) {
   update_domain_status_byname($DOMAIN,3);
  }
  if ($OPCODE==12) {
   update_domain_status_byname($DOMAIN,4);
  }
  if ($OPCODE==14) {
   update_domain_status_byname($DOMAIN,12);
  }
  if ($OPCODE==16) {
   update_domain_status_byname($DOMAIN,12);
  }
  if ($OPCODE==17) {
   update_domain_status_byname($DOMAIN,4);
  }
  if ($OPCODE==18) {
   update_domain_status_byname($DOMAIN,3);
  }
  if ($OPCODE==19) {
   update_domain_status_byname($DOMAIN,1);
  }
  if ($OPCODE==20) {
   update_domain_status_byname($DOMAIN,1);
  }
  if ($OPCODE==21) {
   update_domain_status_byname($DOMAIN,4);
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
   external_domain_delete($DOMAIN);
  }
  if ($OPCODE==26) {
   update_domain_status_byname($DOMAIN,1);
  }
  if ($OPCODE==27) {
   update_domain_status_byname($DOMAIN,4);
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
   external_domain_delete($DOMAIN);
  }
  if ($OPCODE==29) {
   update_domain_status_byname($DOMAIN,4);
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
   external_domain_delete($DOMAIN);
  }
  if ($OPCODE==31) {
   update_domain_status_byname($DOMAIN,4);
   del_domain_dns($IDD);
   del_domain_name($IDD);
   del_domain_flags($IDD);
   del_domain_status($IDD);
   external_domain_delete($DOMAIN);
  }
 }

 function polling_msg_upd($IDP,$XMLDEQ,$DOMAIN,$OPCODE){
  update_polling_opcode($IDP,$OPCODE);
  polling_msg_upd_xmldeq($IDP,$XMLDEQ); 
  polling_msg_upd_domain($IDP,$DOMAIN);
  process_polling_opcode($DOMAIN,$OPCODE);
 }

 function update_polling_opcode($IDP,$OPCODE){
  DbQuery("
   UPDATE epp_polling SET 
    opcode='$OPCODE'
     WHERE idp=$IDP
  ");
 }

 function search_polling_opcode($TITLE){
  global $POLLCOD, $NPOLLCOD;
  $FOUND=FALSE;
  $C=0;
  $OP=0;
  while ((!$FOUND)&&($C<$NPOLLCOD)) {
   $C++; 
   if ($POLLCOD[$C]==$TITLE){
    $FOUND=TRUE;
    $OP=$C;
   }
  }
  return $OP;
 }

 function polling_msg_add($IDMSG,$QT,$DATA,$TITLE,$XML,$XMLDEQ,$DOMAIN,$OPCODE){
  global $LANGUAGE;
  if (!exist_domain_name($DOMAIN)){
   if ($DOMAIN!=$LANGUAGE[4]) {
    import_domain_name($DOMAIN);
   }
  }
  $TITLE=addslashes($TITLE);
  $XML=addslashes($XML);
  $XMLDEQ=addslashes($XMLDEQ);
  DbSelect("SELECT * FROM epp_polling WHERE code=$IDMSG",$rs);
  if (NextRecord($rs,$r)) {
  } else {
   $OPCODE=search_polling_opcode($TITLE);
   DbQuery("
    INSERT INTO epp_polling (
     code, data, title, qt, xml, status, xmldeq, domain, opcode
    ) VALUES (
     $IDMSG, '$DATA', '$TITLE', '$QT', '$XML', 'Waiting', '$XMLDEQ', '$DOMAIN', '$OPCODE'
    )
   ");
   mail_notify_msg(2,$DOMAIN,$TITLE);
   $IDP=get_id_polling($IDMSG);
   update_polling_opcode($IDP,$OPCODE);
   process_polling_opcode($DOMAIN,$OPCODE);
  }
 } 

 ########################################################################
 # Funzioni aggiunte 06/11/2009.
 ########################################################################

 function get_domain_status($IDD){
  DbSelect("SELECT * FROM domain_names WHERE idd=$IDD",$rs);
  if (NextRecord($rs,$r)) {
   return $r['status'];
  } else return "";
 }

 function get_domain_status_byname($DOMAIN){
  DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   return $r['status'];
  } else return "";
 }

 function update_domain_status($IDD,$NEWSTATUS){
  DbQuery("UPDATE domain_names SET status='$NEWSTATUS' WHERE idd=$IDD");
 }

 function update_domain_status_byname($DOM,$NEWSTATUS){
  DbQuery("UPDATE domain_names SET status='$NEWSTATUS' WHERE name LIKE '$DOM'");
 }

 function webpanel_delete_contact($IDC){
  DbQuery("DELETE FROM domain_contacts WHERE idc=$IDC");
 }

 function update_contact_address($idc,$address,$zipcode,$city,$province,$country,$email){
  DBQuery("
   UPDATE domain_contacts SET
    address='$address',
    zipcode='$zipcode',
    city='$city',
    province='$province',
    country='$country',
    email='$email'
   WHERE idc=$idc
  ");
 }

 function update_contact_tel($IDC,$TEL){
  DbQuery("UPDATE domain_contacts SET tel='$TEL' WHERE idc=$IDC");
 }

 function update_contact_fax($IDC,$FAX){
  DbQuery("UPDATE domain_contacts SET fax='$FAX' WHERE idc=$IDC");
 }

 function update_contact_privacy($IDC,$PUB){
  DbQuery("UPDATE domain_contacts SET pubblish='$PUB' WHERE idc=$IDC");
 }

 function update_contact_field($IDC,$FIELD,$NEWVALUE){
  DbQuery("UPDATE domain_contacts SET $FIELD='$NEWVALUE' WHERE idc=$IDC");
 }

 ########################################################################
 # Funzioni aggiunte 03/11/2009.
 ########################################################################

 function get_contact_status($IDC){
  DbSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   return $r['status'];
  } else return "";
 }

 function update_contact_status($IDC,$NEWSTATUS){
  DbQuery("UPDATE domain_contacts SET status='$NEWSTATUS' WHERE idc=$IDC");
 }

 function client_select_cid_type($CT){
  global $LANGUAGE;
  $V="";
  $V="<select class=select name=\"cidtype\" size=1>";
   if ($CT=="R") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"R\">$LANGUAGE[246]</option>";
   if ($CT=="A") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"A\">$LANGUAGE[247]</option>";
   if ($CT=="T") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"T\">$LANGUAGE[248]</option>";
   if ($CT=="B") $SEL="selected"; else $SEL="";
   $V.="<option $SEL value=\"B\">$LANGUAGE[249]</option>";
  $V.="</select>";
  return $V;
 }

 function client_select_contacttype($CT){
  global $LANGUAGE;
  DBSelect("SELECT * FROM client_contactstype WHERE idlang=1 ORDER BY idct ASC",$rs);
  $V="";
  if ($CT!=""){
   $V="<select class=select name=\"usertype\" size=1>";
  } else {
   $V="<select class=select name=\"usertype\" size=1>";
   $V.="<option selected value=\"1\">$LANGUAGE[245]</option>";
  }
  while (NextRecord($rs,$r)) {
   if ($CT==$r['idct']) $SEL="selected";
    else $SEL="";
   $V.="<option $SEL value=\"".$r['idct']."\">".$r['desc']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function client_select_sex($VALUE){
  global $LANGUAGE;
  $txt="<select class=select name=\"usersex\" size=1>";
  if ($VALUE=="") $txt.="<option value=\"\">$LANGUAGE[244]</option>";
  if ($VALUE=="M") {
   $T="selected"; 
   $F="";
  } else if ($VALUE=="F") {
   $T=""; 
   $F="selected";
  } else {
   $T=""; 
   $F="";
  }
  $txt.="<option $T value=\"M\">$LANGUAGE[242]</option>";
  $txt.="<option $F value=\"F\">$LANGUAGE[243]</option>";
  $txt.="</select>";
  return $txt;
 }

 function client_select_faxprefix($FAXPREFIX){
  global $LANGUAGE,$DEFAULT_COUNTRY_TELPREFIX;
  DBSelect("SELECT * FROM client_countries ORDER BY country ASC",$rs);
  $V="";
  if ($FAXPREFIX!=""){
   $V="<select class=select name=\"faxprefix\" size=1>";
  } else {
   $V="<select class=select name=\"faxprefix\" size=1>";
   $V.="<option selected value=\"$DEFAULT_COUNTRY_TELPREFIX\">$LANGUAGE[241]</option>";
  }
  while (NextRecord($rs,$r)) {
   if ($FAXPREFIX==$r['telprefix']) $SEL="selected";
    else $SEL="";
   $V.="<option $SEL value=\"".$r['telprefix']."\">".$r['isocode']." ".$r['telprefix']." </option>";
  }
  $V.="</select>";
  return $V;
 }

 function client_select_telprefix($TELPREFIX){
  global $LANGUAGE,$DEFAULT_COUNTRY_TELPREFIX;
  DBSelect("SELECT * FROM client_countries ORDER BY country ASC",$rs);
  $V="";
  if ($TELPREFIX!=""){
   $V="<select class=select name=\"telprefix\" size=1>";
  } else {
   $V="<select class=select name=\"telprefix\" size=1>";
   $V.="<option selected value=\"$DEFAULT_COUNTRY_TELPREFIX\">$LANGUAGE[241]</option>";
  }
  while (NextRecord($rs,$r)) {
   if ($TELPREFIX==$r['telprefix']) $SEL="selected";
    else $SEL="";
   $V.="<option $SEL value=\"".$r['telprefix']."\">".$r['isocode']." ".$r['telprefix']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function client_select_country($COUNTRY){
  global $LANGUAGE,$DEFAULT_COUNTRY_CODE;
  DBSelect("SELECT * FROM client_countries ORDER BY country ASC",$rs);
  $V="";
  if ($COUNTRY!=""){
   $V="<select class=select name=\"country\" size=1>";
  } else {
   $V="<select class=select name=\"country\" size=1>";
   $V.="<option selected value=\"$DEFAULT_COUNTRY_CODE\">$LANGUAGE[240]</option>";
  }
  while (NextRecord($rs,$r)) {
   if ($COUNTRY==$r['isocode']) $SEL="selected";
    else $SEL="";
   $V.="<option $SEL value=\"".$r['isocode']."\">".$r['isocode']." - ".$r['country']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function client_select_nationality($NATIONALITY){
  global $LANGUAGE,$DEFAULT_COUNTRY_CODE;
  DBSelect("SELECT * FROM client_countries ORDER BY country ASC",$rs);
  $V="";
  if ($NATIONALITY!=""){
   $V="<select class=select name=\"nationality\" size=1>";
  } else {
   $V="<select class=select name=\"nationality\" size=1>";
   $V.="<option selected value=\"$DEFAULT_COUNTRY_CODE\">$LANGUAGE[240]</option>";
  }
  while (NextRecord($rs,$r)) {
   if ($NATIONALITY==$r['isocode']) $SEL="selected";
    else $SEL="";
   $V.="<option $SEL value=\"".$r['isocode']."\">".$r['isocode']." - ".$r['country']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function webpanel_logs_add($TYPE,$DESC){
  $T=time();
  $IP=$_SERVER['REMOTE_ADDR'];
  $DESC=addslashes($DESC);
  DbQuery("
   INSERT INTO client_logs 
    (logtype, logtime, logdesc, logip)
    VALUES 
    ('$TYPE', '$T', '$DESC', '$IP')
  ");
 }

 function count_total_logs(){
  DBSelect("SELECT COUNT(*) AS CNT FROM client_logs",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_logs_show($PAG){
  global $LANGUAGE;

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_logs();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_logs.php?bar=true");
  DBSelect("SELECT * FROM client_logs ORDER BY idl DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=4%><b>$LANGUAGE[235]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[236]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[237]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[238]</b></td>
     <td class=lightgrey width=60%><b>$LANGUAGE[239]</b></td>
    </tr>
  ";
  while (NextRecord($rs,$r)){
   $IDL=$r['idl'];
   $T=$r['logtype'];
   $D=$r['logtime'];
   $D=date("d/m/Y H:i:s",$D);;
   $IP=$r['logip'];
   $DESC=$r['logdesc'];
   echo "
    <tr>
     <td class=lightwhite width=4%>$IDL</td>
     <td class=lightwhite width=12%>$T</td>
     <td class=lightwhite width=12%>$IP</td>
     <td class=lightwhite width=12%>$D</td>
     <td class=lightwhite width=60%><div align=left>$DESC</div></td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_logs.php?bar=true");
 }

 ########################################################################
 # Funzioni aggiunte 27/10/2009.
 ########################################################################

 function form_update_domain_dns($IDADMIN, $IDD){
  global $LANGUAGE;
  $IDDS=get_servers_idds();
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  echo "
   <form method=POST action=\"scripts/update_domain_dns.php?iddomain=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[180]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$NS1\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[178]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$NS2\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$NS3\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$NS4\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$NS5\"></td></tr>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$NS6\"></td></tr>
    </table>
    <table width=320><tr><td width=100%>
     <br> $LANGUAGE[561] <br><br>
     ".client_select_dns_removecheck()."
     <br><br>
    </td></tr></table>
    <table width=320><tr><td width=100%>
     <br> $LANGUAGE[232] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
    <br> 
    <input type=submit value=\" $LANGUAGE[231] \">
   </form>
  ";
 }

 function form_update_domain_dns_ips($IDADMIN, $IDD){
  global $LANGUAGE;
  $IDDS=get_servers_idds();
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  echo "
   <form method=POST action=\"scripts/update_domain_dns_ips.php?iddomain=$IDD\">
    <table width=98%>
     <tr>
      <td width=16%><b>$LANGUAGE[180]</b></td><td width=16%><input type=text size=16 name=\"ns1\" value=\"$NS1\"></td>
      <td width=16%><b>$LANGUAGE[233]</b></td><td width=15%><input type=text size=16 name=\"ip1\" value=\"$IP1\"></td>
      <td width=16%><b>$LANGUAGE[565]</b></td><td width=16%><input type=text size=16 name=\"ipv6n1\" value=\"$IPV6N1\"></td>
     </tr>
     <tr>
      <td width=16%><b>$LANGUAGE[178]</b></td><td width=16%><input type=text size=16 name=\"ns2\" value=\"$NS2\"></td>
      <td width=16%><b>$LANGUAGE[234]</b></td><td width=15%><input type=text size=16 name=\"ip2\" value=\"$IP2\"></td>
      <td width=16%><b>$LANGUAGE[566]</b></td><td width=16%><input type=text size=16 name=\"ipv6n2\" value=\"$IPV6N2\"></td>
     </tr>
     <tr>
      <td width=16%><b>$LANGUAGE[535]</b></td><td width=16%><input type=text size=16 name=\"ns3\" value=\"$NS3\"></td>
      <td width=16%><b>$LANGUAGE[536]</b></td><td width=15%><input type=text size=16 name=\"ip3\" value=\"$IP3\"></td>
      <td width=16%><b>$LANGUAGE[567]</b></td><td width=16%><input type=text size=16 name=\"ipv6n3\" value=\"$IPV6N3\"></td>
     </tr>
     <tr>
      <td width=16%><b>$LANGUAGE[537]</b></td><td width=16%><input type=text size=16 name=\"ns4\" value=\"$NS4\"></td>
      <td width=16%><b>$LANGUAGE[538]</b></td><td width=15%><input type=text size=16 name=\"ip4\" value=\"$IP4\"></td>
      <td width=16%><b>$LANGUAGE[568]</b></td><td width=16%><input type=text size=16 name=\"ipv6n4\" value=\"$IPV6N4\"></td>
     </tr>
     <tr>
      <td width=16%><b>$LANGUAGE[539]</b></td><td width=16%><input type=text size=16 name=\"ns5\" value=\"$NS5\"></td>
      <td width=16%><b>$LANGUAGE[540]</b></td><td width=15%><input type=text size=16 name=\"ip5\" value=\"$IP5\"></td>
      <td width=16%><b>$LANGUAGE[569]</b></td><td width=16%><input type=text size=16 name=\"ipv6n5\" value=\"$IPV6N5\"></td>
     </tr>
     <tr>
      <td width=16%><b>$LANGUAGE[571]</b></td><td width=16%><input type=text size=16 name=\"ns6\" value=\"$NS6\"></td>
      <td width=16%><b>$LANGUAGE[564]</b></td><td width=15%><input type=text size=16 name=\"ip6\" value=\"$IP6\"></td>
      <td width=16%><b>$LANGUAGE[570]</b></td><td width=16%><input type=text size=16 name=\"ipv6n6\" value=\"$IPV6N6\"></td>
     </tr>
    </table>
    <table width=98%><tr><td width=100%>
     <br> $LANGUAGE[561] <br><br>
     ".client_select_dns_removecheck()."
     <br><br>
    </td></tr></table>
    <table width=98%><tr><td width=100%>
     <br> $LANGUAGE[232] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
    <br> 
    <input type=submit value=\" $LANGUAGE[231] \">
   </form>
  ";
 }

 function str_domain_status($STATUS){
  global $LANGUAGE;
  if ($STATUS==0) return "$LANGUAGE[227]";
   else if ($STATUS==1) return "$LANGUAGE[228]";
   else if ($STATUS==2) return "$LANGUAGE[229]";
   else if ($STATUS==3) return "$LANGUAGE[230]";
    else return "";
 }

 function add_domain_dns($IDDOMAIN, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6){
  if ($NS1!="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS1', '$IP1')");
  if ($NS2!="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS2', '$IP2')");
  if ($NS3!="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS3', '$IP3')");
  if ($NS4!="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS4', '$IP4')");
  if ($NS5!="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS5', '$IP5')");
  if ($NS56="") DbQuery("INSERT INTO domain_nameservers (idd, ns, ip) VALUES ($IDDOMAIN, '$NS6', '$IP6')");
 }

 function del_domain_status($IDDOMAIN){
  DbQuery("DELETE FROM domain_status WHERE idd=$IDDOMAIN");
 }

 function del_domain_flags($IDDOMAIN){
  DbQuery("DELETE FROM domain_flags WHERE idd=$IDDOMAIN");
 }

 function del_domain_name($IDDOMAIN){
  DbQuery("DELETE FROM domain_names WHERE idd=$IDDOMAIN");
 }

 function del_domain_dns($IDDOMAIN){
  DbQuery("DELETE FROM domain_nameservers WHERE idd=$IDDOMAIN");
 }

 function get_domain_dnsinfo($ID, &$NS1, &$NS2, &$NS3, &$NS4, &$NS5, &$NS6, &$IP1, &$IP2, &$IP3, &$IP4, &$IP5, &$IP6){
  DBSelect("SELECT * FROM domain_nameservers WHERE idd=$ID ORDER BY idns ASC",$rs);
  if (NextRecord($rs,$r)) { $NS1=$r['ns']; $IP1=$r['ip']; } else { $NS1=""; $IP1=""; }  
  if (NextRecord($rs,$r)) { $NS2=$r['ns']; $IP2=$r['ip']; } else { $NS2=""; $IP2=""; }  
  if (NextRecord($rs,$r)) { $NS3=$r['ns']; $IP3=$r['ip']; } else { $NS3=""; $IP3=""; }  
  if (NextRecord($rs,$r)) { $NS4=$r['ns']; $IP4=$r['ip']; } else { $NS4=""; $IP4=""; }  
  if (NextRecord($rs,$r)) { $NS5=$r['ns']; $IP5=$r['ip']; } else { $NS5=""; $IP5=""; }  
  if (NextRecord($rs,$r)) { $NS6=$r['ns']; $IP6=$r['ip']; } else { $NS6=""; $IP6=""; }  
 }

 function get_domain_info($ID, &$NAME, &$EPPCODE, &$IDREG, &$IDADM, &$IDTECH, &$IDBILL){
  DBSelect("SELECT * FROM domain_names WHERE idd=$ID",$rs);
  if (NextRecord($rs,$r)) {
   $NAME=$r['name'];
   $EPPCODE=$r['eppcode'];
   $EPPCODE=decrypt_webpanel_string($EPPCODE);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];
   $NAME=utf8_encode($NAME);
  } else {
   $NAME="";
   $EPPCODE="";
   $IDREG="";
   $IDADM="";
   $IDTECH="";
   $IDBILL="";
  }
 }

 function get_domain_info_idn($ID, &$NAME, &$EPPCODE, &$IDREG, &$IDADM, &$IDTECH, &$IDBILL){
  DBSelect("SELECT * FROM domain_names WHERE idd=$ID",$rs);
  if (NextRecord($rs,$r)) {
   $NAME=$r['name'];
   $EPPCODE=$r['eppcode'];
   $EPPCODE=decrypt_webpanel_string($EPPCODE);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];
  } else {
   $NAME="";
   $EPPCODE="";
   $IDREG="";
   $IDADM="";
   $IDTECH="";
   $IDBILL="";
  }
 }

 ########################################################################
 # Funzioni aggiunte 12/10/2009.
 ########################################################################

 function aggiorna_username($ID,$USERNAME){
  DbQuery("UPDATE admin_users SET username='$USERNAME' WHERE ida=$ID");
 }

 function aggiorna_password($ID,$PASSWORD){
  $PASSWORD=crypt_webpanel_string($PASSWORD);
  DbQuery("UPDATE admin_users SET password='$PASSWORD' WHERE ida=$ID");
 }

 function get_contact_info(
  &$ID, &$FULLNAME, &$ORG, &$ADDRESS, &$CITY, &$STATE, &$ZIPCODE, &$COUNTRY, &$TEL, &$FAX, &$EMAIL, &$PUB, 
   &$NT, &$TYPE, &$CTYPE, &$CF, &$SEX
 ){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) $PREFIX=$r['contactid_prefix']; else $PREFIX="";
  DBSelect("SELECT * FROM domain_contacts WHERE idc='$ID'",$rs);
  if (NextRecord($rs,$r)) {
   $IDC=$r['idc'];
   $ID=$r['contact_id'];
   $NAME=stripslashes($r['name']);
   $SURNAME=stripslashes($r['surname']);
   $FULLNAME="$NAME $SURNAME";
   $COMPANY=stripslashes($r['company']);
   $TYPE=$r['usertype'];
   if (($COMPANY!="")&&($TYPE!=0)){
    $ORG=$COMPANY;
    $CF=$r['vatcode'];
   } else {
    $ORG="";
    $CF=$r['fiscalcode'];
   }
   if ($CF=="") {
    $CF=$r['fiscalcode'].$r['vatcode'];
   }
   $ADDRESS=stripslashes($r['address']);
   $ZIPCODE=$r['zipcode'];
   $CITY=stripslashes($r['city']);
   $STATE=stripslashes($r['province']);
   $COUNTRY=stripslashes($r['country']);
   $TEL=$r['tel'];
   $FAX=$r['fax'];
   $EMAIL=$r['email'];
   $NT=$r['nationality'];
   $CTYPE=$r['cidtype'];
   $PUB=$r['pubblish'];
   if ($PUB=="True") $PUB=0;
    else $PUB=1;
   $SEX=$r['sex'];
  }
 }

 function get_contact_info_ext(
  &$ID, &$NAME, &$SURNAME, &$ORG, &$ADDRESS, &$CITY, &$STATE, &$ZIPCODE, &$COUNTRY, &$TEL, &$FAX, &$EMAIL, &$PUB, 
   &$NT, &$TYPE, &$CTYPE, &$CF, &$VAT, &$SEX
 ){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) $PREFIX=$r['contactid_prefix']; else $PREFIX="";
  DBSelect("SELECT * FROM domain_contacts WHERE idc='$ID' ORDER BY idc DESC",$rs);
  if (NextRecord($rs,$r)) {
   $IDC=$r['idc'];
   $ID=$r['contact_id'];
   $NAME=stripslashes($r['name']);
   $SURNAME=stripslashes($r['surname']);
   $FULLNAME="$NAME $SURNAME";
   $COMPANY=stripslashes($r['company']);
   if ($COMPANY!=""){
    $ORG=$COMPANY;
   } else {
    $ORG="";
   } 
   $CF=$r['fiscalcode'];
   $VAT=$r['vatcode'];
   $ADDRESS=stripslashes($r['address']);
   $ZIPCODE=$r['zipcode'];
   $CITY=stripslashes($r['city']);
   $STATE=stripslashes($r['province']);
   $COUNTRY=stripslashes($r['country']);
   $TEL=$r['tel'];
   $FAX=$r['fax'];
   $EMAIL=$r['email'];
   $NT=$r['nationality'];
   $TYPE=$r['usertype'];
   $CTYPE=$r['cidtype'];
   $PUB=$r['pubblish'];
   if ($PUB=="True") $PUB=1;
    else $PUB=0;
   $SEX=$r['sex'];
  }
 }

 ########################################################################
 # Funzioni aggiunte 12/10/2009.
 ########################################################################

 function nameserver_queue_domain_update($IDD){
  $STATUS=2;
  DBQuery("UPDATE domain_status SET status=2 WHERE idd=$IDD");
 }

 function nameserver_queue_domain($IDD,$DOMAIN){
  $STATUS=0;
  DBQuery("INSERT INTO domain_status VALUES ('$IDD', '$DOMAIN', '$STATUS')");
 }

 function create_random_eppcode(){
  $str="";
  randomize(); 
  for ($i=0;$i<16;$i++) {
     $rndvalue=mt_rand(1,3);
     $rndvalue2=mt_rand(1,1000);
     if ($rndvalue==1) $ch=chr(($rndvalue2 % 10)+48);
     if ($rndvalue==2) $ch=chr(($rndvalue2 % 26)+65);
     if ($rndvalue==3) $ch=chr(($rndvalue2 % 26)+97);
     $str="$str$ch";
   }
  return $str;
 } 

 function update_domain($IDD,$DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL){
  global $LANGUAGE;
  if ($DOMAIN!="") {
   DBQuery("
    UPDATE domain_names SET
     name='$DOMAIN',
     idregistrant='$IDREG',
     idadmin='$IDADM',
     idtech='$IDTECH',
     idbill='$IDBILL'
    WHERE idd=$IDD
   ");
  } else {
   echo "$LANGUAGE[223]<br>";
   echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
   die();
  }
 }

 function update_domain_idn($IDD,$DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL){
  global $LANGUAGE;
  if ($DOMAIN!="") {
   DBQuery("
    UPDATE domain_names SET
     name='$DOMAIN',
     idregistrant='$IDREG',
     idadmin='$IDADM',
     idtech='$IDTECH',
     idbill='$IDBILL'
    WHERE idd=$IDD
   ");
  } else {
   echo "$LANGUAGE[223]<br>";
   echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
   die();
  }
 }

 function update_domain_updating($IDDOMAIN){
  $UPDATED=time();
  DbQuery("UPDATE domain_names SET updated='$UPDATED' WHERE idd=$IDDOMAIN");
 }

 function update_domain_creation($IDDOMAIN){
  $CREATED=time();
  DbQuery("UPDATE domain_names SET created='$CREATED', updated='$CREATED' WHERE idd=$IDDOMAIN");
 }

 function update_domain_expiration($IDDOMAIN,$YEARS){
  $TY=(3600*24*365)*$YEARS;
  DbQuery("UPDATE domain_names SET expire=expire+$TY WHERE idd=$IDDOMAIN");
 }

 function create_domain($DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL){
  global $LANGUAGE;
  $IDA=id_active_user();
  DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   $DUPDOM=TRUE;
  } else {
   $DUPDOM=FALSE;
  }
  if ($DOMAIN!="") {
   if (!$DUPDOM) {
    $YEAR=3600*24*365;
    $CREATED=time();
    $UPDATED=time();
    $EXPIRE=time()+$YEAR;
    $EPPCODE=create_random_eppcode();
    $EPPCODE=crypt_webpanel_string($EPPCODE);
    $EPPCODE=addslashes($EPPCODE);
    $STATUS=0;
    DBQuery("
     INSERT INTO domain_names 
     (
      name, created, updated, expire, eppcode, status, idregistrant, idadmin, idtech, idbill, ida
     ) 
      VALUES 
     (
      '$DOMAIN', '$CREATED', '$UPDATED', '$EXPIRE', '$EPPCODE', $STATUS, '$IDREG', '$IDADM', '$IDTECH', '$IDBILL', '$IDA'
     )
    ");
    DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
    if (NextRecord($rs,$r)) {
     return $r['idd'];
    } else {
     return 0;
    }
   } else {
    echo "$LANGUAGE[226]<br>";
    echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
    die();
   } 
  } else {
   echo "$LANGUAGE[223]<br>";
   echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
   die();
  }
 }

 function create_domain_to_import($DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL){
  $IDA=id_active_user();
  DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   $DUPDOM=TRUE;
  } else {
   $DUPDOM=FALSE;
  }
  if ($DOMAIN!="") {
   if (!$DUPDOM) {
    $YEAR=3600*24*365;
    $CREATED=time();
    $UPDATED=time();
    $EXPIRE=time()+$YEAR;
    $EPPCODE=create_random_eppcode();
    $EPPCODE=crypt_webpanel_string($EPPCODE);
    $EPPCODE=addslashes($EPPCODE);
    $STATUS=12;
    DBQuery("
     INSERT INTO domain_names 
     (
      name, created, updated, expire, eppcode, status, idregistrant, idadmin, idtech, idbill, ida
     )
      VALUES 
     (
      '$DOMAIN', '$CREATED', '$UPDATED', '$EXPIRE', '$EPPCODE', $STATUS, '$IDREG', '$IDADM', '$IDTECH', '$IDBILL', '$IDA'
     )
    ");
    DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
    if (NextRecord($rs,$r)) {
     return $r['idd'];
    } else {
     return 0;
    }
   } else {
   } 
  } else {
  }
 }

 function transfert_domain($DOMAIN,$IDREG,$IDADM,$IDTECH,$IDBILL,$EPPCODE){
  global $LANGUAGE;
  $IDA=id_active_user();
  DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
  if (NextRecord($rs,$r)) {
   $DUPDOM=TRUE;
  } else {
   $DUPDOM=FALSE;
  }
  if ($DOMAIN!="") {
   if (!$DUPDOM) {
    $YEAR=3600*24*365;
    $CREATED=time();
    $UPDATED=time();
    $EXPIRE=time()+$YEAR;
    $STATUS=2;
    $EPPCODE=crypt_webpanel_string($EPPCODE);
    $EPPCODE=addslashes($EPPCODE);
    DBQuery("
     INSERT INTO domain_names 
     (
      name, created, updated, expire, eppcode, status, idregistrant, idadmin, idtech, idbill, ida
     )
      VALUES 
     (
      '$DOMAIN', '$CREATED', '$UPDATED', '$EXPIRE', '$EPPCODE', $STATUS, '$IDREG', '$IDADM', '$IDTECH', '$IDBILL', '$IDA'
     )
    ");
    DbSelect("SELECT * FROM domain_names WHERE name LIKE '$DOMAIN'",$rs);
    if (NextRecord($rs,$r)) {
     return $r['idd'];
    } else {
     return 0;
    }
   } else {
    echo "$LANGUAGE[226]<br>";
    echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
    die();
   } 
  } else {
   echo "$LANGUAGE[223]<br>";
   echo "$LANGUAGE[224] <a href=\"../admin_domini.php\">$LANGUAGE[225]</a>.<br>";
   die();
  }
 }

 function is_debug_on(){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE debug='True' AND ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }

 function is_exam_on(){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE exam='True' AND ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   return TRUE;
  } else return FALSE;
 }

 function update_config($IDA,$IDREG,$IDADMIN,$IDTECH,$IDBILL,$IP1,$IP2,$IP3,$IP4,$IP5,$NS1,$NS2,$NS3,$NS4,$NS5,$PREFIX,$DEBUG,$EXAM){
  DBQuery("
   UPDATE admin_eppconfig SET 
    idregistrant='$IDREG', idadmin='$IDADMIN', idtech='$IDTECH', idbill='$IDBILL',
     ip1='$IP1', ip2='$IP2', ip3='$IP3', ip4='$IP4', ip5='$IP5',
      ns1='$NS1', ns2='$NS2', ns3='$NS3', ns4='$NS4', ns5='$NS5',
      contactid_prefix='$PREFIX', debug='$DEBUG', exam='$EXAM' 
       WHERE ida=$IDA
  ");
 }

 function select_option($NAME,$VALUE){
  global $LANGUAGE;
  $txt="<select class=select name=\"$NAME\" size=1>";
  if ($VALUE=="True") {
   $T="selected"; 
   $F="";
  } else if ($VALUE=="False") {
   $T=""; 
   $F="selected";
  } else {
   $T=""; 
   $F="";
  }
  $txt.="<option $T value=\"True\">$LANGUAGE[221]</option>";
  $txt.="<option $F value=\"False\">$LANGUAGE[222]</option>";
  $txt.="</select>";
  return $txt;
 }
 
 function update_teststatus($STATUS){
  DBQuery("UPDATE epp_test SET status='$STATUS' WHERE idtest=1");
 }

 function change_test_step($POS,$NEWVAL,&$STATUS){
  $N=$POS-1;
  $L=substr($STATUS,0,$N);
  $R=substr($STATUS,$POS,42-$POS);
  $STATUS=$L.$NEWVAL.$R;
 }

 function nictest_reset_allsteps(){
  $STATUS="111111111111111111111111111111111111111111";
  update_teststatus($STATUS);
 }

 function print_nictest_steps($STEP){
  global $TEST_STEPS;
  get_epptestinfo($USER1,$USER2,$PASS1,$PASS2,$TESTSTATUS);

  if (($STEP>=1)&&($STEP<=42)){
   change_test_step($STEP,"0",$TESTSTATUS);
   update_teststatus($TESTSTATUS);
  }

  echo " 
   $TEST_STEPS[43] <br><br>
   $TEST_STEPS[44] <br><br>
  ";
  echo " <table width=99% cellpadding=2 cellspacing=2><tr><td valign=top><div align=left> ";
  for ($i=1; $i<=24; $i++) {
   $S=substr($TESTSTATUS,$i-1,1);
   if ($i==6) { echo "<br>"; }
   if ($i==11) { echo "<br>"; }
   if ($i==17) { echo "<br>"; }
   if ($i==19) { echo "<br>"; }
   if ($i==21) { echo "<br>"; }
   if ($i==24) { echo "<br>"; }
   if ($i==$STEP) $TARGET=" <== "; else $TARGET="";
   if ($S=="0") { 
    echo " <b>[$i]</b> $TEST_STEPS[$i] (Done!) $TARGET<br>";
   } else {
    echo " <b>[$i]</b> <a href=\"admin_nictest_step$i.php\">$TEST_STEPS[$i]</a> $TARGET<br>";
   }

   if ($i==6) {
    $S2=substr($TESTSTATUS,29,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[30] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[30]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,30,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[31] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[31]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,31,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[3]</b> $TEST_STEPS[32] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[3]</b> <a href=\"admin_nictest_step$i.3.php\">$TEST_STEPS[32]</a> $TARGET<br>";
    }
    echo "<br>";
   }
   if ($i==7) {
    $S2=substr($TESTSTATUS,32,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[33] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[33]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,33,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[34] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[34]</a> $TARGET<br>";
    }
    echo "<br>";
   }
   if ($i==11) {
    $S2=substr($TESTSTATUS,36,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[37] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[37]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,37,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[38] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[38]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==17) {
    $S2=substr($TESTSTATUS,24,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[25] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[25]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,25,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[26] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[26]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,26,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[3]</b> $TEST_STEPS[27] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[3]</b> <a href=\"admin_nictest_step$i.3.php\">$TEST_STEPS[27]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,28,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[4]</b> $TEST_STEPS[29] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[4]</b> <a href=\"admin_nictest_step$i.5.php\">$TEST_STEPS[29]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==19) {
    $S2=substr($TESTSTATUS,34,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[35] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[35]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,35,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[36] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[36]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==21) {
    $S2=substr($TESTSTATUS,38,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[39] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[39]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,39,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[40] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[40]</a> $TARGET<br>";
    }
    echo "<br>";
   }
   if ($i==24) {
    $S2=substr($TESTSTATUS,40,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS[41] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS[41]</a> $TARGET<br>";
    } 
    $S2=substr($TESTSTATUS,41,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS[42] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS[42]</a> $TARGET<br>";
    } 
    echo "<br>";
   }
  }
  echo " </td></tr></table></div><br>";
 }

 function print_nictest2_steps($STEP){
  global $TEST_STEPS, $TEST_STEPS2;
  get_epptestinfo($USER1,$USER2,$PASS1,$PASS2,$TESTSTATUS);

  if (($STEP>=1)&&($STEP<=42)){
   change_test_step($STEP,"0",$TESTSTATUS);
   update_teststatus($TESTSTATUS);
  }

  echo " 
   $TEST_STEPS2[43] <br><br>
   $TEST_STEPS2[44] <br><br>
  ";
  echo " <table width=99% cellpadding=2 cellspacing=2><tr><td valign=top><div align=left> ";
  for ($i=1; $i<=24; $i++) {
   $S=substr($TESTSTATUS,$i-1,1);
   if ($i==5) { echo "<br>"; }
   if ($i==10) { echo "<br>"; }
   if ($i==17) { echo "<br>"; }
   if ($i==19) { echo "<br>"; }
   if ($i==21) { echo "<br>"; }
   if ($i==24) { echo "<br>"; }
   if ($i==$STEP) $TARGET=" <== "; else $TARGET="";
 
   $SL=TRUE;
   if ($i==5) { $SL=FALSE; }
   if ($i==6) { $SL=FALSE; }
   if ($i==10) { $SL=FALSE; }
   if ($i==17) { $SL=FALSE; }
   if ($i==19) { $SL=FALSE; }
   if ($i==21) { $SL=FALSE; }
   if ($i==24) { $SL=FALSE; }
   if ($S=="0") { 
    if ($SL) echo " <b>[$i]</b> $TEST_STEPS2[$i] (Done!) $TARGET<br>";
   } else {
    if ($SL) echo " <b>[$i]</b> <a href=\"admin_nictest_step$i.php\">$TEST_STEPS2[$i]</a> $TARGET<br>";
   }

   if ($i==5) {
    $S2=substr($TESTSTATUS,29,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[30] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[30]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,30,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[31] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[31]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,31,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[3]</b> $TEST_STEPS2[32] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[3]</b> <a href=\"admin_nictest_step$i.3.php\">$TEST_STEPS2[32]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==6) {
    $S2=substr($TESTSTATUS,32,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[33] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[33]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,33,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[34] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[34]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==10) {
    $S2=substr($TESTSTATUS,36,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[37] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[37]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,37,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[38] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[38]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==17) {
    $S2=substr($TESTSTATUS,24,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[25] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[25]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,25,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[26] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[26]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,26,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[3]</b> $TEST_STEPS2[27] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[3]</b> <a href=\"admin_nictest_step$i.3.php\">$TEST_STEPS2[27]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,28,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[4]</b> $TEST_STEPS2[29] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[4]</b> <a href=\"admin_nictest_step$i.5.php\">$TEST_STEPS2[29]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==19) {
    $S2=substr($TESTSTATUS,34,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[35] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[35]</a> $TARGET<br>";
    }
    $S2=substr($TESTSTATUS,35,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[36] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[36]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==21) {
    $S2=substr($TESTSTATUS,39,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[40] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[40]</a> $TARGET<br>";
    }
    echo "<br>";
   }

   if ($i==24) {
    $S2=substr($TESTSTATUS,40,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[1]</b> $TEST_STEPS2[41] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[1]</b> <a href=\"admin_nictest_step$i.1.php\">$TEST_STEPS2[41]</a> $TARGET<br>";
    } 
    $S2=substr($TESTSTATUS,41,1);
    if ($S2=="0") { 
     echo " <b>[$i]</b>-<b>[2]</b> $TEST_STEPS2[42] (OK!) $TARGET<br>";
    } else {
     echo " <b>[$i]</b>-<b>[2]</b> <a href=\"admin_nictest_step$i.2.php\">$TEST_STEPS2[42]</a> $TARGET<br>";
    } 
    echo "<br>";
   }
  }
  echo " </td></tr></table></div><br>";
 }

 ########################################################################
 # Funzioni aggiunte 06/10/2009.
 ########################################################################

 function update_contact($idc,$name,$surname,$company,$address,$zipcode,$city,$province,$country,$nationality,$usertype,$cidtype,$fiscalcode,$vatcode,$tel,$fax,$email,$pub,$sex){
  if (!is_numeric($usertype)) $usertype=0;
  DBQuery("
   UPDATE domain_contacts SET
    status='Pending',
    name='$name',
    surname='$surname',
    company='$company',
    address='$address',
    zipcode='$zipcode',
    city='$city',
    province='$province',
    country='$country',
    nationality='$nationality',
    usertype='$usertype',
    cidtype='$cidtype',
    vatcode='$vatcode',
    fiscalcode='$fiscalcode',
    tel='$tel',
    fax='$fax',
    email='$email',
    pubblish='$pub',
    sex='$sex'
   WHERE idc=$idc
  ");
 }

 function create_contact($name,$surname,$company,$address,$zipcode,$city,$province,$country,$nationality,$usertype,$cidtype,$fiscalcode,$vatcode,$tel,$fax,$email,$pub,$sex){
  $IDA=id_active_user();
  if (!is_numeric($usertype)) $usertype=0;
  DBQuery("
   INSERT INTO domain_contacts 
   (
    contact_id, status, name, surname, company, address, zipcode, city, province, 
    country, nationality, usertype, cidtype, vatcode, fiscalcode, tel, fax, email,
    pubblish, sex, ida
   ) 
    VALUES
   (
    '', 'Pending', '$name', '$surname', '$company', '$address', '$zipcode', '$city', '$province',
    '$country', '$nationality', '$usertype', '$cidtype', '$vatcode', '$fiscalcode', '$tel', '$fax', '$email',
    '$pub', '$sex', '$IDA'
   )
  ");
  DBSelect("SELECT * FROM domain_contacts ORDER BY idc DESC LIMIT 0,1",$rs);
  if (NextRecord($rs,$r)) {
   $IDC=$r['idc'];
   $CID=create_extended_id($r['idc']);
  } else {
   $IDC=0;
   $CID=create_extended_id(0);
  }
  DBQuery("UPDATE domain_contacts SET contact_id='$CID' WHERE idc=$IDC");
  return $IDC;
 }

 function create_contact_admin($name,$surname,$company,$address,$zipcode,$city,$province,$country,$nationality,$usertype,$cidtype,$fiscalcode,$vatcode,$tel,$fax,$email,$pub,$sex){
  $IDA=id_active_user();
  if (!is_numeric($usertype)) $usertype=0;
  DBQuery("
   INSERT INTO domain_contacts 
   (
    contact_id, status, name, surname, company, address, zipcode, city, province, 
    country, nationality, usertype, cidtype, vatcode, fiscalcode, tel, fax, email,
    pubblish, sex, ida
   ) 
    VALUES
   (
    '', 'Pending', '$name', '$surname', '$company', '$address', '$zipcode', '$city', '$province',
    '$country', '$nationality', '$usertype', '$cidtype', '$vatcode', '$fiscalcode', '$tel', '$fax', '$email',
    '$pub', '$sex', '$IDA'
   )
  ");
  DBSelect("SELECT * FROM domain_contacts ORDER BY idc DESC LIMIT 0,1",$rs);
  if (NextRecord($rs,$r)) {
   $IDC=$r['idc'];
   $CID=create_extended_id_admin($r['idc']);
  } else {
   $IDC=0;
   $CID=create_extended_id_admin(0);
  }
  DBQuery("UPDATE domain_contacts SET contact_id='$CID' WHERE idc=$IDC");
  return $IDC;
 }

 function get_epptestinfo(&$USER1,&$USER2,&$PASS1,&$PASS2,&$TESTSTATUS){
  DBSelect("SELECT * FROM epp_test WHERE idtest=1",$rs);
  if (NextRecord($rs,$r)) {
   $USER1=$r['username1'];
   $USER2=$r['username2'];
   $PASS1=$r['password1'];
   $PASS2=$r['password2'];
   $TESTSTATUS=$r['status'];
   return TRUE;
  } else {
   $USER1="";
   $USER2="";
   $PASS1="";
   $PASS2="";
   $TESTSTATUS="";
   return FALSE;
  }
 }

 function get_defaultinfo(
  $IDADMIN,&$eppcredit,&$ns1,&$ns2,&$ns3,&$ns4,&$ns5,&$ns6,&$ip1,&$ip2,&$ip3,&$ip4,&$ip5,&$ip6,
   &$idreg,&$idadm,&$idtech,&$idbill,&$prefix,&$debug,&$exam
 ){
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   $eppcredit=$r['eppcredit'];
   $ns1=$r['ns1'];
   $ns2=$r['ns2'];
   $ns3=$r['ns3'];
   $ns4=$r['ns4'];
   $ns5=$r['ns5'];
   $ns6=$r['ns6'];
   $ip1=$r['ip1'];
   $ip2=$r['ip2'];
   $ip3=$r['ip3'];
   $ip4=$r['ip4'];
   $ip5=$r['ip5'];
   $ip6=$r['ip6'];
   $idreg=$r['idregistrant'];
   $idadm=$r['idadmin'];
   $idtech=$r['idtech'];
   $idbill=$r['idbill'];
   $prefix=$r['contactid_prefix'];
   $debug=$r['debug'];
   $exam=$r['exam'];
   return TRUE;
  } else {
   $eppcredit=0;
   $ns1="";
   $ns2="";
   $ns3="";
   $ns4="";
   $ns5="";
   $ns6="";
   $ip1="";
   $ip2="";
   $ip3="";
   $ip4="";
   $ip5="";
   $ip6="";
   $idreg=0;
   $idadm=0;
   $idtech=0;
   $idbill=0;
   $prefix="";
   $debug="";
   $exam="";
   return FALSE;
  }
 }

 function form_update_contact_tel($IDADMIN,$ID){
  global $LANGUAGE;
  $CID=$ID;
  get_contact_info_ext(
   $CID, $NAME, $SURNAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $VAT, $SEX
  );
  if ($PUB==1) $PUBBLISH="True"; else $PUBBLISH="False";
  echo "
   <form method=POST action=\"scripts/update_contact_tel_server.php?idadmin=$IDADMIN&id=$ID\">
    <table width=340>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%>$NAME</td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%>$SURNAME</td>
     <tr><td width=40%><b>$LANGUAGE[201]</b></td><td width=60%>$ORG</td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%><input type=text size=24 name=\"tel\" value=\"$TEL\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%><input type=text size=24 name=\"fax\" value=\"$FAX\"></td>
    </table>
    <input type=submit value=\" $LANGUAGE[219] \">
   </form>
  ";
 }

 function form_update_contact_privacy($IDADMIN,$ID){
  global $LANGUAGE;
  $CID=$ID;
  get_contact_info_ext(
   $CID, $NAME, $SURNAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $VAT, $SEX
  );
  if ($PUB==1) $PUBBLISH="True"; else $PUBBLISH="False";
  echo "
   <form method=POST action=\"scripts/update_contact_privacy_server.php?idadmin=$IDADMIN&id=$ID\">
    <table width=340>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%>$NAME</td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%>$SURNAME</td>
     <tr><td width=40%><b>$LANGUAGE[201]</b></td><td width=60%>$ORG</td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","$PUBBLISH")."</td>
    </table>
    <input type=submit value=\" $LANGUAGE[220] \">
   </form>
  ";
 }

 function form_update_contact_nofee($IDADMIN,$ID){
  global $LANGUAGE;
  $CID=$ID;
  get_contact_info_ext(
   $CID, $NAME, $SURNAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $VAT, $SEX
  );
  if ($PUB==1) $PUBBLISH="True"; else $PUBBLISH="False";
  echo "
   <form method=POST action=\"scripts/update_contact_full_server.php?idadmin=$IDADMIN&id=$ID\">
    <table width=340>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%> $NAME </td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%> $SURNAME </td>
     <tr><td width=40%><b>$LANGUAGE[201]</b></td><td width=60%> $ORG </td>
     <tr><td width=40%><b>$LANGUAGE[202]</b></td><td width=60%><input type=text size=24 name=\"address\" value=\"$ADDRESS\"></td>
     <tr><td width=40%><b>$LANGUAGE[203]</b></td><td width=60%><input type=text size=24 name=\"zipcode\" value=\"$ZIPCODE\"></td>
     <tr><td width=40%><b>$LANGUAGE[204]</b></td><td width=60%><input type=text size=24 name=\"city\" value=\"$CITY\"></td>
     <tr><td width=40%><b>$LANGUAGE[205]</b></td><td width=60%><input type=text size=2 name=\"province\" value=\"$STATE\"> <b>(Sigla Due Lettere)</b></td>
     <tr><td width=40%><b>$LANGUAGE[206]</b></td><td width=60%>".client_select_country($COUNTRY)."</td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%><input type=text size=24 name=\"tel\" value=\"$TEL\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%><input type=text size=24 name=\"fax\" value=\"$FAX\"></td>
     <tr><td width=40%><b>$LANGUAGE[215]</b></td><td width=60%><input type=text size=24 name=\"email\" value=\"$EMAIL\"></td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","$PUBBLISH")."</td>
    </table>
    <input type=submit value=\" $LANGUAGE[217] \">
   </form>
  ";
 }

 function form_update_contact($IDADMIN,$ID){
  global $LANGUAGE;
  $CID=$ID;
  $IDC=$ID;
  get_contact_info_ext(
   $CID, $NAME, $SURNAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $VAT, $SEX
  );
  if ($PUB==1) $PUBBLISH="True"; else $PUBBLISH="False";
  echo "
   <form method=POST action=\"scripts/update_contact.php?idadmin=$IDADMIN&id=$ID\">
    <table width=340>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%><input type=text size=24 name=\"name\" value=\"$NAME\"></td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%><input type=text size=24 name=\"surname\" value=\"$SURNAME\"></td>
     <tr><td width=40%>* <b>$LANGUAGE[201]</b></td><td width=60%><input type=text size=24 name=\"company\" value=\"$ORG\"></td>
     <tr><td width=40%><b>$LANGUAGE[202]</b></td><td width=60%><input type=text size=24 name=\"address\" value=\"$ADDRESS\"></td>
     <tr><td width=40%><b>$LANGUAGE[203]</b></td><td width=60%><input type=text size=24 name=\"zipcode\" value=\"$ZIPCODE\"></td>
     <tr><td width=40%><b>$LANGUAGE[204]</b></td><td width=60%><input type=text size=24 name=\"city\" value=\"$CITY\"></td>
     <tr><td width=40%><b>$LANGUAGE[205]</b></td><td width=60%><input type=text size=2 name=\"province\" value=\"$STATE\"> <b>(Sigla Due Lettere)</b></td>
     <tr><td width=40%><b>$LANGUAGE[206]</b></td><td width=60%>".client_select_country($COUNTRY)."</td>
     <tr><td width=40%><b>$LANGUAGE[207]</b></td><td width=60%>".client_select_nationality($NT)."</td>
     <tr><td width=40%><b>$LANGUAGE[208]</b></td><td width=60%>".client_select_contacttype($TYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[209]</b></td><td width=60%>".client_select_cid_type($CTYPE)."</td>
     <tr><td width=40%> ** <b>$LANGUAGE[211]</b></td><td width=60%><input type=text size=24 name=\"fiscalcode\" value=\"$CF\"></td>
     <tr><td width=40%> ** <b>$LANGUAGE[212]</b></td><td width=60%><input type=text size=24 name=\"vatcode\" value=\"$VAT\"></td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%><input type=text size=24 name=\"tel\" value=\"$TEL\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%><input type=text size=24 name=\"fax\" value=\"$FAX\"></td>
     <tr><td width=40%><b>$LANGUAGE[215]</b></td><td width=60%><input type=text size=24 name=\"email\" value=\"$EMAIL\"></td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","$PUBBLISH")."</td>
    </table>
    <table width=340 cellpadding=8><tr>
     <td width=100%><div align=left>
      <br> $LANGUAGE[210] <br><br>
     </div></td></tr>
    </table>
  ";
  if (is_edu_contact($IDC)) {
   get_edu_extcon_xml($IDC,$NT,$TYPE,$CF,$SCHOOLCODE);
   echo "
    <table width=340>
     <tr><td width=100%><b>Compila questa parte, solo se devi creare un Registrante per .EDU</b></td>
    </table>
    <table width=340>
     <tr><td width=40%><b>Codice Meccanografico Scuola Italiana</b></td><td width=60%><input type=text size=24 name=\"schoolcode\" value=\"$SCHOOLCODE\"></td>
     <tr><td width=40%><b>Codice Fiscale Scuola Italiana</b></td><td width=60%><input type=text size=24 name=\"schoolcf\" value=\"$CF\"></td>
     <tr><td width=40%><b>Tipo di Scuola Italiana</b></td><td width=60%>".select_schooltype($TYPE)."</td>
    </table>
   ";
  }
  echo "
    <input type=submit value=\" $LANGUAGE[217] \">
   </form>
  ";
 }

 function form_create_contact($IDADMIN){
  global $LANGUAGE;
  $COUNTRY="";
  $NT="";
  $TYPE="";
  $CTYPE="";
  $TELPREFIX="";
  $FAXPREFIX="";
  $SCHCOOL_TYPE="";
  echo "
   <form method=POST action=\"scripts/create_contact.php?idadmin=$IDADMIN\">
    <table width=340>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%><input type=text size=24 name=\"name\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%><input type=text size=24 name=\"surname\" value=\"\"></td>
     <tr><td width=40%>(*)<b>$LANGUAGE[201]</b></td><td width=60%><input type=text size=24 name=\"company\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[202]</b></td><td width=60%><input type=text size=24 name=\"address\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[203]</b></td><td width=60%><input type=text size=24 name=\"zipcode\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[204]</b></td><td width=60%><input type=text size=24 name=\"city\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[205]</b></td><td width=60%><input type=text size=2 name=\"province\" value=\"\"> <b>(Sigla Due Lettere)</b></td>
     <tr><td width=40%><b>$LANGUAGE[206]</b></td><td width=60%>".client_select_country($COUNTRY)."</td>
     <tr><td width=40%><b>$LANGUAGE[207]</b></td><td width=60%>".client_select_nationality($NT)."</td>
     <tr><td width=40%><b>$LANGUAGE[208]</b></td><td width=60%>".client_select_contacttype($TYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[209]</b></td><td width=60%>".client_select_cid_type($CTYPE)."</td>
     <tr><td width=40%>(**)<b>$LANGUAGE[211]</b></td><td width=60%><input type=text size=24 name=\"fiscalcode\" value=\"\"></td>
     <tr><td width=40%>(**)<b>$LANGUAGE[212]</b></td><td width=60%><input type=text size=24 name=\"vatcode\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%> ".client_select_telprefix($TELPREFIX)." <input type=text size=14 name=\"tel\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%> ".client_select_faxprefix($FAXPREFIX)." <input type=text size=14 name=\"fax\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[215]</b></td><td width=60%><input type=text size=24 name=\"email\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","")."</td>
    </table>

    <table width=340 cellpadding=8><tr>
     <td width=100%><div align=left>
      <br> $LANGUAGE[210] <br><br>
     </div></td></tr>
    </table>

    <table width=340>
     <tr><td width=100%><b>Compila questa parte, solo se devi creare un Registrante per .EDU</b></td>
    </table>
    <table width=340>
     <tr><td width=40%><b>Codice Meccanografico Scuola Italiana</b></td><td width=60%><input type=text size=24 name=\"schoolcode\" value=\"\"></td>
     <tr><td width=40%><b>Codice Fiscale Scuola Italiana</b></td><td width=60%><input type=text size=24 name=\"schoolcf\" value=\"\"></td>
     <tr><td width=40%><b>Tipo di Scuola Italiana</b></td><td width=60%>".select_schooltype($SCHCOOL_TYPE)."</td>
    </table>

    <input type=submit value=\" $LANGUAGE[218] \">
   </form>
  ";
 }

 function form_update_contact_full($IDADMIN,$ID){
  global $LANGUAGE;
  
  $COUNTRY="";
  $NT="";
  $TYPE="";
  $CTYPE="";
  $TELPREFIX="";
  $FAXPREFIX="";
  $SCHCOOL_TYPE="";
  
  $CID=$ID;
  get_contact_info_ext(
   $CID, $NAME, $SURNAME, $ORG, $ADDRESS, $CITY, $STATE, $ZIPCODE, $COUNTRY, $TEL, $FAX, $EMAIL, $PUB, $NT, $TYPE, $CTYPE, $CF, $VAT, $SEX
  );
  if ($PUB==1) $PUBBLISH="True"; else $PUBBLISH="False";
  echo "
   <form method=POST action=\"scripts/update_contact.php?idadmin=$IDADMIN&id=$ID\">
    <table width=320>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%><input type=text size=16 name=\"name\" value=\"$NAME\"></td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%><input type=text size=16 name=\"surname\" value=\"$SURNAME\"></td>
     <tr><td width=40%><b>$LANGUAGE[200]</b></td><td width=60%>".client_select_sex($SEX)."</td>
     <tr><td width=40%><b>$LANGUAGE[201]</b></td><td width=60%><input type=text size=16 name=\"company\" value=\"$ORG\"></td>
     <tr><td width=40%><b>$LANGUAGE[202]</b></td><td width=60%><input type=text size=16 name=\"address\" value=\"$ADDRESS\"></td>
     <tr><td width=40%><b>$LANGUAGE[203]</b></td><td width=60%><input type=text size=16 name=\"zipcode\" value=\"$ZIPCODE\"></td>
     <tr><td width=40%><b>$LANGUAGE[204]</b></td><td width=60%><input type=text size=16 name=\"city\" value=\"$CITY\"></td>
     <tr><td width=40%><b>$LANGUAGE[205]</b></td><td width=60%><input type=text size=16 name=\"province\" value=\"$STATE\"></td>
     <tr><td width=40%><b>$LANGUAGE[206]</b></td><td width=60%>".client_select_country($COUNTRY)."</td>
     <tr><td width=40%><b>$LANGUAGE[207]</b></td><td width=60%>".client_select_nationality($NT)."</td>
     <tr><td width=40%><b>$LANGUAGE[208]</b></td><td width=60%>".client_select_contacttype($TYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[209]</b></td><td width=60%>".client_select_cid_type($CTYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[211]</b></td><td width=60%><input type=text size=16 name=\"fiscalcode\" value=\"$CF\"></td>
     <tr><td width=40%><b>$LANGUAGE[212]</b></td><td width=60%><input type=text size=16 name=\"vatcode\" value=\"$VAT\"></td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%><input type=text size=16 name=\"tel\" value=\"$TEL\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%><input type=text size=16 name=\"fax\" value=\"$FAX\"></td>
     <tr><td width=40%><b>$LANGUAGE[215]</b></td><td width=60%><input type=text size=16 name=\"email\" value=\"$EMAIL\"></td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","$PUBBLISH")."</td>
    </table>

    <input type=submit value=\"$LANGUAGE[217]\">
   </form>
  ";
 }

 function form_create_contact_full($IDADMIN){
  global $LANGUAGE;
  
  $COUNTRY="";
  $NT="";
  $TYPE="";
  $CTYPE="";
  $TELPREFIX="";
  $FAXPREFIX="";
  $SCHCOOL_TYPE="";

  echo "
   <form method=POST action=\"scripts/create_contact.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=40%><b>$LANGUAGE[198]</b></td><td width=60%><input type=text size=20 name=\"name\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[199]</b></td><td width=60%><input type=text size=20 name=\"surname\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[200]</b></td><td width=60%>".client_select_sex($SEX)."</td>
     <tr><td width=40%><b>$LANGUAGE[201]</b></td><td width=60%><input type=text size=20 name=\"company\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[202]</b></td><td width=60%><input type=text size=20 name=\"address\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[203]</b></td><td width=60%><input type=text size=20 name=\"zipcode\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[204]</b></td><td width=60%><input type=text size=20 name=\"city\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[205]</b></td><td width=60%><input type=text size=20 name=\"province\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[206]</b></td><td width=60%>".client_select_country($COUNTRY)."</td>
     <tr><td width=40%><b>$LANGUAGE[207]</b></td><td width=60%>".client_select_nationality($NT)."</td>
     <tr><td width=40%><b>$LANGUAGE[208]</b></td><td width=60%>".client_select_contacttype($TYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[209]</b></td><td width=60%>".client_select_cid_type($CTYPE)."</td>
     <tr><td width=40%><b>$LANGUAGE[211]</b></td><td width=60%><input type=text size=20 name=\"fiscalcode\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[212]</b></td><td width=60%><input type=text size=20 name=\"vatcode\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[213]</b></td><td width=60%> ".client_select_telprefix($TELPREFIX)." <input type=text size=12 name=\"tel\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[214]</b></td><td width=60%> ".client_select_faxprefix($FAXPREFIX)." <input type=text size=12 name=\"fax\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[215]</b></td><td width=60%><input type=text size=20 name=\"email\" value=\"\"></td>
     <tr><td width=40%><b>$LANGUAGE[216]</b></td><td width=60%>".select_option("pubblish","")."</td>
    </table>
    <input type=submit value=\"$LANGUAGE[197]\">
   </form>
  ";
 }

 function form_create_naked_xml($IDADMIN){
  global $LANGUAGE;
  echo "
   <form method=POST action=\"scripts/naked_xml.php?idadmin=$IDADMIN\">
    <table width=80%>
     <tr><td width=98%>
  ";
  $xml=""; 
  print_xml_textarea($xml,"xml",80,12);  
  echo "
     </td>
    </table>
    <br> 
    <input type=submit value=\"$LANGUAGE[196]\">
   </form>
  ";
 }

 function form_create_domain($IDADMIN,$IDC){
  global $LANGUAGE,$USE_DEFAULT_ADMREG;
  $IDDS=get_servers_idds();
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  if ((!$USE_DEFAULT_ADMREG)||($IDC>0)){
   if ($IDC>0) {
    $idreg=get_idregistrant($IDC);
    $idadm=$idreg;
   } else {
    $idreg="";
    $idadm="";
   }
  }
  echo "
   <form method=POST action=\"scripts/create_domain.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[193]</b></td><td width=50%><input type=text size=16 name=\"name\" value=\"\"></td>
     <tr><td width=50%><b>$LANGUAGE[192]</b></td><td width=50%><input type=text size=16 name=\"idreg\" value=\"$idreg\"></td>
     <tr><td width=50%><b>$LANGUAGE[191]</b></td><td width=50%><input type=text size=16 name=\"idadmin\" value=\"$idadm\"></td>
     <tr><td width=50%><b>$LANGUAGE[190]</b></td><td width=50%><input type=text size=16 name=\"idtech\" value=\"$idtech\"></td>
     <tr><td width=50%><b>$LANGUAGE[189]</b></td><td width=50%><input type=text size=16 name=\"idbill\" value=\"$idbill\"></td>
    </table>
    <br>
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[187]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$ns1\"></td>
     <tr><td width=50%><b>$LANGUAGE[185]</b></td><td width=50%><input type=text size=16 name=\"ip1\" value=\"$ip1\"></td>
     <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$ns2\"></td>
     <tr><td width=50%><b>$LANGUAGE[184]</b></td><td width=50%><input type=text size=16 name=\"ip2\" value=\"$ip2\"></td>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$ns3\"></td>
     <tr><td width=50%><b>$LANGUAGE[536]</b></td><td width=50%><input type=text size=16 name=\"ip3\" value=\"$ip3\"></td>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$ns4\"></td>
     <tr><td width=50%><b>$LANGUAGE[538]</b></td><td width=50%><input type=text size=16 name=\"ip4\" value=\"$ip4\"></td>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[540]</b></td><td width=50%><input type=text size=16 name=\"ip5\" value=\"$ip5\"></td>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[564]</b></td><td width=50%><input type=text size=16 name=\"ip6\" value=\"$ip6\"></td>
    </table>
    <table width=320><tr><td width=100%>
     <br>
     $LANGUAGE[183] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
    <br> 
    <input type=submit value=\"$LANGUAGE[195]\">
   </form>
  ";
 }

 function form_update_domain($IDADMIN,$IDD){
  global $LANGUAGE;
  $IDDS=get_servers_idds();
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  echo "
   <form method=POST action=\"scripts/update_domain.php?idadmin=$IDADMIN&idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[193]</b></td><td width=50%><input type=text size=16 name=\"name\" value=\"$DOMAIN\"></td>
     <tr><td width=50%><b>$LANGUAGE[192]</b></td><td width=50%><input type=text size=16 name=\"idreg\" value=\"$IDREG\"></td>
     <tr><td width=50%><b>$LANGUAGE[191]</b></td><td width=50%><input type=text size=16 name=\"idadmin\" value=\"$IDADM\"></td>
     <tr><td width=50%><b>$LANGUAGE[190]</b></td><td width=50%><input type=text size=16 name=\"idtech\" value=\"$IDTECH\"></td>
     <tr><td width=50%><b>$LANGUAGE[189]</b></td><td width=50%><input type=text size=16 name=\"idbill\" value=\"$IDBILL\"></td>
    </table>
    <br>
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[187]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$NS1\"></td>
     <tr><td width=50%><b>$LANGUAGE[185]</b></td><td width=50%><input type=text size=16 name=\"ip1\" value=\"$IP1\"></td>
     <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$NS2\"></td>
     <tr><td width=50%><b>$LANGUAGE[184]</b></td><td width=50%><input type=text size=16 name=\"ip2\" value=\"$IP2\"></td>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$NS3\"></td>
     <tr><td width=50%><b>$LANGUAGE[536]</b></td><td width=50%><input type=text size=16 name=\"ip3\" value=\"$IP3\"></td>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$NS4\"></td>
     <tr><td width=50%><b>$LANGUAGE[538]</b></td><td width=50%><input type=text size=16 name=\"ip4\" value=\"$IP4\"></td>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$NS5\"></td>
     <tr><td width=50%><b>$LANGUAGE[540]</b></td><td width=50%><input type=text size=16 name=\"ip5\" value=\"$IP5\"></td>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[564]</b></td><td width=50%><input type=text size=16 name=\"ip6\" value=\"$ip6\"></td>
    </table>
    <table width=320><tr><td width=100%>
     <br>
     $LANGUAGE[183] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
    <br> 
    <input type=submit value=\"$LANGUAGE[194]\">
   </form>
  ";
 }

 function form_update_domain_idn($IDADMIN,$IDD){
  global $LANGUAGE;
  $IDDS=get_servers_idds();
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  get_domain_info($IDD, $DOMAIN, $EPPCODE, $IDREG, $IDADM, $IDTECH, $IDBILL);
  get_domain_dnsinfo($IDD, $NS1, $NS2, $NS3, $NS4, $NS5, $NS6, $IP1, $IP2, $IP3, $IP4, $IP5, $IP6);
  echo "
   <form method=POST action=\"scripts/update_domain_idn.php?idadmin=$IDADMIN&idd=$IDD\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[193]</b></td><td width=50%><input type=text size=16 name=\"name\" value=\"$DOMAIN\"></td>
     <tr><td width=50%><b>$LANGUAGE[192]</b></td><td width=50%><input type=text size=16 name=\"idreg\" value=\"$IDREG\"></td>
     <tr><td width=50%><b>$LANGUAGE[191]</b></td><td width=50%><input type=text size=16 name=\"idadmin\" value=\"$IDADM\"></td>
     <tr><td width=50%><b>$LANGUAGE[190]</b></td><td width=50%><input type=text size=16 name=\"idtech\" value=\"$IDTECH\"></td>
     <tr><td width=50%><b>$LANGUAGE[189]</b></td><td width=50%><input type=text size=16 name=\"idbill\" value=\"$IDBILL\"></td>
    </table>
    <br>
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[187]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$NS1\"></td>
     <tr><td width=50%><b>$LANGUAGE[185]</b></td><td width=50%><input type=text size=16 name=\"ip1\" value=\"$IP1\"></td>
     <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$NS2\"></td>
     <tr><td width=50%><b>$LANGUAGE[184]</b></td><td width=50%><input type=text size=16 name=\"ip2\" value=\"$IP2\"></td>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$NS3\"></td>
     <tr><td width=50%><b>$LANGUAGE[536]</b></td><td width=50%><input type=text size=16 name=\"ip3\" value=\"$IP3\"></td>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$NS4\"></td>
     <tr><td width=50%><b>$LANGUAGE[538]</b></td><td width=50%><input type=text size=16 name=\"ip4\" value=\"$IP4\"></td>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$NS5\"></td>
     <tr><td width=50%><b>$LANGUAGE[540]</b></td><td width=50%><input type=text size=16 name=\"ip5\" value=\"$IP5\"></td>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[564]</b></td><td width=50%><input type=text size=16 name=\"ip6\" value=\"$ip6\"></td>
    </table>
    <table width=320><tr><td width=100%>
     <br>
     $LANGUAGE[183] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
    <br> 
    <input type=submit value=\"$LANGUAGE[194]\">
   </form>
  ";
 }

 function form_transfert_domain($IDADMIN){
  global $LANGUAGE;
  $IDDS=get_servers_idds();
  $eppcode="";
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  echo "
   <form method=POST action=\"scripts/transfert_domain.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[193]</b></td><td width=50%><input type=text size=16 name=\"name\" value=\"\"></td>
     <tr><td width=50%><b>$LANGUAGE[192]</b></td><td width=50%><input type=text size=16 name=\"idreg\" value=\"\"></td>
     <tr><td width=50%><b>$LANGUAGE[191]</b></td><td width=50%><input type=text size=16 name=\"idadmin\" value=\"\"></td>
     <tr><td width=50%><b>$LANGUAGE[190]</b></td><td width=50%><input type=text size=16 name=\"idtech\" value=\"$idtech\"></td>
     <tr><td width=50%><b>$LANGUAGE[189]</b></td><td width=50%><input type=text size=16 name=\"idbill\" value=\"$idbill\"></td>
     <tr><td width=50%><b>$LANGUAGE[188]</b></td><td width=50%><input type=text size=16 name=\"eppcode\" value=\"$eppcode\"></td>
    </table>
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[187]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$ns1\"></td>
     <tr><td width=50%><b>$LANGUAGE[186]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$ns2\"></td>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$ns3\"></td>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$ns4\"></td>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$ns6\"></td>
    </table>
    <table width=320><tr><td width=100%>
     <br> $LANGUAGE[183] <br><br>
     ".client_select_dns_server($IDDS)."
     <br><br>
    </td></tr></table>
  ";
  form_select_forcensupd_transfert();
  form_select_contract_transfert();
  echo " 
    <input type=submit value=\"$LANGUAGE[182]\">
   </form>
  ";
 }

 function form_default_config($IDADMIN){
  global $LANGUAGE;
  get_defaultinfo($IDADMIN,$eppcredit,$ns1,$ns2,$ns3,$ns4,$ns5,$ns6,$ip1,$ip2,$ip3,$ip4,$ip5,$ip6,$idreg,$idadm,$idtech,$idbill,$prefix,$debug,$exam);
  echo "
   $LANGUAGE[181] <b>$eppcredit</b><br><br>
   <form method=POST action=\"scripts/update_config.php?idadmin=$IDADMIN\">
    <table width=320>
     <tr><td width=50%><b>$LANGUAGE[180]</b></td><td width=50%><input type=text size=16 name=\"ns1\" value=\"$ns1\"></td>
     <tr><td width=50%><b>$LANGUAGE[179]</b></td><td width=50%><input type=text size=16 name=\"ip1\" value=\"$ip1\"></td>
     <tr><td width=50%><b>$LANGUAGE[178]</b></td><td width=50%><input type=text size=16 name=\"ns2\" value=\"$ns2\"></td>
     <tr><td width=50%><b>$LANGUAGE[177]</b></td><td width=50%><input type=text size=16 name=\"ip2\" value=\"$ip2\"></td>
     <tr><td width=50%><b>$LANGUAGE[535]</b></td><td width=50%><input type=text size=16 name=\"ns3\" value=\"$ns3\"></td>
     <tr><td width=50%><b>$LANGUAGE[536]</b></td><td width=50%><input type=text size=16 name=\"ip3\" value=\"$ip3\"></td>
     <tr><td width=50%><b>$LANGUAGE[537]</b></td><td width=50%><input type=text size=16 name=\"ns4\" value=\"$ns4\"></td>
     <tr><td width=50%><b>$LANGUAGE[538]</b></td><td width=50%><input type=text size=16 name=\"ip4\" value=\"$ip4\"></td>
     <tr><td width=50%><b>$LANGUAGE[539]</b></td><td width=50%><input type=text size=16 name=\"ns5\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[540]</b></td><td width=50%><input type=text size=16 name=\"ip5\" value=\"$ip5\"></td>
     <tr><td width=50%><b>$LANGUAGE[571]</b></td><td width=50%><input type=text size=16 name=\"ns6\" value=\"$ns5\"></td>
     <tr><td width=50%><b>$LANGUAGE[564]</b></td><td width=50%><input type=text size=16 name=\"ip6\" value=\"$ip5\"></td>
     <tr><td width=50%><b>$LANGUAGE[176]</b></td><td width=50%><input type=text size=16 name=\"prefix\" value=\"$prefix\"></td>
     <tr><td width=50%><br><br></td><td width=50%><br><br></td>
     <tr><td width=50%><b>$LANGUAGE[175]</b></td><td width=50%>".select_option("debug",$debug)."</td>
     <tr><td width=50%><b>$LANGUAGE[174]</b></td><td width=50%>".select_option("exam",$exam)."</td>
     <tr><td width=50%><br><br></td><td width=50%><br><br></td>
     <tr><td width=50%><b>$LANGUAGE[173]</b></td><td width=50%><input type=text size=16 name=\"idreg\" value=\"$idreg\"></td>
     <tr><td width=50%><b>$LANGUAGE[172]</b></td><td width=50%><input type=text size=16 name=\"idadmin\" value=\"$idadm\"></td>
     <tr><td width=50%><b>$LANGUAGE[171]</b></td><td width=50%><input type=text size=16 name=\"idtech\" value=\"$idtech\"></td>
     <tr><td width=50%><b>$LANGUAGE[170]</b></td><td width=50%><input type=text size=16 name=\"idbill\" value=\"$idbill\"></td>
    </table>
    <input type=submit value=\"$LANGUAGE[169]\">
   </form>
  ";
 }

 function create_extended_id_admin($IDC){
  $IDADMIN_FORCED=1;
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN_FORCED",$rs);
  if (NextRecord($rs,$r)) {
   $PREFIX=$r['contactid_prefix'];
  } else {
   $PREFIX="";
  }
  DBSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   $POSTFIX=$r['cidtype'];
  } else $POSTFIX="";
  $CID=create_contactID($PREFIX,$IDC,$POSTFIX);
  return $CID;
 } 

 function create_extended_id($IDC){
  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   $PREFIX=$r['contactid_prefix'];
  } else {
   $PREFIX="";
  }
  DBSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   $POSTFIX=$r['cidtype'];
  } else $POSTFIX="";
  $CID=create_contactID($PREFIX,$IDC,$POSTFIX);
  return $CID;
 } 

 function get_extended_id($IDC){
  DBSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   $CID=$r['contact_id'];
  } else {
   $CID="";
  }
  return $CID;
 }

 function count_total_contacts(){
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_contacts $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_contact_list($PAG){
  global $LANGUAGE;

  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_contacts();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_utenti.php?bar=true");

  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   $PREFIX=$r['contactid_prefix'];
  } else {
   $PREFIX="";
  }
  DBSelect("SELECT * FROM domain_contacts $AND_IDA ORDER BY idc DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=12%><b>$LANGUAGE[168]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[167]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[166]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[165]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[164]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[163]</b></td>
     <td class=lightgrey width=4%><b>$LANGUAGE[162]</b></td>
     <td class=lightgrey width=4%><b>$LANGUAGE[161]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[160]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   if ($C%2==0) $cl="lightwhite1";
    else $cl="lightwhite2";
   $IDC=$r['idc'];
   $NAME=stripslashes($r['name']);
   $SURNAME=stripslashes($r['surname']);
   $COMPANY=stripslashes($r['company']);
   $ADDRESS=stripslashes($r['address']);
   $ZIPCODE=stripslashes($r['zipcode']);
   $CITY=stripslashes($r['city']);
   $PROVINCE=stripslashes($r['province']);
   $COUNTRY=stripslashes($r['country']);
   $NT=stripslashes($r['nationality']);
   if ($COMPANY!="") $COMPANY_STR="<br>( $COMPANY )";
    else $COMPANY_STR="";
   $STATUS=$r['status'];
   $CID=$r['contact_id'];
   $TEL=$r['tel'];
   $FAX=$r['fax'];

   $CONTROL_LINKS="";
   $CONTROL_LINKS.=" [ <a href=\"scripts/delete_contact.php?id=$IDC\">$LANGUAGE[121]</a> ] ";
   if ($STATUS=="Pending") {
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact.php?id=$IDC\">$LANGUAGE[150]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"scripts/create_server_contact.php?id=$IDC\">$LANGUAGE[158]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"scripts/create_server_admincontact.php?id=$IDC\">$LANGUAGE[159]</a> ] ";
   }
   if ($STATUS=="Active") {
    $CONTROL_LINKS.=" [ <a href=\"admin_info_contact.php?id=$IDC\">$LANGUAGE[140]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_tel.php?id=$IDC\">$LANGUAGE[157]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_full.php?id=$IDC\">$LANGUAGE[143]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_privacy.php?id=$IDC\">$LANGUAGE[156]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_domini_crea.php?idc=$IDC\">$LANGUAGE[553]</a> ] ";
   }
   if ($STATUS=="AdminActive") {
    $CONTROL_LINKS.=" [ <a href=\"admin_info_contact.php?id=$IDC\">$LANGUAGE[140]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_tel.php?id=$IDC\">$LANGUAGE[157]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_full.php?id=$IDC\">$LANGUAGE[143]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_privacy.php?id=$IDC\">$LANGUAGE[156]</a> ] ";
   }
   if ($STATUS=="Errors") {
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact.php?id=$IDC\">$LANGUAGE[150]</a> ] ";
   }
   $CONTACTID_LINKS=" [ <a href=\"admin_utenti_update_contactid.php?id=$IDC\">$LANGUAGE[142]</a> ] ";
   $CONTACTID_LINKS.=" [ <a href=\"admin_controllo_contactid.php?contactid=$CID\">$LANGUAGE[149]</a> ] ";
   echo "
    <tr>
     <td class=$cl width=16%>$CID <br> $CONTACTID_LINKS</td>
     <td class=$cl width=18%>$NAME $SURNAME $COMPANY_STR <br> $CONTROL_LINKS</td>
     <td class=$cl width=10%>$STATUS</td>
     <td class=$cl width=18%>$ADDRESS</td>
     <td class=$cl width=8%>$ZIPCODE</td>
     <td class=$cl width=10%>$CITY</td>
     <td class=$cl width=4%>$PROVINCE</td>
     <td class=$cl width=4%>$COUNTRY <br> $NT</td>
     <td class=$cl width=12%>$TEL <br> $FAX</td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_utenti.php?bar=true");
  echo "$LANGUAGE[2]";
 }

 function count_total_contacts_search($KEY){
  $WHERE="
   (contact_id LIKE '%$KEY%') OR (name LIKE '%$KEY%') OR (surname LIKE '%$KEY%')
    OR (company LIKE '%$KEY%') OR (address LIKE '%$KEY%') OR (city LIKE '%$KEY%')
  ";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_contacts WHERE $WHERE",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_contact_list_search($KEY,$PAG){
  global $LANGUAGE;
  $WHERE="
   (contact_id LIKE '%$KEY%') OR (name LIKE '%$KEY%') OR (surname LIKE '%$KEY%')
    OR (company LIKE '%$KEY%') OR (address LIKE '%$KEY%') OR (city LIKE '%$KEY%')
  ";
  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_contacts_search($KEY);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_contacts_search.php?bar=true");

  $IDADMIN=id_active_user();
  DBSelect("SELECT * FROM admin_eppconfig WHERE ida=$IDADMIN",$rs);
  if (NextRecord($rs,$r)) {
   $PREFIX=$r['contactid_prefix'];
  } else {
   $PREFIX="";
  }
  DBSelect("SELECT * FROM domain_contacts WHERE $WHERE ORDER BY idc DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=12%><b>$LANGUAGE[168]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[167]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[166]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[165]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[164]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[163]</b></td>
     <td class=lightgrey width=4%><b>$LANGUAGE[162]</b></td>
     <td class=lightgrey width=4%><b>$LANGUAGE[161]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[160]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   if ($C%2==0) $cl="lightwhite1";
    else $cl="lightwhite2";
   $IDC=$r['idc'];
   $NAME=$r['name'];
   $SURNAME=$r['surname'];
   $COMPANY=$r['company'];
   $ADDRESS=$r['address'];
   $ZIPCODE=$r['zipcode'];
   $CITY=$r['city'];
   $PROVINCE=$r['province'];
   $COUNTRY=$r['country'];
   $NT=$r['nationality'];
   if ($COMPANY!="") $COMPANY_STR="<br>( $COMPANY )";
    else $COMPANY_STR="";
   $STATUS=$r['status'];
   $CID=$r['contact_id'];
   $TEL=$r['tel'];
   $FAX=$r['fax'];

   $CONTROL_LINKS="";
   $CONTROL_LINKS.=" [ <a href=\"scripts/delete_contact.php?id=$IDC\">$LANGUAGE[121]</a> ] ";
   if ($STATUS=="Pending") {
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact.php?id=$IDC\">$LANGUAGE[150]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"scripts/create_server_contact.php?id=$IDC\">$LANGUAGE[158]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"scripts/create_server_admincontact.php?id=$IDC\">$LANGUAGE[159]</a> ] ";
   }
   if ($STATUS=="Active") {
    $CONTROL_LINKS.=" [ <a href=\"admin_info_contact.php?id=$IDC\">$LANGUAGE[140]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_tel.php?id=$IDC\">$LANGUAGE[157]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_full.php?id=$IDC\">$LANGUAGE[143]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_privacy.php?id=$IDC\">$LANGUAGE[156]</a> ] ";
   }
   if ($STATUS=="AdminActive") {
    $CONTROL_LINKS.=" [ <a href=\"admin_info_contact.php?id=$IDC\">$LANGUAGE[140]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_tel.php?id=$IDC\">$LANGUAGE[157]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_full.php?id=$IDC\">$LANGUAGE[143]</a> ] ";
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact_privacy.php?id=$IDC\">$LANGUAGE[156]</a> ] ";
   }
   if ($STATUS=="Errors") {
    $CONTROL_LINKS.=" [ <a href=\"admin_modifica_contact.php?id=$IDC\">$LANGUAGE[150]</a> ] ";
   }
   $CONTACTID_LINKS=" [ <a href=\"admin_controllo_contactid.php?contactid=$CID\">$LANGUAGE[149]</a> ] ";
   echo "
    <tr>
     <td class=$cl width=16%>$CID <br> $CONTACTID_LINKS</td>
     <td class=$cl width=18%>$NAME $SURNAME $COMPANY_STR <br> $CONTROL_LINKS</td>
     <td class=$cl width=10%>$STATUS</td>
     <td class=$cl width=18%>$ADDRESS</td>
     <td class=$cl width=8%>$ZIPCODE</td>
     <td class=$cl width=10%>$CITY</td>
     <td class=$cl width=4%>$PROVINCE</td>
     <td class=$cl width=4%>$COUNTRY <br> $NT</td>
     <td class=$cl width=12%>$TEL <br> $FAX</td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_contacts_search.php?bar=true");
  echo "$LANGUAGE[2]";
 }

 function count_total_domains_expiring(){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";
  $today=time()+1296000; 
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names WHERE (expire<$today) AND (status=1) $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 #####

 function webpanel_domain_list_expiring_authcodes($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()+1296000; 
  $N=250;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_expiring();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;
  DBSelect("SELECT * FROM domain_names WHERE (expire<$today) AND (status=1) $AND_IDA ORDER BY expire ASC LIMIT $START,$N",$rs);
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $N=$r['name'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   echo "$N $EPPCOD<br>";
  }
  crea_navigator($PAG,$TOTPAG,8,"admin_domini_expiring.php?bar=true");
 }

 function webpanel_domain_list_expiring($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()+1296000; 

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_expiring();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_domini_expiring.php?bar=true");
  DBSelect("SELECT * FROM domain_names WHERE (expire<$today) AND (status=1) $AND_IDA ORDER BY expire DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";
 
   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update_idn.php?idd=$IDD\">$LANGUAGE[122]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/renew_domain.php?idd=$IDD&pag=$PAG\">$LANGUAGE[147]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_domini_expiring.php?bar=true");
  echo "$LANGUAGE[1]";
 }

 function webpanel_domain_list_expiring_autorenew_lastday($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $today=time()-1296000+86400; 
  $today_start=time()-1296000;

  DBSelect("SELECT * FROM domain_names WHERE ((expire>=$today_start) AND (expire<$today)) AND (status=1) $AND_IDA ORDER BY expire DESC",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update_idn.php?idd=$IDD\">$LANGUAGE[122]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/renew_domain.php?idd=$IDD&pag=$PAG\">$LANGUAGE[147]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  echo "$LANGUAGE[1]";
 }


 function count_total_domains_bystatus($STATUS){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names WHERE (status=$STATUS) $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_domain_list_bystatus($PAG,$STATUS){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_bystatus($STATUS);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  if ($STATUS==5) $PAGE_URL="admin_domini_cancellati.php";
   else if ($STATUS==0) $PAGE_URL="admin_domini_attivazioni.php";
   else if ($STATUS==2) $PAGE_URL="admin_domini_trasferimenti.php";
    else $PAGE_URL="admin_domini_status.php";

  crea_navigator($PAG,$TOTPAG,8,"$PAGE_URL?bar=true");
  DBSelect("SELECT * FROM domain_names WHERE (status=$STATUS) $AND_IDA ORDER BY name DESC LIMIT $START,$N",$rs);

  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"$PAGE_URL?bar=true");
  echo "$LANGUAGE[1]";
 }

 function count_total_domains(){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_domain_list($PAG){
  global $epp_professional, $LANGUAGE, $ALL_ADMINS_AS_SUPERADMIN;
  $ID_ADMIN=admin_protection();

  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ( (isset($ALL_ADMINS_AS_SUPERADMIN)) && ($ALL_ADMINS_AS_SUPERADMIN) ) $AND_IDA="";

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  DBSelect("SELECT * FROM domain_names $AND_IDA ORDER BY idd DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   $UPD_OPTIONS1="";
   $UPD_OPTIONS2="";
   $UPD_OPTIONS3="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_domini_del_expire.php?idd=$IDD\">$LANGUAGE[625]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   if ($STATUS=="13") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_mnt.php?id=$IDD\">$LANGUAGE[145]</a>] ";
   }
   if ($STATUS=="14") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_reg.php?id=$IDD\">$LANGUAGE[144]</a>] ";
   }
   if ($STATUS=="1000") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }
   if ($STATUS=="1001") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/autorenew.php?id=$IDD\">$LANGUAGE[635]</a>] ";
   }

   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_contacts.php?idd=$IDD\">$LANGUAGE[572]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_childdns.php?idd=$IDD\">$LANGUAGE[573]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  echo "$LANGUAGE[1]";
 }

 function count_total_domains_ranged($T1, $T2, $IDREG){
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ($AND_IDA=="") $AND_IDA="WHERE (created>=$T1) AND (created<=$T2) AND (idregistrant='$IDREG')"; else $AND_IDA.=" AND (created>=$T1) AND (created<=$T2) AND (idregistrant='$IDREG')";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_domain_list_ranged($PAG, $T1, $T2, $IDREG){
  global $epp_professional,$LANGUAGE;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ($AND_IDA=="") $AND_IDA="WHERE (created>=$T1) AND (created<=$T2) AND (idregistrant='$IDREG')"; else $AND_IDA.=" AND (created>=$T1) AND (created<=$T2) AND (idregistrant='$IDREG')";

  $N=2500;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_ranged($T1, $T2, $IDREG);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  echo "<br><b>$TOT</b> domini<br>";
  crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  DBSelect("SELECT * FROM domain_names $AND_IDA ORDER BY created DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   if ($STATUS=="13") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_mnt.php?id=$IDD\">$LANGUAGE[145]</a>] ";
   }
   if ($STATUS=="14") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_reg.php?id=$IDD\">$LANGUAGE[144]</a>] ";
   }

   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_contacts.php?idd=$IDD\">$LANGUAGE[572]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_childdns.php?idd=$IDD\">$LANGUAGE[573]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  #crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  #echo "$LANGUAGE[1]";
 }

 function count_total_domains_ranged_expire($T1, $T2, $IDREG){
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ($AND_IDA=="") $AND_IDA="WHERE (expire>=$T1) AND (expire<=$T2) AND (idregistrant='$IDREG')"; else $AND_IDA.=" AND (expire>=$T1) AND (expire<=$T2) AND (idregistrant='$IDREG')";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_domain_list_ranged_expire($PAG, $T1, $T2, $IDREG){
  global $epp_professional,$LANGUAGE;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="WHERE (ida=$ID_ADMIN)"; else $AND_IDA="";
  if ($AND_IDA=="") $AND_IDA="WHERE (expire>=$T1) AND (expire<=$T2) AND (idregistrant='$IDREG')"; else $AND_IDA.=" AND (expire>=$T1) AND (expire<=$T2) AND (idregistrant='$IDREG')";

  $N=2500;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_ranged_expire($T1, $T2, $IDREG);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  echo "<br><b>$TOT</b> domini<br>";
  crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  DBSelect("SELECT * FROM domain_names $AND_IDA ORDER BY expire DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[146]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain_idn.php?id=$IDD\">$LANGUAGE[123]IDN</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   if ($STATUS=="13") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_mnt.php?id=$IDD\">$LANGUAGE[145]</a>] ";
   }
   if ($STATUS=="14") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_from_reg.php?id=$IDD\">$LANGUAGE[144]</a>] ";
   }

   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_contacts.php?idd=$IDD\">$LANGUAGE[572]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_childdns.php?idd=$IDD\">$LANGUAGE[573]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  #crea_navigator($PAG,$TOTPAG,8,"admin_domini.php?bar=true");
  #echo "$LANGUAGE[1]";
 }

 function count_total_domains_search($KEY){
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";
  DBSelect("SELECT COUNT(*) AS CNT FROM domain_names WHERE ((name LIKE '%$KEY%') OR (idregistrant LIKE '%$KEY%')) $AND_IDA",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_domain_list_search($PAG,$KEY){
  global $epp_professional,$LANGUAGE;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";

  $KEY=addslashes($KEY);

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_search($KEY);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_domini_search.php?bar=true&domseek=$KEY");
  DBSelect("SELECT * FROM domain_names WHERE ((name LIKE '%$KEY%') OR (idregistrant LIKE '%$KEY%')) $AND_IDA ORDER BY idd DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=30%><b>$LANGUAGE[114]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[115]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[116]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[117]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[118]</b></td>
     <td class=lightgrey width=8%><b>$LANGUAGE[119]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[120]</b></td>
    </tr>
  ";
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   //$DOMAIN_OPTIONS.=" [<a href=\"scripts/delete_domain.php?id=$IDD\">$LANGUAGE[121]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_delete.php?id=$IDD\">$LANGUAGE[121]</a>] ";

   if ($STATUS=="0") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[122]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    if ($epp_professional) {
     $DOMAIN_OPTIONS.=" [<a href=\"scripts/update_domain_backorder.php?id=$IDD\">$LANGUAGE[124]</a>] ";
    }
   }
   if ($STATUS=="1") {
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_vincoli.php?idd=$IDD\">$LANGUAGE[125]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domini_update.php?idd=$IDD\">$LANGUAGE[126]</a>] ";
    $UPD_OPTIONS1=" [<a href=\"admin_contacts_update_registrant.php?idd=$IDD\">$LANGUAGE[127]</a>] ";
    $UPD_OPTIONS2=" [<a href=\"admin_contacts_update_admin.php?idd=$IDD\">$LANGUAGE[128]</a>] ";
    $UPD_OPTIONS3=" [<a href=\"admin_contacts_update_tech.php?idd=$IDD\">$LANGUAGE[129]</a>] ";
   }
   if ($STATUS=="2") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain.php?id=$IDD\">$LANGUAGE[130]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_newreg_server_domain.php?id=$IDD\">$LANGUAGE[131]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_start.php?id=$IDD\">$LANGUAGE[132]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_delete.php?id=$IDD\">$LANGUAGE[133]</a>] ";
   }
   if ($STATUS=="3") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_approve.php?id=$IDD\">$LANGUAGE[134]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/transfert_server_domain_reject.php?id=$IDD\">$LANGUAGE[135]</a>] ";
   }
   if ($STATUS=="5") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/restore_domain.php?id=$IDD\">$LANGUAGE[136]</a>] ";
   }
   if ($STATUS=="9") {
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/create_server_domain.php?id=$IDD\">$LANGUAGE[123]</a>] ";
    $DOMAIN_OPTIONS.=" [<a href=\"scripts/remove_domain_backorder.php?id=$IDD\">$LANGUAGE[137]</a>] ";
   }
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/check_domain.php?id=$IDD\">$LANGUAGE[138]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/info_domain.php?id=$IDD\">$LANGUAGE[140]</a>] ";
   $DOMAIN_OPTIONS.=" [<a href=\"scripts/refresh_domain.php?id=$IDD\">$LANGUAGE[556]</a>] ";

   $STATUS_OPTIONS=" [<a href=\"admin_status_change.php?id=$IDD\">$LANGUAGE[557]</a>] ";

   if ($STATUS=="15") {
    $DOMAIN_OPTIONS="";
    $DOMAIN_OPTIONS.=" [<a href=\"admin_domain_dns.php?id=$IDD\">$LANGUAGE[139]</a>] ";
   }

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   $LEPP=strlen($EPPCOD);
   if ($LEPP>16) {
    $EPPCOD=substr($EPPCOD,0,12);
    $EPPCOD.=" [<a href=\"admin_domain_eppcode_full.php?id=$IDD\">$LANGUAGE[143]</a>] ";
   } 

   echo "
    <tr>
     <td class=$cl width=30%>$N <br> $DOMAIN_OPTIONS</td>
     <td class=$cl width=8%>$DC</td>
     <td class=$cl width=8%>$DU</td>
     <td class=$cl width=8%>$DS</td>
     <td class=$cl width=18%>$EPPCOD <br> $EPP_OPTIONS</td>
     <td class=$cl width=8%>$STATUS <br> $STATUS_OPTIONS</td>
     <td class=$cl width=20%>
      $IDREG $UPD_OPTIONS1 <br>
      $IDADM $UPD_OPTIONS2 <br>
      $IDTECH $UPD_OPTIONS3
     </td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_domini_search.php?bar=true&domseek=$KEY");
  echo "$LANGUAGE[1]";
 }

 function webpanel_domain_list_naked_search($PAG,$KEY){
  global $epp_professional,$LANGUAGE;
  $ID_ADMIN=admin_protection();
  if ($ID_ADMIN>1) $AND_IDA="AND (ida=$ID_ADMIN)"; else $AND_IDA="";

  $KEY=addslashes($KEY);

  $N=2500;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_domains_search($KEY);
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_domini_search.php?bar=true&domseek=$KEY");
  DBSelect("SELECT * FROM domain_names WHERE ((name LIKE '%$KEY%') OR (idregistrant LIKE '%$KEY%')) $AND_IDA ORDER BY idd DESC LIMIT $START,$N",$rs);
  $C=0;
  while (NextRecord($rs,$r)){
   $C++;
   $IDD=$r['idd'];
   $N=$r['name'];
   $TC=$r['created'];
   $TU=$r['updated'];
   $TE=$r['expire'];
   $DC=date("d/m/Y-H:i",$TC);
   $DU=date("d/m/Y-H:i",$TU);
   $DS=date("d/m/Y-H:i",$TE);
   $STATUS=$r['status'];
   $EPPCOD=$r['eppcode'];
   $EPPCOD=decrypt_webpanel_string($EPPCOD);
   $IDREG=$r['idregistrant'];
   $IDADM=$r['idadmin'];
   $IDTECH=$r['idtech'];
   $IDBILL=$r['idbill'];

   if ($C%2==0) $cl="light";
    else $cl="dark";

   if ($STATUS==0) $cl=$cl."blu";
    else if ($STATUS==1) $cl=$cl."grn";
    else if ($STATUS==2) $cl=$cl."org";
    else if ($STATUS==3) $cl=$cl."red";
    else if ($STATUS==4) $cl=$cl."red";
    else if ($STATUS==8) $cl=$cl."gry";
    else if ($STATUS==9) $cl=$cl."yel";
    else if ($STATUS==10) $cl=$cl."gry";
    else if ($STATUS==15) $cl=$cl."yel";
     else $cl=$cl."wht";

   $DOMAIN_OPTIONS="";
   $EPP_OPTIONS="";

   $EPP_OPTIONS=" [<a href=\"scripts/check_domain_eppcode.php?id=$IDD\">$LANGUAGE[141]</a>] ";
   $EPP_OPTIONS.=" [<a href=\"admin_domain_eppcode.php?id=$IDD\">$LANGUAGE[142]</a>] ";

   echo "
     $N <br>
   ";
  }
 }

 function delete_polling_msg($IDP){
  DBQuery("DELETE FROM epp_polling WHERE idp=$IDP");
 }

 function get_id_polling($CODE) {
  DBSelect("SELECT idp FROM epp_polling WHERE code=$CODE",$rs);
  if (NextRecord($rs,$r)) return $r['idp'];
   else return 0;
 }

 function count_total_pollings(){
  DBSelect("SELECT COUNT(*) AS CNT FROM epp_polling",$rs);
  if (NextRecord($rs,$r)) return $r['CNT'];
   else return 0;
 }

 function count_total_pollings_dns(){
  DBSelect("SELECT COUNT(*) AS CNT FROM epp_polling WHERE (opcode=13) OR (opcode=2)",$rs);
  if (NextRecord($rs,$r)) return $r['CNT'];
   else return 0;
 }

 function webpanel_polling_list_execute_opcodes(){
  DBSelect("SELECT * FROM epp_polling WHERE opcode=0",$rs);
  while (NextRecord($rs,$r)){
   $IDP=$r['idp'];
   $CODE=$r['code'];
   $QT=$r['qt'];
   $T=$r['title'];
   $D=$r['data'];
   $STATUS=$r['status'];
   $DOM=utf8_decode($r['domain']);
   $OP=$r['opcode'];
   $XML=$r['xml'];
   if ($DOM==""){
    $DOM=xml_get_value($XML,"extdom:name");
    polling_msg_upd_domain($IDP,$DOM);
    if ($DOM==""){
     $DOM=xml_get_value_opentag_domain($XML,"extdom:domain");
     polling_msg_upd_domain($IDP,$DOM);
    }
    if ($DOM==""){
     $DOM=$LANGUAGE[4];
     polling_msg_upd_domain($IDP,$DOM);
    }
   }
   if ($OP==0) { 
    $OP=search_polling_opcode($T); 
    update_polling_opcode($IDP,$OP);
    process_polling_opcode($DOM,$OP);
   } 
  }
 }

 function webpanel_polling_list_dns($PAG){
  global $LANGUAGE;

  $N=50;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_pollings_dns();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_polling_list_dns.php?bar=true");

  DBSelect("SELECT * FROM epp_polling WHERE (opcode=13) OR (opcode=2) ORDER BY idp DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=4%><b>$LANGUAGE[97]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[103]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[104]</b></td>
     <td class=lightgrey width=16%><b>$LANGUAGE[105]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[545]</b></td>
     <td class=lightgrey width=6%><b>$LANGUAGE[106]</b></td>
     <td class=lightgrey width=6%><b>$LANGUAGE[107]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[108]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[109]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[110]</b></td>
    </tr>
  ";
  while (NextRecord($rs,$r)){
   $IDP=$r['idp'];
   $CODE=$r['code'];
   $QT=$r['qt'];
   $T=$r['title'];
   $D=$r['data'];
   $STATUS=$r['status'];
   $DOM=utf8_decode($r['domain']);
   $OP=$r['opcode'];

   $XML=$r['xml'];
   if ($DOM==""){
    $DOM=xml_get_value($XML,"extdom:name");
    polling_msg_upd_domain($IDP,$DOM);
    if ($DOM==""){
     $DOM=xml_get_value_opentag_domain($XML,"extdom:domain");
     polling_msg_upd_domain($IDP,$DOM);
    }
    if ($DOM==""){
     $DOM=$LANGUAGE[4];
     polling_msg_upd_domain($IDP,$DOM);
    }
   }

   if ($OP==0) { 
    $OP=search_polling_opcode($T); 
    update_polling_opcode($IDP,$OP);
    process_polling_opcode($DOM,$OP);
   } 

   $POLLING_OPTIONS="";
   $POLLING_OPTIONS_DEQ="";
   $QUEUE_OPTIONS="";

   $POLLING_OPTIONS.=" [<a href=\"admin_polling_view_msg.php?idp=$IDP\">$LANGUAGE[111]</a>] ";
   $POLLING_OPTIONS_DEQ.=" [<a href=\"admin_polling_view_deqmsg.php?idp=$IDP\">$LANGUAGE[111]</a>] ";
   if ($STATUS=="Waiting") {
    $QUEUE_OPTIONS.=" [<a href=\"scripts/dequeue_msg.php?idp=$IDP&code=$CODE\">$LANGUAGE[112]</a>] ";
   } else {
    $QUEUE_OPTIONS.=" - ";
   }

   $CL="lightwhite";
   if ($OP==5) {
    $CL="lightgrn";
   }
   if ($OP==4) {
    $CL="lightred";
   } 

   $REG_NAME=get_registrant_name($DOM);

   echo "
    <tr>
     <td class=lightwhite width=4%>$IDP</td>
     <td class=lightwhite width=12%>$CODE</td>
     <td class=$CL width=18%>$T</td>
     <td class=lightwhite width=16%>$D</td>
     <td class=$CL width=20%>$DOM<br>($REG_NAME)</td>
     <td class=lightwhite width=6%>$OP</td>
     <td class=lightwhite width=6%>$QT</td>
     <td class=lightwhite width=12%>$POLLING_OPTIONS</td>
     <td class=lightwhite width=12%>$POLLING_OPTIONS_DEQ</td>
     <td class=lightwhite width=12%>$QUEUE_OPTIONS</td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_polling_list_dns.php?bar=true");
  echo "
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left><br>$LANGUAGE[113]</div></td>
   </tr></table> 
  ";
 }

 function webpanel_polling_list($PAG){
  global $LANGUAGE;

  $N=50;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_pollings();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_polling_list.php?bar=true");

  DBSelect("SELECT * FROM epp_polling ORDER BY idp DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=4%><b>$LANGUAGE[97]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[103]</b></td>
     <td class=lightgrey width=18%><b>$LANGUAGE[104]</b></td>
     <td class=lightgrey width=16%><b>$LANGUAGE[105]</b></td>
     <td class=lightgrey width=20%><b>$LANGUAGE[545]</b></td>
     <td class=lightgrey width=6%><b>$LANGUAGE[106]</b></td>
     <td class=lightgrey width=6%><b>$LANGUAGE[107]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[108]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[109]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[110]</b></td>
    </tr>
  ";
  while (NextRecord($rs,$r)){
   $IDP=$r['idp'];
   $CODE=$r['code'];
   $QT=$r['qt'];
   $T=$r['title'];
   $D=$r['data'];
   $STATUS=$r['status'];
   $DOM=utf8_decode($r['domain']);
   $OP=$r['opcode'];

   $XML=$r['xml'];
   if ($DOM==""){
    $DOM=xml_get_value($XML,"extdom:name");
    polling_msg_upd_domain($IDP,$DOM);
    if ($DOM==""){
     $DOM=xml_get_value_opentag_domain($XML,"extdom:domain");
     polling_msg_upd_domain($IDP,$DOM);
    }
    if ($DOM==""){
     $DOM=$LANGUAGE[4];
     polling_msg_upd_domain($IDP,$DOM);
    }
   }

   if ($OP==0) { 
    $OP=search_polling_opcode($T); 
    update_polling_opcode($IDP,$OP);
    process_polling_opcode($DOM,$OP);
   } 

   $POLLING_OPTIONS="";
   $POLLING_OPTIONS_DEQ="";
   $QUEUE_OPTIONS="";

   $POLLING_OPTIONS.=" [<a href=\"admin_polling_view_msg.php?idp=$IDP\">$LANGUAGE[111]</a>] ";
   $POLLING_OPTIONS_DEQ.=" [<a href=\"admin_polling_view_deqmsg.php?idp=$IDP\">$LANGUAGE[111]</a>] ";
   if ($STATUS=="Waiting") {
    $QUEUE_OPTIONS.=" [<a href=\"scripts/dequeue_msg.php?idp=$IDP&code=$CODE\">$LANGUAGE[112]</a>] ";
   } else {
    $QUEUE_OPTIONS.=" - ";
   }

   $CL="lightwhite";
   if ($OP==5) {
    $CL="lightgrn";
   }
   if ($OP==4) {
    $CL="lightred";
   } 

   $REG_NAME=get_registrant_name($DOM);

   echo "
    <tr>
     <td class=lightwhite width=4%>$IDP</td>
     <td class=lightwhite width=12%>$CODE</td>
     <td class=$CL width=18%>$T</td>
     <td class=lightwhite width=16%>$D</td>
     <td class=$CL width=20%>$DOM<br>($REG_NAME)</td>
     <td class=lightwhite width=6%>$OP</td>
     <td class=lightwhite width=6%>$QT</td>
     <td class=lightwhite width=12%>$POLLING_OPTIONS</td>
     <td class=lightwhite width=12%>$POLLING_OPTIONS_DEQ</td>
     <td class=lightwhite width=12%>$QUEUE_OPTIONS</td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_polling_list.php?bar=true");
  echo "
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left><br>$LANGUAGE[113]</div></td>
   </tr></table> 
  ";
 }

 function webpanel_polling_list_clean($PAG){
  global $LANGUAGE;

  $N=250;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_pollings();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  DBSelect("SELECT * FROM epp_polling ORDER BY idp DESC LIMIT $START,$N",$rs);
  while (NextRecord($rs,$r)){
   $IDP=$r['idp'];
   $CODE=$r['code'];
   $QT=$r['qt'];
   $T=$r['title'];
   $D=$r['data'];
   $STATUS=$r['status'];
   $DOM=utf8_decode($r['domain']);
   $OP=$r['opcode'];

   $XML=$r['xml'];
   if ($DOM==""){
    $DOM=xml_get_value($XML,"extdom:name");
    polling_msg_upd_domain($IDP,$DOM);
    if ($DOM==""){
     $DOM=xml_get_value_opentag_domain($XML,"extdom:domain");
     polling_msg_upd_domain($IDP,$DOM);
    }
    if ($DOM==""){
     $DOM=$LANGUAGE[4];
     polling_msg_upd_domain($IDP,$DOM);
    }
   }

   if ($OP==0) { 
    $OP=search_polling_opcode($T); 
    update_polling_opcode($IDP,$OP);
    process_polling_opcode($DOM,$OP);
   } 

   $REG_NAME=get_registrant_name($DOM);

   echo "$DOM<br>";
  }
 }

 ########################################################################
 # Funzioni aggiunte 05/10/2009.
 ########################################################################

 function webpanel_openepp($IDADMIN,$IDSESSION,$CRD){
  $T=time(); 
  if (!isset($CRD)) $CRD=0;
  @DBQuery("
   INSERT INTO epp_sessions 
   (ida, started, updated, status, sessionid, crd_start, crd_end)  
    VALUES
   ($IDADMIN, $T, $T, 'Open', '$IDSESSION', '$CRD', '$CRD')
  ");
 }

 function webpanel_closeepp($IDADMIN,$CRD){
  $IDEPP=admin_eppsession($IDADMIN);
  if ($CRD=="") $CRD=0;
  DBQuery("UPDATE epp_sessions SET status='Closed', crd_end='$CRD' WHERE idepp=$IDEPP");
 }

 function count_total_epplogins(){
  DBSelect("SELECT COUNT(*) AS CNT FROM epp_sessions",$rs);
  if (NextRecord($rs,$r)){
   return $r['CNT'];
  } else return 0;
 }

 function webpanel_epp_history($IDADMIN,$PAG){
  global $LANGUAGE;

  $N=25;
  if (!is_numeric($PAG)) $PAG=0;
  $TOT=count_total_epplogins();
  if (($PAG=="")||($PAG<1)) $PAG=1;
  $TOTPAG=floor($TOT/$N);
  if ($TOT%$N!=0) $TOTPAG++;
  $START=($PAG-1)*$N;

  crea_navigator($PAG,$TOTPAG,8,"admin_epplogs.php?bar=true");
  DBSelect("SELECT * FROM epp_sessions WHERE ida=$IDADMIN ORDER BY idepp DESC LIMIT $START,$N",$rs);
  echo "
   <table width=98%>
    <tr>
     <td class=lightgrey width=8%><b>$LANGUAGE[97]</b></td>
     <td class=lightgrey width=14%><b>$LANGUAGE[98]</b></td>
     <td class=lightgrey width=14%><b>$LANGUAGE[99]</b></td>
     <td class=lightgrey width=10%><b>$LANGUAGE[100]</b></td>
     <td class=lightgrey width=42%><b>$LANGUAGE[101]</b></td>
     <td class=lightgrey width=12%><b>$LANGUAGE[102]</b></td>
    </tr>
  ";
  while (NextRecord($rs,$r)){
   $ID=$r['idepp'];
   $TS=$r['started'];
   $TU=$r['updated'];
   $S=date("d/m/Y-H:i",$TS);
   $U=date("d/m/Y-H:i",$TU);
   $STATUS=$r['status'];
   $IDSESSION=$r['sessionid'];
   $CRDS=$r['crd_start'];
   $CRDE=$r['crd_end'];
   echo "
    <tr>
     <td width=8%>$ID</td>
     <td width=14%>$S</td>
     <td width=14%>$U</td>
     <td width=10%>$STATUS</td>
     <td width=42%>$IDSESSION</td>
     <td width=12%>$CRDS/$CRDE</td>
    </tr>
   ";
  }
  echo "</table>";
  crea_navigator($PAG,$TOTPAG,8,"admin_epplogs.php?bar=true");
 }

 function form_open_eppconnection_newpassword($IDADMIN){
  global $LANGUAGE;
  $IDES=get_servers_ides($IDADMIN);
  echo "
   <b>$LANGUAGE[93]</b>
   <br><br>
   <form method=POST action=\"admin_newpassword.php?idadmin=$IDADMIN\">
    <b>$LANGUAGE[94]</b> ".client_select_epp_server($IDES)." <br>
    <b>$LANGUAGE[95]</b> <input type=text name=\"newpassword\" size=12 value=\"\">
    <input type=submit value=\"$LANGUAGE[96]\">
   </form>  
  ";
 }

 function form_open_eppconnection($IDADMIN){
  global $LANGUAGE;
  $IDES=get_servers_ides($IDADMIN);
  echo "
   <b>$LANGUAGE[91]</b>
   <br><br>
   <form method=POST action=\"admin_login.php?idadmin=$IDADMIN\">
    <b>$LANGUAGE[92]</b> ".client_select_epp_server($IDES)." <br>
    <input type=submit value=\" $LANGUAGE[89] \">
   </form>  
  ";
 }

 function form_close_eppconnection($IDADMIN){
  global $LANGUAGE;
  echo "
   <b>$LANGUAGE[90]</b>
   <br><br>
   <form method=POST action=\"admin_logout.php?idadmin=$IDADMIN\">
    <input type=submit value=\" $LANGUAGE[88] \">
   </form>  
  ";
 }

 function update_expired_sessions(){
  DBSelect("SELECT * FROM epp_sessions WHERE status='Open'",$rs);
  while (NextRecord($rs,$r)) {
   $ID=$r['idepp'];
   $T=time(); 
   $LAST=$r['updated'];
   if ($LAST<($T-900)) {
    DBQuery("UPDATE epp_sessions SET status='Expired' WHERE idepp=$ID");
   }
  }
 }

 function admin_eppsession($IDADMIN){
  update_expired_sessions();
  DBSelect("SELECT * FROM epp_sessions WHERE ida=$IDADMIN AND status='Open'",$rs);
  if (NextRecord($rs,$r)) {
   return $r['idepp'];
  } else return 0;
 }

 function admin_get_eppsessionid($IDEPP){
  DBSelect("SELECT * FROM epp_sessions WHERE idepp=$IDEPP",$rs);
  if (NextRecord($rs,$r)) {
   return $r['sessionid'];
  } else return "";
 }

 function admin_eppsession_protection($IDADMIN){
  global $LANGUAGE;
  update_expired_sessions();
  DBSelect("SELECT * FROM epp_sessions WHERE ida=$IDADMIN AND status='Open'",$rs);
  if (NextRecord($rs,$r)) {
   return $r['idepp'];
  } else {
   echo "<br><br>";
   echo "$LANGUAGE[85] <br>";
   echo "$LANGUAGE[86] <br>";
   echo "<br><br>";
   echo "$LANGUAGE[87]";
   echo "<br><br>";
   die();
  }
 }

 ########################################################################
 # Funzioni aggiunte in precedenza.
 ########################################################################

 function print_html_errore($E){
  global $LANGUAGE;
  print_clearline(3); 
  echo "<DIV>";
  if ($E==1) echo "$LANGUAGE[78]";
  if ($E==2) echo "$LANGUAGE[79]";
  if ($E==3) echo "$LANGUAGE[80]";
  if ($E==4) echo "$LANGUAGE[81]";
  if ($E==5) echo "$LANGUAGE[82]";
  if ($E==6) echo "$LANGUAGE[83]";
  if ($E==7) echo "$LANGUAGE[84]";
  echo "</div>";
  print_clearline(3); 
 }

 function login_box(){
  global $LANGUAGE;
  return "
   <div><div class=login_box>
    <form name=\"signin\" action=\"scripts/signin.php\" method=POST>
     <hr> 
     <b>$LANGUAGE[77]</b>: <br>
     <input type=\"text\" name=\"username\" size=\"20\"> <br>
     <br>
     <b>$LANGUAGE[76]</b>: <br>
     <input type=\"password\" name=\"password\" size=\"20\"> <br>
     <br>
     <input type=\"Submit\" name=\"Submit\" value=\"$LANGUAGE[75]\"> <br>
     <hr> 
    </form>
   </div></div>
  ";
 }

 function print_login_box(){
  echo login_box();
 } 

 function print_html_top($TITOLO_PAG){
  session_start();
  echo " 
   <HTML>
    <HEAD>
     <TITLE>$TITOLO_PAG</TITLE>
     <link rel=stylesheet href=\"css/stile.css\" type=\"text/css\">
    </HEAD>
    <BODY>
    <DIV><table width=980><tr><td><DIV>
  ";
 } 

 function print_html_top_nosession($TITOLO_PAG){
  echo " 
   <HTML>
    <HEAD>
     <TITLE>$TITOLO_PAG</TITLE>
     <link rel=stylesheet href=\"css/stile.css\" type=\"text/css\">
    </HEAD>
    <BODY>
    <DIV><table width=980><tr><td><DIV>
  ";
 } 

 function print_html_top_test($TITOLO_PAG){
  session_start();
  echo " 
   <HTML>
    <HEAD>
     <TITLE>$TITOLO_PAG</TITLE>
     <link rel=stylesheet href=\"../css/stile.css\" type=\"text/css\">
    </HEAD>
    <BODY>
    <DIV><table width=980><tr><td><DIV>
  ";
 } 

 function print_html_down(){
  echo "
     </div></td></tr></table></div>
    </BODY>
   </HTML>
  ";
  session_write_close();
 }

 function get_level_desc($TIPO_UTENTE) {
  if ($TIPO_UTENTE==1) return "ADMIN";
   else if ($TIPO_UTENTE==2) return "RESELLER";
    else if ($TIPO_UTENTE==3) return "UTENTE";
     else return "None";
 }

 function print_html_menu_admin(){
  global $LANGUAGE, $SHOW_SUGGESTED_LINK, $SHOW_DEBUG_PHPINFO, $SHOW_EXAM_LINKS; 

  $ID_UTENTE=id_active_user();
  if ($ID_UTENTE>0) {
   $LOG="<a href=\"scripts/logout.php\">$LANGUAGE[533]</a>";
   $TIPO_UTENTE=get_userlevel($ID_UTENTE);
  } else {
   $LOG="<a href=\"login.php\">$LANGUAGE[532]</a>";
   $TIPO_UTENTE="";
  }
  if ($ID_UTENTE>0) {
   get_admin_info($ID_UTENTE,$NOME,$COGNOME);
   $TRD="
    <BR><BR>
     <DIV> 
      $LANGUAGE[74] <br><br> <b>$NOME $COGNOME</b> ($LOG) <br><br> 
      $LANGUAGE[73] <b>".get_level_desc($TIPO_UTENTE)."</b> <br>
      $LANGUAGE[72] <b>".get_client_version()."</b>
     </DIV><BR>
   ";
  }  
  if ($ID_UTENTE>1) {
   $CRD_RESELLER=get_available_credits($ID_UTENTE);
   $TRD.="
     <DIV> 
      Credito Reseller <br><br> <b>$CRD_RESELLER</b> <br><br> 
     </DIV><BR>
   "; 
  }

  echo "
   <DIV>
   <TABLE width=99%>
    <TR><TD class=lightblue><a href=\"admin_index.php\">$LANGUAGE[61]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_utenti_crea.php\">$LANGUAGE[62]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_utenti.php\">$LANGUAGE[63]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_domini_crea.php\">$LANGUAGE[64]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_domini.php\">$LANGUAGE[65]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_domini_transfert.php\">$LANGUAGE[66]</a></TD></TR>
   ";
   if ($TIPO_UTENTE<=1) {
    echo "
    <TR><TD class=lightblue><a href=\"admin_polling.php\">$LANGUAGE[67]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_polling_list.php\">$LANGUAGE[68]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_hello.php\">$LANGUAGE[69]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_nakedxml.php\">$LANGUAGE[70]</a></TD></TR>
    <TR><TD class=lightblue>------</TD></TR>
    <TR><TD class=lightgrn><a href=\"admin_domini_lastday.php\">$LANGUAGE[598]</a></TD></TR>
    <TR><TD class=lightyel><a href=\"admin_domini_deleting_expire_starting.php\">$LANGUAGE[632]</a></TD></TR>
    <TR><TD class=lightyel><a href=\"admin_domini_deleting_expire_ending.php\">$LANGUAGE[633]</a></TD></TR>
    <TR><TD class=lightyel><a href=\"admin_domini_deleting_queued.php\">$LANGUAGE[634]</a></TD></TR>
    <TR><TD class=lightblue>------</TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_reg.php\">$LANGUAGE[589]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_nsupdate.php\">$LANGUAGE[584]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_transfer.php\">$LANGUAGE[585]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_transfer_trade.php\">$LANGUAGE[587]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_transfer_getepp.php\">Bulk Transfer Get EPP</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_transfer_approve.php\">Bulk Transfer Approve</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_contact_update.php\">$LANGUAGE[590]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_restore.php\">$LANGUAGE[611]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_bulk_delete.php\">$LANGUAGE[600]</a></TD></TR>
    <TR><TD class=lightblue>------</TD></TR>
    <TR><TD class=lightblue><a href=\"scripts/bulk_transferts_approve.php\">$LANGUAGE[586]</a></TD></TR>
    <TR><TD class=lightblue>------</TD></TR>
    <TR><TD class=lightblue><a href=\"cron/auto_update.php\">$LANGUAGE[552]</a></TD></TR>
    <TR><TD class=lightblue>------</TD></TR>
    ";
    if ($SHOW_SUGGESTED_LINK) {
     echo "
      <TR><TD class=lightblue><a href=\"admin_links.php\">$LANGUAGE[71]</a></TD></TR>
     ";
    }
   }
   echo "
   </TABLE>
   </DIV>
   $TRD
  ";

  if ($TIPO_UTENTE<=1) 
  echo "
   <DIV>
   <TABLE width=99%>
    <TR><TD class=lightblue><a href=\"admin_queue_deleting.php\">$LANGUAGE[626]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_import_archivepolling.php\">$LANGUAGE[599]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_import_resetlist.php\">$LANGUAGE[593]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_import_cleanlist.php\">$LANGUAGE[594]</a></TD></TR>
    <TR><TD class=lightblue><a href=\"admin_import_mnt.php\">$LANGUAGE[60]</a></TD></TR>
   </TABLE>
   </DIV>
   <br>
  ";

  if ($TIPO_UTENTE<=1) {
  if ( (is_exam_on()) && ($SHOW_EXAM_LINKS) ){
   echo "
    <DIV>
    <b>$LANGUAGE[57]</b><br>
    <TABLE width=99%>
     <TR><TD class=lightblue><a href=\"NicTest/admin_nictest.php\">$LANGUAGE[56]</a></TD></TR>
     <TR><TD class=lightblue><a href=\"NicTest2/admin_nictest.php\">$LANGUAGE[549]</a></TD></TR>
    </TABLE>
    </DIV>
   ";
  }

  if ( (is_debug_on()) && ($SHOW_DEBUG_PHPINFO) ){
   echo "
    <DIV>
    <b>$LANGUAGE[55]</b><br>
    <TABLE width=99%>
     <TR><TD class=lightblue><a href=\"admin_phpinfo.php\">$LANGUAGE[54]</a></TD></TR>
    </TABLE>
    </DIV>
   ";
  }
  }
 }

 function print_html_menu_admin_test(){
  global $LANGUAGE;
  $ID_UTENTE=id_active_user();
  if ($ID_UTENTE>0) {
   $LOG="<a href=\"../scripts/logout.php\">$LANGUAGE[533]</a>";
   $TIPO_UTENTE=get_userlevel($ID_UTENTE);
  } else {
   $LOG="<a href=\"../login.php\">$LANGUAGE[532]</a>";
   $TIPO_UTENTE="";
  }
  if ($ID_UTENTE>0) {
   get_admin_info($ID_UTENTE,$NOME,$COGNOME);
   $TRD="
    <BR><BR>
     <DIV> 
      $LANGUAGE[74] <br><br> <b>$NOME $COGNOME</b> ($LOG) <br><br> 
      $LANGUAGE[73] <b>$TIPO_UTENTE</b> <br>
      $LANGUAGE[72] <b>".get_client_version()."</b>
     </div><BR>
   ";
  }  
  echo "
   <DIV>
   <TABLE width=99%>
    <TR><TD class=lightblue><a href=\"../index.php\">$LANGUAGE[534]</a></TD></TR>
   </TABLE>
   </DIV>
   $TRD
  ";
 }

 function print_html_menu(){
  global $LANGUAGE;
  $IDADM=id_active_user();
  $ID_LEVEL=get_userlevel($IDADM);  
  if ($IDADM==0) {  
   echo "
    <TABLE width=100%><TR>
     <TD class=lightgrey><b>$LANGUAGE[47]</b></TD>
    </TR></TABLE>
   ";
  } else {
   echo "
    <TABLE width=100%><TR>
     <TD class=lightgrey><a href=\"admin_index.php\">$LANGUAGE[48]</a></TD>
   ";
   if ($ID_LEVEL<=1) { 
    echo "
     <TD class=lightgrey><a href=\"admin_credits.php\">$LANGUAGE[591]</a></TD>
     <TD class=lightgrey><a href=\"admin_epplogs.php\">$LANGUAGE[49]</a></TD>
     <TD class=lightgrey><a href=\"admin_logs.php\">$LANGUAGE[50]</a></TD>
     <TD class=lightgrey><a href=\"admin_default.php\">$LANGUAGE[51]</a></TD>
    ";
   }
   echo "
     <TD class=lightgrey><a href=\"admin_password.php\">$LANGUAGE[52]</a></TD>
     <TD class=lightgrey><a href=\"scripts/logout.php\">$LANGUAGE[53]</a></TD>
    </TR></TABLE>
   ";
  }
 }

 function print_html_menu_test(){
  global $LANGUAGE;
  $IDADM=id_active_user();
  if ($IDADM==0) {  
   echo "
    <TABLE width=100%><TR>
     <TD class=lightgrey><b>$LANGUAGE[47]</b></TD>
    </TR></TABLE>
   ";
  } else {
   echo "
    <TABLE width=100%><TR>
     <TD class=lightgrey width=12%><a href=\"../admin_index.php\">$LANGUAGE[48]</a></TD>
     <TD class=lightgrey width=18%><a href=\"../admin_epplogs.php\">$LANGUAGE[49]</a></TD>
     <TD class=lightgrey width=16%><a href=\"../admin_logs.php\">$LANGUAGE[50]</a></TD>
     <TD class=lightgrey width=20%><a href=\"../admin_default.php\">$LANGUAGE[51]</a></TD>
     <TD class=lightgrey width=15%><a href=\"../admin_password.php\">$LANGUAGE[52]</a></TD>
     <TD class=lightgrey width=14%><a href=\"../scripts/logout.php\">$LANGUAGE[53]</a></TD>
    </TR></TABLE>
   ";
  }
 }

 function get_idlevel($IDA){
  DBSelect("SELECT * FROM admin_users WHERE ida=$IDA",$rs);
  if (NextRecord($rs,$r)) return $r['idlevel'];
   else return 0;
 }

 function get_client_version_old(){
  DBSelect("SELECT client_version FROM admin_users WHERE ida=1",$rs);
  if (NextRecord($rs,$r)) return $r['client_version'];
   else return 0;
 }

 function cancella_dati_utente($IDA){
  DBQuery("DELETE FROM admin_users WHERE ida=$IDA");
  DBQuery("DELETE FROM admin_eppconfig WHERE ida=$IDA");
 }

 function registra_dati_utente($IDA,$USERNAME,$PASSWORD,$NAME,$SURNAME,$EMAIL,$TIPO,$STATO){
  $IDUSRLEVEL=get_idlevel($IDA);
  if ($IDUSRLEVEL==1) {
   $CLIENT_VERSION=get_client_version();
   $PASSWORD=crypt_webpanel_string($PASSWORD);

   #DBQuery("
   # INSERT INTO admin_users (ida, username, password, idlevel, nome, cognome, stato, email, idd, crd, used_crd)
   #  VALUES ('', '$USERNAME', '$PASSWORD', '$TIPO', '$NAME', '$SURNAME', '$STATO', '$EMAIL', '0', '0', '0')
   #");

   DBQuery("
    INSERT INTO admin_users (username, password, idlevel, nome, cognome, stato, email, idd, crd, used_crd)
     VALUES ('$USERNAME', '$PASSWORD', '$TIPO', '$NAME', '$SURNAME', '$STATO', '$EMAIL', '0', '0', '0')
   ");

   #DBQuery("
   # INSERT INTO admin_eppconfig 
   #  (ida, debug, exam, eppcredit, ns1, ip1, ns2, ip2, ns3, ip3, ns4, ip4, ns5, ip5,idregistrant, 
   #   idadmin, idtech, idbill, contactid_prefix, ides, idds, client_version)
   #   VALUES ('', 'False', 'False', '0', '', '', '', '', '', '', '', '', '', 
   #    '', '', '', '', '', '', '0', '0', '$CLIENT_VERSION')
   #");

   DBQuery("
    INSERT INTO admin_eppconfig 
     (debug, exam, eppcredit, ns1, ip1, ns2, ip2, ns3, ip3, ns4, ip4, ns5, ip5,idregistrant, 
      idadmin, idtech, idbill, contactid_prefix, ides, idds, client_version)
      VALUES ('False', 'False', '0', '', '', '', '', '', '', '', '', '', 
       '', '', '', '', '', '', '0', '0', '$CLIENT_VERSION')
   ");
  }
 }

 function aggiorna_dati_utente($ID,$USERNAME,$PASSWORD,$NAME,$SURNAME,$EMAIL,$TIPO,$STATO){
  $PASSWORD=crypt_webpanel_string($PASSWORD);
  DBQuery("
   UPDATE admin_users SET
    nome='$NAME',
    cognome='$SURNAME',
    email='$EMAIL',
    username='$USERNAME',
    password='$PASSWORD',
    idlevel='$TIPO',
    stato='$STATO'
   WHERE ida=$ID
  ");
 }

 function admin_mostra_dati_account($ID){
  global $LANGUAGE;
  DBSelect("SELECT * FROM admin_users WHERE ida=$ID",$rs);
  echo "<DIV><table width=40%><tr><td><div align=left>";
  if (NextRecord($rs,$r)) {
   $ID=$r['ida'];
   $NOME=$r['nome'];
   $COGNOME=$r['cognome'];
   $EMAIL=$r['email'];
   $USERNAME=$r['username'];
   $PASSWORD=decrypt_webpanel_string($r['password']);
   $PASSWORD=mask_password($PASSWORD);
   $TIPO=get_tipo($r['idlevel']);
   $STATO=$r['stato'];
   echo "
    <b>$LANGUAGE[40]</b> $ID <br>
    <b>$LANGUAGE[41]</b> $NOME $COGNOME <br>
    <b>$LANGUAGE[42]</b> $EMAIL <br>
    <b>$LANGUAGE[43]</b> $USERNAME <br>
    <b>$LANGUAGE[44]</b> $PASSWORD <br>
    <b>$LANGUAGE[45]</b> $TIPO <br>
    <b>$LANGUAGE[46]</b> $STATO <br>
   ";
  }
  echo "</div></td></tr></table></div>";
 }

 function lista_utenti_admin(){
  global $LANGUAGE;
  DBSelect("SELECT * FROM admin_users ORDER BY ida ASC",$rs);
  echo "<DIV><table width=94%>";
  echo "
    <tr>
     <td width=4%><b>$LANGUAGE[30]</b></td>
     <td width=16%><b>$LANGUAGE[31] $LANGUAGE[32] $LANGUAGE[33]</b><br></td>
     <td width=14%><b>Credito Disponibile</b></td>
     <td width=14%><b>Credito Usato</b></td>
     <td width=10%><b>$LANGUAGE[34]</b></td>
     <td width=10%><b>$LANGUAGE[35]</b></td>
     <td width=8%><b>$LANGUAGE[36]</b></td>
     <td width=8%><b>$LANGUAGE[37]</b></td>
     <td width=8%><b>$LANGUAGE[38]</b></td>
     <td width=8%><b>$LANGUAGE[39]</b></td>
    </tr>
  ";
  while (NextRecord($rs,$r)) {
   $ID=$r['ida'];
   $NOME=$r['nome'];
   $COGNOME=$r['cognome'];
   $EMAIL=$r['email'];
   $USERNAME=$r['username'];
   $PASSWORD=$r['password'];
   $TIPO=get_tipo($r['idlevel']);
   $STATO=$r['stato'];
   $EDITA="[ <a href=\"admin_modifica_utente.php?id=$ID&id_user=$ID\">$LANGUAGE[28]</a> ]";
   $CANCELLA="[ <a href=\"admin_cancella_utente.php?id=$ID\">$LANGUAGE[29]</a> ]";

   $AVAILABLE_CRD=get_available_credits($ID);
   $USED_CRD=get_used_credits($ID);

   $AVAILABLE_CRD="Disponibili: $AVAILABLE_CRD ";
   $USED_CRD="Usati: <a href=\"admin_storico_credito.php?id_user=$ID\">$USED_CRD</a> ";
   $ADD_CRD=" <a href=\"admin_aggiungi_credito.php?id_user=$ID\">Aggiungi Crediti</a> ";

   echo "
    <tr>
     <td width=4%>$ID</td>
     <td width=16%><b>$NOME $COGNOME</b><br> $EMAIL <br><br> $ADD_CRD <br></td>
     <td width=14%> $AVAILABLE_CRD </td>
     <td width=14%> $USED_CRD </td>
     <td width=10%>$USERNAME</td>
     <td width=10%>$PASSWORD</td>
     <td width=8%>$TIPO</td>
     <td width=8%>$STATO</td>
     <td width=8%>$EDITA</td>
     <td width=8%>$CANCELLA</td>
    </tr>
   ";
  }
  echo "</table></div>";
 }

 function form_admin_cancella_utente($ID_UTENTE){
  global $LANGUAGE;
  echo "
   <DIV>
   <form method=POST action=\"scripts/cancella_utente.php?ID=$ID_UTENTE\">
    <b>$LANGUAGE[26]</b><br>
    <input type=submit name=S value=\"$LANGUAGE[27]\">
   </form>
   </div>
  ";
 }

 function sel_tipo(){
  global $LANGUAGE;
  $V="";
  $V="<select class=select name=\"TIPO\" size=1>";
  $V.="<option value=\"1\">$LANGUAGE[23]</option>";
  $V.="<option value=\"2\">$LANGUAGE[24]</option>";
  $V.="<option value=\"3\">$LANGUAGE[25]</option>";
  $V.="</select>";
  return $V;
 }

 function get_tipo($VAL){
  global $LANGUAGE;
  $V="";
  if ($VAL==1) $V=$LANGUAGE[23];
  if ($VAL==2) $V=$LANGUAGE[24];
  if ($VAL==3) $V=$LANGUAGE[25];
  return $V;
 }

 function sel_stato(){
  global $LANGUAGE;
  $V="";
  $V="<select class=select name=\"STATO\" size=1>";
  $V.="<option value=\"Attivo\">$LANGUAGE[20]</option>";
  $V.="<option value=\"Disattivato\">$LANGUAGE[21]</option>";
  $V.="<option value=\"Bloccato\">$LANGUAGE[22]</option>";
  $V.="</select>";
  return $V;
 }

 function form_admin_aggiungi_utente($ID_UTENTE){
  global $LANGUAGE;
  echo "
   <br>
   <DIV>
   <form method=POST action=\"scripts/registra_utente.php?ID=$ID_UTENTE\">
    <b>$LANGUAGE[11]</b> <input type=text size=16 name=\"NOME\" value=\"\">
    <b>$LANGUAGE[12]</b> <input type=text size=16 name=\"COGNOME\" value=\"\"> <br>
    <b>$LANGUAGE[13]</b> <input type=text size=36 name=\"EMAIL\" value=\"\"> <br>
    <b>$LANGUAGE[14]</b> <input type=text size=16 name=\"USERNAME\" value=\"\">
    <b>$LANGUAGE[15]</b> <input type=password size=16 name=\"PASSWORD\" value=\"\"> <br>
    <b>$LANGUAGE[17]</b> ".sel_tipo()." <b>$LANGUAGE[18]</b> ".sel_stato()." <br>
    <br>
    <DIV><input type=submit name=S value=\"$LANGUAGE[16]\"></div>
   </form>
   </div>
  ";
 }

 function form_admin_modifica_utente($ID_UTENTE){
  global $LANGUAGE;
  DBSelect("SELECT * FROM admin_users WHERE ida=$ID_UTENTE",$rs);
  if (NextRecord($rs,$r)) {
   $NOME=$r['nome'];
   $COGNOME=$r['cognome'];
   $EMAIL=$r['email'];
   $USERNAME=$r['username'];
   $PASSWORD=decrypt_webpanel_string($r['password']);
  }
  echo "
   <br>
   <DIV>
   <form method=POST action=\"scripts/aggiorna_utente.php?ID=$ID_UTENTE\">
    <b>$LANGUAGE[11]</b> <input type=text size=16 name=\"NOME\" value=\"$NOME\">
    <b>$LANGUAGE[12]</b> <input type=text size=16 name=\"COGNOME\" value=\"$COGNOME\"> <br>
    <b>$LANGUAGE[13]</b> <input type=text size=32 name=\"EMAIL\" value=\"$EMAIL\"> <br>
    <b>$LANGUAGE[14]</b> <input type=text size=16 name=\"USERNAME\" value=\"$USERNAME\">
    <b>$LANGUAGE[15]</b> <input type=password size=16 name=\"PASSWORD\" value=\"$PASSWORD\"> <br>
    <b>$LANGUAGE[17]</b> ".sel_tipo()." <b>$LANGUAGE[18]</b> ".sel_stato()." <br>
    <br>
    <DIV><input type=submit name=S value=\"$LANGUAGE[19]\"></div>
   </form>
   </div>
  ";
 }

 function form_registrazione(){
  global $LANGUAGE;
  echo "
   <br>
   <DIV>
   <form method=POST action=\"scripts/registra_utente.php\">
    <b>$LANGUAGE[11]</b> <input type=text size=32 name=\"NOME\"> <br>
    <b>$LANGUAGE[12]</b> <input type=text size=32 name=\"COGNOME\"> <br>
    <b>$LANGUAGE[13]</b> <input type=text size=32 name=\"EMAIL\"> <br>
    <b>$LANGUAGE[14]</b> <input type=text size=32 name=\"USERNAME\"> <br>
    <b>$LANGUAGE[15]</b> <input type=password size=32 name=\"PASSWORD\"> <br>
    <br>
    <input type=submit name=S value=\"$LANGUAGE[16]\">
   </form>
   </div>
  ";
 } 

 function form_cambia_utente_e_password(){
  global $LANGUAGE; 
  $ID_UTENTE=id_active_user();
  if ($ID_UTENTE>0) {
   $TIPO_UTENTE=get_userlevel($ID_UTENTE);
   if ($TIPO_UTENTE=="Admin") $PWDUPD="admin_password.php";
    else if ($TIPO_UTENTE=="Gestore") $PWDUPD="gestore_password.php";
     else if ($TIPO_UTENTE=="Utente") $PWDUPD="utente_password.php";
      else $PWDUPD="aggiorna_password.php";
  }
  echo "
   <DIV>
   <br><b>$LANGUAGE[544]</b><br><br>
   <form method=POST action=\"scripts/$PWDUPD\">
    <b>$LANGUAGE[378]</b> <input type=text size=12 name=\"USERNAME\"> <br>
    <b>$LANGUAGE[9]</b> <input type=password size=12 name=\"PASSWORD\"> <br>
    <br> 
    <input type=submit name=S value=\"$LANGUAGE[10]\">
   </form>
   </div>
  ";
 }

 function form_cambia_password(){
  global $LANGUAGE; 
  $ID_UTENTE=id_active_user();
  if ($ID_UTENTE>0) {
   $TIPO_UTENTE=get_userlevel($ID_UTENTE);
   if ($TIPO_UTENTE=="Admin") $PWDUPD="admin_password.php";
    else if ($TIPO_UTENTE=="Gestore") $PWDUPD="gestore_password.php";
     else if ($TIPO_UTENTE=="Utente") $PWDUPD="utente_password.php";
      else $PWDUPD="aggiorna_password.php";
  }
  echo "
   <DIV>
   <br><b>$LANGUAGE[8]</b><br><br>
   <form method=POST action=\"scripts/$PWDUPD\">
    <b>$LANGUAGE[9]</b> <input type=password size=12 name=\"PASSWORD\"> <br><br>
    <input type=submit name=S value=\"$LANGUAGE[10]\">
   </form>
   </div>
  ";
 }

 function form_carica_conto(){
  global $LANGUAGE;
  echo "
   <DIV>
    <form method=POST action=\"scripts/aggiungi_conto.php\">
     <b>$LANGUAGE[6]</b> <input type=text size=10 name=\"CIFRA\">
     <input type=submit name=S value=\"$LANGUAGE[7]\">
    </form>
   </div>
  ";
 }

 function seleziona_citta(){
  DBSelect("SELECT * FROM citta ORDER BY nomecitta ASC",$rs);
  $V="";
  $V="<select class=select name=\"CITY\" size=1>";
  while (NextRecord($rs,$r)) {
   $V.="<option value=\"".$r['id_citta']."\">".$r['nomecitta']."</option>";
  }
  $V.="</select>";
  return $V;
 }

 function sel_data_gg(){
  $V="";
  $V="<select class=select name=\"GG\" size=1>";
  for ($C=1; $C<=31; $C++) {
   $V.="<option value=\"$C\">$C</option>";
  }
  $V.="</select>";
  return $V;
 }

 function sel_data_mm(){
  $V="";
  $V="<select class=select name=\"MM\" size=1>";
  for ($C=1; $C<=12; $C++) {
   $V.="<option value=\"$C\">$C</option>";
  }
  $V.="</select>";
  return $V;
 }

 function sel_data_aa(){
  $V="";
  $V="<select class=select name=\"AA\" size=1>";
  for ($C=2008; $C<=2012; $C++) {
   $V.="<option value=\"$C\">$C</option>";
  }
  $V.="</select>";
  return $V;
 }

 function sel_ora_hh(){
  $V="";
  $V="<select class=select name=\"OH\" size=1>";
  for ($C=1; $C<=24; $C++) {
   $V.="<option value=\"$C\">$C</option>";
  }
  $V.="</select>";
  return $V;
 }

 function sel_ora_mm(){
  $V="";
  $V="<select class=select name=\"OM\" size=1>";
  for ($C=0; $C<=60; $C+=5) {
   $V.="<option value=\"$C\">$C</option>";
  }
  $V.="</select>";
  return $V;
 }

?>