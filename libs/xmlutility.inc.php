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

 #################################
 # Funzioni aggiornate 23/10/2010
 #################################

 function escape_special_chars($VAL){
  $VAL=str_replace("<","&lt;",$VAL);
  $VAL=str_replace(">","&gt;",$VAL);
  $VAL=str_replace("&","&amp;",$VAL);
  $VAL=str_replace("'","&apos;",$VAL);
  $VAL=str_replace("\"","&quot;",$VAL);
  return $VAL;
 }

 function xml_check_domain_lockstatus($xml){
  global $LANGUAGE;
  $STATUS=xml_get_value_domain_status($XML);
  return $STATUS;
 }

 #################################
 # Funzioni aggiornate 14/02/2010
 #################################

 function xml_update_contact_info($IDC,$XML){
  $NAME=addslashes(xml_get_value($XML,"contact:name"));
  $ROID=xml_get_value($XML,"contact:roid");
  $ORG=addslashes(xml_get_value($XML,"contact:org"));
  $ADDR=addslashes(xml_get_value($XML,"contact:street"));
  $CITY=addslashes(xml_get_value($XML,"contact:city"));
  $PROV=xml_get_value($XML,"contact:sp");
  $ZIPCODE=xml_get_value($XML,"contact:pc");
  $COUNTRY=xml_get_value($XML,"contact:cc");
  $TEL=xml_get_value_opentag($XML,"contact:voice");
  $FAX=xml_get_value_opentag($XML,"contact:fax");
  $EMAIL=xml_get_value($XML,"contact:email");
  $PUB=xml_get_value($XML,"extcon:consentForPublishing");
  $NAT=xml_get_value($XML,"extcon:nationalityCode");
  $UTYPE=xml_get_value($XML,"extcon:entityType");
  $CF=xml_get_value($XML,"extcon:regCode");
  $CRDATE=xml_get_value($XML,"contact:crDate");
  $UPDATE=xml_get_value($XML,"contact:upDate");
  if ($UPDATE=="") $UPDATE=$CRDATE;
  $REG=xml_get_value($XML,"contact:clID");
  $REG2=xml_get_value($XML,"contact:crID");
  $STATUS=xml_get_value_contact_status($XML);

  list($N,$S)=explode(" ",$NAME,2);

  DBSelect("SELECT * FROM domain_contacts WHERE idc=$IDC",$rs);
  if (NextRecord($rs,$r)) {
   $CTYPE=$r['cidtype'];
  } else {
   $CTYPE="R";
  }
  if ($CTYPE=="R") $ST="Active";
   else $ST="AdminActive";

  if ($PUB=="true") $PUB="True";
   else $PUB="False";

  if (!is_numeric($UTYPE)) $UTYPE=0;
  DBQuery("
   UPDATE domain_contacts SET
   name='$N',
   surname='$S',
   company='$ORG',
   address='$ADDR',
   city='$CITY',
   zipcode='$ZIPCODE',
   province='$PROV',
   country='$COUNTRY',
   nationality='$NAT',
   usertype='$UTYPE',
   vatcode='$CF',
   fiscalcode='$CF',
   tel='$TEL',
   fax='$FAX',
   email='$EMAIL',
   pubblish='$PUB',
   status='$ST'
   WHERE idc=$IDC
  "); 
 }

 #################################
 # Funzioni aggiornate 12/02/2010
 #################################

 function xml_update_domain_info($IDD,$XML){
  $ROID=xml_get_value($XML,"domain:roid");
  $IDREG=xml_get_value($XML,"domain:registrant");
  $CRDATE=xml_get_value($XML,"domain:crDate");
  $UPDATE=xml_get_value($XML,"domain:upDate");
  $EXDATE=xml_get_value($XML,"domain:exDate");
  $NEXT_POS=0;
  $IDADM=xml_get_value_adminID($XML,$NEXT_POS);
  $IDTECH=xml_get_value_techID($XML,$NEXT_POS);
  $NEXT_POS=0;
  $NS1=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS2=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS3=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS4=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS5=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $IP1="";
  $IP2="";
  $IP3="";
  $IP4="";
  $IP5="";
  $PW=xml_get_value($XML,"domain:pw");
  $PW=crypt_webpanel_string($PW);
  $REG=xml_get_value($XML,"domain:clID");
  $REG2=xml_get_value($XML,"domain:crID");
  $STATUS=xml_get_value_domain_status($XML);

  if ($STATUS=="inactive") $IDSTATUS=15;
   else if ($STATUS=="ok") $IDSTATUS=1;
    else $IDSTATUS=0;

  $INTCRDATE=strtotime($CRDATE);
  $INTUPDATE=strtotime($UPDATE);
  $INTEXDATE=strtotime($EXDATE);
 
  if (!is_numeric($INTUPDATE)) $INTUPDATE=$INTCRDATE;

  $PW=addslashes($PW);

  DBQuery("
   UPDATE domain_names SET
    created=$INTCRDATE,
    updated=$INTUPDATE,
    expire=$INTEXDATE,
    eppcode='$PW',
    status=$IDSTATUS,
    idregistrant='$IDREG',
    idadmin='$IDADM',
    idtech='$IDTECH',
    idbill='$IDTECH'
   WHERE idd=$IDD
  ");

  import_domain_contact($IDREG,"R");
  import_domain_contact($IDADM,"A");
  import_domain_contact($IDTECH,"T");

  add_domain_dns($IDD,$NS1,$NS2,$NS3,$NS4,$NS5,$NS6,$IP1,$IP2,$IP3,$IP4,$IP5,$IP6);
 }

 #################################
 # Funzioni aggiornate 04/10/2010
 #################################

 function xml_get_domain_info_ns($XML,&$NS1,&$NS2,&$NS3,&$NS4,&$NS5,&$NS6){
  $ROID=xml_get_value($XML,"domain:roid");
  $IDREG=xml_get_value($XML,"domain:registrant");
  $CRDATE=xml_get_value($XML,"domain:crDate");
  $UPDATE=xml_get_value($XML,"domain:upDate");
  $EXDATE=xml_get_value($XML,"domain:exDate");
  $NEXT_POS=0;
  $IDADM=xml_get_value_adminID($XML,$NEXT_POS);
  $IDTECH=xml_get_value_techID($XML,$NEXT_POS);
  $NEXT_POS=0;
  $ERD_END=0;
  xml_get_value_nextpos($XML,"resData",$ERD_END);
  xml_get_value_nextpos($XML,"resData",$ERD_END);
  $NS1=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS1="";
  $NS2=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS2="";
  $NS3=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS3="";
  $NS4=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS4="";
  $NS5=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS5="";
  $NS6=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  if ($NEXT_POS>$ERD_END) $NS6="";
  $PW=xml_get_value($XML,"domain:pw");
  $REG=xml_get_value($XML,"domain:clID");
  $REG2=xml_get_value($XML,"domain:crID");
  $STATUS=xml_get_value_domain_status($XML);
 }

 function xml_print_domain_info($XML){
  global $LANGUAGE;
  $ROID=xml_get_value($XML,"domain:roid");
  $IDREG=xml_get_value($XML,"domain:registrant");
  $CRDATE=xml_get_value($XML,"domain:crDate");
  $UPDATE=xml_get_value($XML,"domain:upDate");
  $EXDATE=xml_get_value($XML,"domain:exDate");
  $NEXT_POS=0;
  $IDADM=xml_get_value_adminID($XML,$NEXT_POS);
  $IDTECH=xml_get_value_techID($XML,$NEXT_POS);
  $NEXT_POS=0;
  $NS1=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS2=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS3=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS4=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $NS5=xml_get_value_nextpos($XML,"domain:hostName",$NEXT_POS);
  $PW=xml_get_value($XML,"domain:pw");
  $REG=xml_get_value($XML,"domain:clID");
  $REG2=xml_get_value($XML,"domain:crID");
  $STATUS=xml_get_value_domain_status($XML);
  $PW=mask_password($PW);
  echo "
   <table width=480>
    <tr><td width=40%><b>$LANGUAGE[345]</b></td><td width=60%>$ROID</td></tr>
    <tr><td width=40%><b>$LANGUAGE[346]</b></td><td width=60%>$REG</td></tr>
    <tr><td width=40%><b>$LANGUAGE[347]</b></td><td width=60%>$REG2</td></tr>
    <tr><td width=40%><b>$LANGUAGE[348]</b></td><td width=60%>$STATUS</td></tr>
    <tr><td width=40%><b>$LANGUAGE[349]</b></td><td width=60%>$IDREG</td></tr>
    <tr><td width=40%><b>$LANGUAGE[350]</b></td><td width=60%>$IDADM</td></tr>
    <tr><td width=40%><b>$LANGUAGE[350]</b></td><td width=60%>$IDTECH</td></tr>
    <tr><td width=40%><b>$LANGUAGE[351]</b></td><td width=60%>$CRDATE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[352]</b></td><td width=60%>$UPDATE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[353]</b></td><td width=60%>$EXDATE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[354]</b></td><td width=60%>$NS1</td></tr>
    <tr><td width=40%><b>$LANGUAGE[355]</b></td><td width=60%>$NS2</td></tr>
    <tr><td width=40%><b>$LANGUAGE[541]</b></td><td width=60%>$NS3</td></tr>
    <tr><td width=40%><b>$LANGUAGE[542]</b></td><td width=60%>$NS4</td></tr>
    <tr><td width=40%><b>$LANGUAGE[543]</b></td><td width=60%>$NS5</td></tr>
    <tr><td width=40%><b>$LANGUAGE[356]</b></td><td width=60%>$PW</td></tr>
   </table>
  ";
 }

 function xml_get_var_status($STR){
  $S=strpos($STR,"s=");
  $L=strlen($S);
  $S=$S+3;
  $STR=substr($STR,$S,$L-$S);
  $S=strpos($STR,"\"");
  $STR=substr($STR,0,$S);
  return $STR;
 }

 function xml_get_value_domain_status($XML){
  $TAG="domain:status";
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($XML," />");
   $S=$S+1+strlen($TAG);
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
   $VALUE=xml_get_var_status($VALUE);
  }
  return $VALUE;
 }

 function xml_get_value_contact_status($XML){
  $TAG="contact:status";
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($XML," />");
   $S=$S+1+strlen($TAG);
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
   $VALUE=xml_get_var_status($VALUE);
  }
  return $VALUE;
 }

 function xml_print_contact_info($XML){
  global $LANGUAGE;
  $NAME=xml_get_value($XML,"contact:name");
  $ROID=xml_get_value($XML,"contact:roid");
  $ORG=xml_get_value($XML,"contact:org");
  $ADDR=xml_get_value($XML,"contact:street");
  $CITY=xml_get_value($XML,"contact:city");
  $PROV=xml_get_value($XML,"contact:sp");
  $ZIPCODE=xml_get_value($XML,"contact:pc");
  $COUNTRY=xml_get_value($XML,"contact:cc");
  $TEL=xml_get_value_opentag($XML,"contact:voice");
  $FAX=xml_get_value_opentag($XML,"contact:fax");
  $EMAIL=xml_get_value($XML,"contact:email");
  $PUB=xml_get_value($XML,"extcon:consentForPublishing");
  $NAT=xml_get_value($XML,"extcon:nationalityCode");
  $UTYPE=xml_get_value($XML,"extcon:entityType");
  $CF=xml_get_value($XML,"extcon:regCode");
  $CRDATE=xml_get_value($XML,"contact:crDate");
  $UPDATE=xml_get_value($XML,"contact:upDate");
  if ($UPDATE=="") $UPDATE=$CRDATE;
  $REG=xml_get_value($XML,"contact:clID");
  $REG2=xml_get_value($XML,"contact:crID");
  $STATUS=xml_get_value_contact_status($XML);
  echo "
   <table width=480>
    <tr><td width=40%><b>$LANGUAGE[345]</b></td><td width=60%>$ROID</td></tr>
    <tr><td width=40%><b>$LANGUAGE[346]</b></td><td width=60%>$REG</td></tr>
    <tr><td width=40%><b>$LANGUAGE[347]</b></td><td width=60%>$REG2</td></tr>
    <tr><td width=40%><b>$LANGUAGE[357]</b></td><td width=60%>$NAME</td></tr>
    <tr><td width=40%><b>$LANGUAGE[358]</b></td><td width=60%>$ORG</td></tr>
    <tr><td width=40%><b>$LANGUAGE[359]</b></td><td width=60%>$ADDR</td></tr>
    <tr><td width=40%><b>$LANGUAGE[360]</b></td><td width=60%>$CITY</td></tr>
    <tr><td width=40%><b>$LANGUAGE[361]</b></td><td width=60%>$PROV</td></tr>
    <tr><td width=40%><b>$LANGUAGE[362]</b></td><td width=60%>$ZIPCODE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[363]</b></td><td width=60%>$COUNTRY</td></tr>
    <tr><td width=40%><b>$LANGUAGE[364]</b></td><td width=60%>$TEL</td></tr>
    <tr><td width=40%><b>$LANGUAGE[365]</b></td><td width=60%>$FAX</td></tr>
    <tr><td width=40%><b>$LANGUAGE[366]</b></td><td width=60%>$EMAIL</td></tr>
    <tr><td width=40%><b>$LANGUAGE[367]</b></td><td width=60%>$NAT</td></tr>
    <tr><td width=40%><b>$LANGUAGE[368]</b></td><td width=60%>$UTYPE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[369]</b></td><td width=60%>$CF</td></tr>
    <tr><td width=40%><b>$LANGUAGE[370]</b></td><td width=60%>$PUB</td></tr>
    <tr><td width=40%><b>$LANGUAGE[371]</b></td><td width=60%>$CRDATE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[372]</b></td><td width=60%>$UPDATE</td></tr>
    <tr><td width=40%><b>$LANGUAGE[373]</b></td><td width=60%>$STATUS</td></tr>
   </table>
  ";
 }

 #################################
 # Funzioni aggiornate 06/11/2009
 #################################

 function xml_domain_get_eppcode($XML){
  $EPPCODE=xml_get_value($XML,"domain:pw");
  return $EPPCODE;
 } 

 function xml_domain_polling_msg($XML,&$QT,&$IDMSG,&$DATA,&$MSG,&$DOMAIN){
  $DOMAIN=xml_get_value($XML,"extdom:domain");
  if ($DOMAIN=="") $DOMAIN=xml_get_value($XML,"extdom:name");
  if ($DOMAIN=="") $DOMAIN=xml_get_value($XML,"domain:name");
  if ($DOMAIN=="") $DOMAIN=xml_get_value_opentag_domain($XML,"extdom:name");

  $S=strpos($XML,"<msgQ");
  $E=strpos($XML,"</msgQ>");
  $NEWSTR=substr($XML,$S,$E-$S+7);
  $E=strpos($NEWSTR,"</msgQ>");

  $S=strpos($NEWSTR,"count=");
  $S=$S+strlen("count=")+1;
  $CODE="";
  $CNT=0;
  $CH="";
  
  while (($CH!="\"")&&(($S+$CNT)<=$E)) {
   $CH=substr($NEWSTR,$S+$CNT,1);
   if ($CH!="\"") $CODE=$CODE.$CH; 
   $CNT++;
  }
  $QT=$CODE;
  $CH="";

  $S=strpos($NEWSTR,"id=");
  $S=$S+strlen("id=")+1;
  $CODE="";
  $CNT=0;
  while (($CH!="\"")&&(($S+$CNT)<=$E)) {
   $CH=substr($NEWSTR,$S+$CNT,1);
   if ($CH!="\"") $CODE=$CODE.$CH; 
   $CNT++;
  }
  $IDMSG=$CODE;

  $DATA=xml_get_value($NEWSTR,"qDate");
  $MSG=xml_get_value_opentag($NEWSTR,"msg");
 }

 function xml_domain_get_available($XML){
  $CID=xml_get_value($XML,"domain:name avail=\"true\"");
  return $CID;
 }

 function xml_domain_availability($XML){
  $S=strpos($XML,"<domain:name avail=");
  $S=$S+strlen("<domain:name avail=")+1;
  $CODE="";
  $CNT=0;
  $CH="";
  while (($CH!="\"")&&($CNT<=8)) {
   $CH=substr($XML,$S+$CNT,1);
   if ($CH!="\"") $CODE=$CODE.$CH; 
   $CNT++;
  }
  return $CODE;
 }

 function xml_domain_no_availability_reason($XML){
  $MSG=xml_get_value_opentag($XML,"domain:reason");
  return $MSG;
 }

 function xml_extract_textline(&$pos,$txt){
  $e="";
  $ch="";
  $l=strlen($txt);
  while (($ch!=chr(13))&&($pos<=$l)){
   $ch=substr($txt,$pos,1);
   $e.=$ch;
   $pos++;
  }
  return trim($e);
 }

 function xml_domain_availability_list($XML,&$DOMLIST,&$DOMAVAILABLE,&$NDOMS){
  $START_DOMLIST_TAG=strpos($XML,"<domain:chkData");
  $END_DOMLIST_TAG="</domain:chkData>";
  if ($START_DOMLIST_TAG>0) {
   $L=xml_extract_textline($START_DOMLIST_TAG,$XML);
   $NDOMS=0;
   while ($L!=$END_DOMLIST_TAG) {
    $L=xml_extract_textline($P,$XML);
    if ($L=="<domain:cd>") {
     $NDOMS++;
     $L=xml_extract_textline($P,$XML);
     $DM=strip_tags($L);
     $DOMLIST[$NDOMS]=$DM;
     $AVAIL=xml_domain_availability($L);
     $DOMAVAILABLE[$NDOMS]=$AVAIL;
    } 
   }
  }
 }

 #################################
 # Funzioni aggiornate 10/06/2009
 #################################

 function xml_contact_get_available($XML){
  $CID=xml_get_value($XML,"contact:id avail=\"true\"");
  return $CID;
 }

 function xml_contact_availability($XML){
  $S=strpos($XML,"<contact:id avail=");
  $S=$S+strlen("<contact:id avail=")+1;
  $CODE="";
  $CNT=0;
  $CH="";
  while (($CH!="\"")&&($CNT<=8)) {
   $CH=substr($XML,$S+$CNT,1);
   if ($CH!="\"") $CODE=$CODE.$CH; 
   $CNT++;
  }
  return $CODE;
 }

 function xml_set_variable(&$XML,$VAR,$VALUE){
  $XML=str_replace("$VAR","$VALUE",$XML);
 }

 function xml_get_credit($XML){
  $CRD=xml_get_value($XML,"extepp:credit");
  return $CRD;
 }

 function xml_get_value_adminID($XML,&$START_POS){
  $L=strlen($XML);
  $ST=$START_POS;
  $XML=substr($XML,$ST,$L-$ST);
  $TAG="domain:contact";
  $TYPE="admin";
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $VALUE="";
   $E=strpos($XML,"</$TAG>");
   $LTAG=$E-$S;
   $SUBXML=substr($XML,$S,$LTAG);
   $LTAGFULL=$LTAG+strlen("</$TAG>");
   $START_POS=$START_POS+$S+$LTAGFULL;
   if (in_str($SUBXML,$TYPE)) {
    $C=0;
    while (($CH!=">")&&($C<($S+$E))) {
     $C++;
     $CH=substr($XML,$S+$C,1);
    } 
    $S=$S+$C+1;
    $n=$E-$S;
    $VALUE=substr($XML,$S,$n);
   } 
  }
  return $VALUE;
 }

 function xml_get_value_techID($XML,&$START_POS){
  $L=strlen($XML);
  $ST=$START_POS;
  $XML=substr($XML,$ST,$L-$ST);
  $TAG="domain:contact";
  $TYPE="tech";
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $VALUE="";
   $E=strpos($XML,"</$TAG>");
   $LTAG=$E-$S;
   $SUBXML=substr($XML,$S,$LTAG);
   $LTAGFULL=$LTAG+strlen("</$TAG>");
   $START_POS=$START_POS+$S+$LTAGFULL;
   if (in_str($SUBXML,$TYPE)) {
    $C=0;
    while (($CH!=">")&&($C<($S+$E))) {
     $C++;
     $CH=substr($XML,$S+$C,1);
    } 
    $S=$S+$C+1;
    $n=$E-$S;
    $VALUE=substr($XML,$S,$n);
   } 
  }
  return $VALUE;
 }

 function xml_get_value_opentag($XML,$TAG){
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($XML,"</$TAG>");
   $C=0;
   $CH=""; 
   while (($CH!=">")&&($C<($S+$E))) {
    $C++;
    $CH=substr($XML,$S+$C,1);
   } 
   $S=$S+$C+1;
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
  }
  return $VALUE;
 }

 function xml_get_value_opentag_domain($XML,$TAG){
  $S=strpos($XML,"<$TAG ");
  if ($S===false) {
   $VALUE="";
  } else {
   $L=strlen($XML);
   $V=substr($XML,$S+1,$L-1);
   $E=strpos($V,">");
   $V=substr($V,0,$E-1);
   $S=strpos($V,"name=");
   if ($S===false) {
    $VALUE="";
   } else {
    $L=strlen($V);
    $S=$S+5;
    $V=substr($V,$S+1,$L-$S);
    $E=strpos($V," ");
    $V=substr($V,0,$E-2);
    $VALUE=$V;
    return $VALUE;
   }
  }
  return $VALUE;
 }

 function xml_get_value_nextpos($XML,$TAG,&$START_POS){
  $L=strlen($XML);
  $ST=$START_POS;
  $SUBXML=substr($XML,$ST,$L-$ST);
  $S=strpos($SUBXML,"<$TAG>");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($SUBXML,"</$TAG>");
   $S=$S+strlen("<$TAG>");
   $n=$E-$S;
   $VALUE=substr($SUBXML,$S,$n);
   $TAGLEN=strlen($TAG)+1;
   $START_POS=$ST+$E+$TAGLEN;
  }
  return $VALUE;
 }

 function xml_get_value($XML,$TAG){
  $S=strpos($XML,"<$TAG>");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($XML,"</$TAG>");
   $S=$S+strlen("<$TAG>");
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
  }
  return $VALUE;
 }

 function xml_get_resultcode($XML){
  $S=strpos($XML,"<result code=");
  $S=$S+strlen("<result code=")+1;
  $CODE="";
  $CH="";
  $CNT=0;
  while (($CH!="\"")&&($CNT<=8)) {
   $CH=substr($XML,$S+$CNT,1);
   if ($CH!="\"") $CODE=$CODE.$CH; 
   $CNT++;
  }
  return $CODE;
 }

 function xml_get_reasoncode_old($XML){
  $TAG1="<reasonCode xmlns=\"\">";
  $S=strpos($XML,"$TAG1");
  if ($S===false) {
   $VALUE="";
  } else {
   $TAG2="</reasonCode>";
   $E=strpos($XML,"$TAG2");
   $S=$S+strlen("$TAG1");
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
  }
  return $VALUE;
 }

 function xml_get_reasoncode($XML){
  $TAG="extepp:reasonCode";
  $S=strpos($XML,"<$TAG>");
  if ($S===false) {
   $VALUE="";
  } else {
   $E=strpos($XML,"</$TAG>");
   $S=$S+strlen("<$TAG>");
   $n=$E-$S;
   $VALUE=substr($XML,$S,$n);
  }
  return $VALUE;
 }
?>