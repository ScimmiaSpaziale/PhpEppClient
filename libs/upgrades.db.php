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
 # Funzioni aggiornate 14/02/2010
 #################################

 function check_upgrades(){
  $ID_ADM=1;
  DbSelect("SELECT * FROM admin_eppconfig WHERE ida=$ID_ADM",$rs);
  if (NextRecord($rs,$r)) {
   $V=$r['client_version'];
   if ($V=="1.0") {
    DbQuery("ALTER TABLE `epp_polling` ADD `xmldeq` TEXT NOT NULL, ADD `domain` CHAR(255) NOT NULL");
    DbQuery("ALTER TABLE `epp_polling` ADD `opcode` INT(2) UNSIGNED NOT NULL DEFAULT '0'");
    DbQuery("UPDATE admin_eppconfig SET client_version='1.1'");
    $V="1.1";
   }
   if ($V=="1.1") {
    DbQuery("
     ALTER TABLE `servers_epp` CHANGE `proto` `proto` SET( 'EPPoTCP', 'EPPoHTTP', 'EPPoSMTP', 'EPPoTCPv2' )
      NOT NULL DEFAULT 'EPPoTCP'
    ");
    DbQuery("UPDATE admin_eppconfig SET client_version='1.2'");
    $V="1.2";
   }
   if ($V=="1.2") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.3'");
    $V="1.3";
   }
   if ($V=="1.3") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.4'");
    $V="1.4";
   }
   if ($V=="1.4") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.4.1'");
    $V="1.4.1";
   }
   if ($V=="1.4.1") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.5'");
    $V="1.5";
   }
   if ($V=="1.5") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.5.1'");
    $V="1.5.1";
   }
   if ($V=="1.5.1") {
    DbQuery("
     ALTER TABLE `servers_epp` CHANGE `proto` `proto` 
      SET( 'EPPoTCP', 'EPPoHTTP', 'EPPoSMTP', 'EPPoTCPv2', 'EPPoCURL' ) 
       NOT NULL DEFAULT 'EPPoTCP'
    ");
    DbQuery("
     ALTER TABLE `admin_eppconfig` 
      ADD `ns3` CHAR(255) NOT NULL AFTER `ip2`, ADD `ip3` CHAR(36) NOT NULL AFTER `ns3`,
      ADD `ns4` CHAR(255) NOT NULL AFTER `ip3`, ADD `ip4` CHAR(36) NOT NULL AFTER `ns4`,
      ADD `ns5` CHAR(255) NOT NULL AFTER `ip4`, ADD `ip5` CHAR(36) NOT NULL AFTER `ns5`;
    ");
    DbQuery("ALTER TABLE `domain_names` ADD `ida` INT(4) UNSIGNED NOT NULL");
    DbQuery("ALTER TABLE `domain_contacts` ADD `ida` INT(4) UNSIGNED NOT NULL");
    DbQuery("ALTER TABLE `servers_dns` ADD `ida` INT(4) UNSIGNED NOT NULL");
    DbQuery("UPDATE domain_names SET ida=1");
    DbQuery("UPDATE domain_contacts SET ida=1");
    DbQuery("UPDATE servers_dns SET ida=1");
    DbQuery("ALTER TABLE `admin_users` CHANGE `ida` `ida` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT");
    DbQuery("ALTER TABLE `admin_eppconfig` CHANGE `ida` `ida` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT");
    DbQuery("UPDATE admin_eppconfig SET client_version='1.6'");
    $V="1.6";
   }
   if ($V=="1.6") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.7'");
    $V="1.7";
   }
   if ($V=="1.7") {
    DbQuery("
     CREATE TABLE IF NOT EXISTS `dotit_legalinfo` ( 
      `idlegal` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `idgroup` INT( 4 ) UNSIGNED NOT NULL ,
      `header` CHAR( 255 ) NOT NULL ,
      `description` TEXT NOT NULL 
     )
    ");
    DbQuery("
     CREATE TABLE IF NOT EXISTS `dotit_logsigns` ( 
      `idlog` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `idlegal` INT( 4 ) UNSIGNED NOT NULL ,
      `registrant_id` CHAR( 20 ) NOT NULL ,
      `domain` CHAR( 255 ) NOT NULL ,
      `signature_time` CHAR( 120 ) NOT NULL ,
      `signature_ip` CHAR( 32 ) NOT NULL 
     )
    ");
    DbQuery("UPDATE admin_eppconfig SET client_version='1.8'");
    $V="1.8";
   }
   if ($V=="1.8") {
    DbQuery("UPDATE admin_eppconfig SET client_version='1.9'");
    $V="1.9";
   }
   if ($V=="1.9") {
    DbQuery("UPDATE admin_eppconfig SET client_version='2.0'");
    $V="2.0";
   }
   if ($V=="2.0") {
    DbQuery("UPDATE client_countries SET isocode='IE' WHERE idcountry=11");
    DbQuery("ALTER TABLE `domain_names` CHANGE `name` `name` CHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
    DbQuery("UPDATE admin_eppconfig SET client_version='2.1'");
    $V="2.1";
   }
   if ($V=="2.1") {
    DbQuery("ALTER TABLE `client_countries` ADD `country_area` CHAR(32) NOT NULL");
    DbQuery("UPDATE `client_countries` SET country_area='Unione Europea'");
    DbQuery("UPDATE admin_eppconfig SET client_version='2.2'");
    $V="2.2";
   }
   if ($V=="2.2") {
    DbQuery("UPDATE epp_polling SET opcode=2500 WHERE opcode=0");
    DbQuery("UPDATE admin_eppconfig SET client_version='2.3'");
    $V="2.3";
   }
   if ($V=="2.3") {
    DbQuery("CREATE TABLE `epp_queue_ns` (`idd` INT(4) UNSIGNED NOT NULL, `idstatus` INT(1) UNSIGNED NOT NULL)");
    DbQuery("UPDATE admin_eppconfig SET client_version='2.4'");
    $V="2.4";
   }
   if ($V=="2.4") {
    @DoQuery("
     CREATE TABLE IF NOT EXISTS domain_contacts_edu (
      `idc` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `nationalitycode` CHAR( 2 ) NOT NULL ,
      `entitytype` INT( 1 ) UNSIGNED NOT NULL ,
      `regcode` CHAR( 32 ) NOT NULL ,
      `schoolcode` CHAR( 32 ) NOT NULL
     ) 
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.5'");
    $V="2.5";
   }
   if ($V=="2.5") {
    @DoQuery("
     CREATE TABLE IF NOT EXISTS domain_contacts_edu (
      `idc` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `nationalitycode` CHAR( 2 ) NOT NULL ,
      `entitytype` INT( 1 ) UNSIGNED NOT NULL ,
      `regcode` CHAR( 32 ) NOT NULL ,
      `schoolcode` CHAR( 32 ) NOT NULL
     )
    ");
    @DbQuery("
     ALTER TABLE domain_contacts_edu CHANGE `schoolCode` `schoolcode` CHAR( 32 )
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.5'");
    $V="2.6";
   }
   if ($V=="2.6") {
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6'");
    @DbQuery("DELETE FROM client_countries WHERE (idcountry>=28) AND (idcountry<=31)");
    @DbQuery("INSERT INTO client_countries (`idcountry`, `idlang`, `country`, `isocode`, `telprefix`, `country_area`) VALUES ('28', '1', 'Svizzera', 'CH', '+41', 'Area CEE')");
    @DbQuery("INSERT INTO client_countries (`idcountry`, `idlang`, `country`, `isocode`, `telprefix`, `country_area`) VALUES ('29', '1', 'San Marino', 'SM', '+378', 'Area CEE')");
    @DbQuery("INSERT INTO client_countries (`idcountry`, `idlang`, `country`, `isocode`, `telprefix`, `country_area`) VALUES ('30', '1', 'Città del Vaticano', 'VA', '+379', 'Area CEE')");
    @DbQuery("INSERT INTO client_countries (`idcountry`, `idlang`, `country`, `isocode`, `telprefix`, `country_area`) VALUES ('31', '1', 'Norvegia', 'NO', '+47', 'Area CEE')");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.1'");
    $V="2.6.1";
   }
   if ($V=="2.6.1") {
    @DbQuery("ALTER TABLE `admin_users` ADD `idd` INT( 4 ) UNSIGNED NOT NULL AFTER `email` , ADD `crd` FLOAT( 5 ) NOT NULL AFTER `idd`");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.2'");
    $V="2.6.2";
   }
   if ($V=="2.6.2") {
    @DoQuery("
     CREATE TABLE IF NOT EXISTS `admin_eppresellerlogs` (
      `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
      `ida` int(4) unsigned NOT NULL,
      `crd` float NOT NULL,
      `description` char(255) NOT NULL,
      PRIMARY KEY (`id`)
     ) AUTO_INCREMENT=1 ;
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.3'");
    $V="2.6.3";
   }
   if ($V=="2.6.3") {
    @DoQuery("
     CREATE TABLE IF NOT EXISTS `admin_cfgcredits` (
      `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
      `crd_new` float NOT NULL,
      `crd_transfer` float NOT NULL,
      `crd_restore` float NOT NULL,
      `crd_renew` float NOT NULL,
      PRIMARY KEY (`id`)
     ) AUTO_INCREMENT=1 ;
    ");
    @DBQuery("
     INSERT INTO `admin_cfgcredits` (`id`, `crd_new`, `crd_transfer`, `crd_restore`, `crd_renew`) VALUES ('1', '1', '1', '1', '1')
    ");
    @DBQuery("
     ALTER TABLE `admin_users` ADD `used_crd` FLOAT( 5 ) NOT NULL AFTER `crd`
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.4'");
    $V="2.6.4";
   }
   if ($V=="2.6.4") {
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.5'");
    $V="2.6.5";
   }

   if ($V=="2.6.5") {
    @DBQuery("
     ALTER TABLE `admin_eppresellerlogs` ADD `t_added` INT( 4 ) UNSIGNED NOT NULL AFTER `id`
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.6'");
    $V="2.6.6";
   }

   if ($V=="2.6.6") {
    @DBQuery("
     CREATE TABLE IF NOT EXISTS `epp_queue_ns` (
      `idd` int(4) unsigned NOT NULL,
      `idstatus` int(1) unsigned NOT NULL
     ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    ");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.7'");
    $V="2.6.7";
   }

   if ($V=="2.6.7") {
    @DbQuery("UPDATE client_contactstype SET `desc` = 'Società o Impresa' WHERE (idct=2) AND (idlang=1)");
    @DbQuery("UPDATE client_contactstype SET `desc` = 'Libero professionista o Ditta individuale' WHERE (idct=3) AND (idlang=1)");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.8'");
    $V="2.6.8";
   }

   if ($V=="2.6.8") {
    @DbQuery("UPDATE client_contactstype SET `desc` = 'Società o Impresa' WHERE (idct=2) AND (idlang=1)");
    @DbQuery("UPDATE client_contactstype SET `desc` = 'Libero professionista o Ditta individuale' WHERE (idct=3) AND (idlang=1)");
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.6.9'");
    $V="2.6.9";
   }

   if ($V=="2.6.9") {
    @DbQuery("UPDATE admin_eppconfig SET client_version='2.7.0'");
    $V="2.7.0";
   }

   if ($V=="2.7.0") {
    $V="2.7.0";
   }
  }
 }
?>