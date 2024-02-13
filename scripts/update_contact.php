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
 ConnectDB();
  session_start();
  $ID_UTENTE=admin_protection();

  $IDC=validate_unsigned($_GET[id]);
  $NAME=validate_string($_POST['name']);
  $SURNAME=validate_string($_POST['surname']);
  $SEX=validate_string($_POST['usersex']);
  $COMPANY=validate_string($_POST['company']);
  $ADDRESS=validate_string($_POST['address']);
  $CITY=validate_string($_POST['city']);
  $PROV=validate_string($_POST['province']);
  $ZIP=validate_string($_POST['zipcode']);
  $COUNTRY=validate_string($_POST['country']);
  $NAT=validate_string($_POST['nationality']);
  $TC=validate_string($_POST['usertype']);
  $TCID=validate_string($_POST['cidtype']);
  $CF=validate_string($_POST['fiscalcode']);
  $VAT=validate_string($_POST['vatcode']);
  $TELPREFIX=validate_string($_POST['telprefix']);
  $FAXPREFIX=validate_string($_POST['faxprefix']);
  $TEL=validate_string($_POST['tel']);
  $FAX=validate_string($_POST['fax']);
  $EMAIL=validate_string($_POST['email']);
  $PUB=validate_string($_POST['pubblish']);

  $ISO=$NAT;
  $TYP=validate_string($_POST['status']);
  $REGC=validate_string($_POST['schoolcf']);
  $SCHOOLCODE=validate_string($_POST['schoolcode']);

  update_contact($IDC,$NAME,$SURNAME,$COMPANY,$ADDRESS,$ZIP,$CITY,$PROV,$COUNTRY,$NAT,$TC,$TCID,$CF,$VAT,$TEL,$FAX,$EMAIL,$PUB,$SEX);

  upd_edu_extcon_xml($IDC,$ISO,$TYP,$REGC,$SCHOOLCODE);

 DisconnectDB();
 header("location: ../admin_utenti.php");
?>