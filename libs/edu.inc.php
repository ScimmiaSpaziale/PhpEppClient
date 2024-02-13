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
  DoQuery("INSERT INTO domain_contacts_edu VALUES ($IDC,'$ISO','$TYP','$REGC','$SCHOOLCODE')");
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
   SELECT * FROM domain_contacts_edu WHERE idc=$IDC
  ");
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

 functino is_compiled_edu_contact($ISO,$TYP,$REGC,$SCHOOLCODE) {
  $compiled=TRUE;
  if ($ISO!="IT") $compiled=FALSE;
  if ((($TYP!=2) && ($TYP!=4)) && ($TYP!=5))) $compiled=FALSE;
  if ($REGC=="") $compiled=FALSE;
  if ($SCHOOLCODE=="") $compiled=FALSE;
  return $compiled;
 }

 function is_edu_contact($IDC) {
  DoSelect("
   SELECT * FROM domain_contacts_edu WHERE idc=$IDC
  ");
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

?>