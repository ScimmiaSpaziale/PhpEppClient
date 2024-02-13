
CREATE TABLE `admin_eppconfig` (
  `ida` int(1) unsigned NOT NULL,
  `debug` set('True','False') NOT NULL,
  `exam` set('True','False') NOT NULL,
  `eppcredit` float NOT NULL,
  `ns1` char(255) NOT NULL,
  `ip1` char(36) NOT NULL,
  `ns2` char(255) NOT NULL,
  `ip2` char(36) NOT NULL,
  `idregistrant` char(32) NOT NULL,
  `idadmin` char(32) NOT NULL,
  `idtech` char(32) NOT NULL,
  `idbill` char(32) NOT NULL,
  `contactid_prefix` char(12) NOT NULL,
  `ides` int(2) unsigned NOT NULL,
  `idds` int(2) unsigned NOT NULL,
  `client_version` char(8) NOT NULL,
  PRIMARY KEY  (`ida`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admin_eppconfig` (`ida`, `debug`, `exam`, `eppcredit`, `ns1`, `ip1`, `ns2`, `ip2`, `idregistrant`, `idadmin`, `idtech`, `idbill`, `contactid_prefix`, `ides`, `idds`, `client_version`) VALUES (1, 'True', 'True', 0, 'ns1.pincopallino.tld', '127.0.0.1', 'ns2.pincopallino.tld', '127.0.0.2', 'XXX0000001', 'XXX0000001', 'XXX0000001', 'XXX0000001', 'XXX', 0, 1, '1.0');

CREATE TABLE `admin_users` (
  `ida` int(1) unsigned NOT NULL,
  `username` char(200) NOT NULL,
  `password` char(200) NOT NULL,
  `idlevel` int(4) unsigned NOT NULL,
  `nome` char(200) NOT NULL,
  `cognome` char(200) NOT NULL,
  `stato` set('Attivo','Disattivato','Bloccato') NOT NULL,
  `email` char(255) NOT NULL,
  PRIMARY KEY  (`ida`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admin_users` (`ida`, `username`, `password`, `idlevel`, `nome`, `cognome`, `stato`, `email`) VALUES (1, 'test', 'test', 1, 'Pinco', 'Pallino', 'Attivo', 'pinco.pallino@infoemail.it');

CREATE TABLE `client_contactstype` (
  `idct` int(1) unsigned NOT NULL,
  `idlang` int(1) unsigned NOT NULL,
  `desc` char(200) NOT NULL,
  PRIMARY KEY  (`idct`,`idlang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `client_contactstype` (`idct`, `idlang`, `desc`) VALUES (1, 1, 'Persona Fisica'),
(2, 1, 'Società o Impresa Individuale'),
(3, 1, 'Libero professionista'),
(4, 1, 'Ente non profit'),
(5, 1, 'Ente pubblico'),
(6, 1, 'Altri soggetti'),
(7, 1, 'Soggetti EU (Escluso Privati)');

CREATE TABLE `client_countries` (
  `idcountry` int(1) unsigned NOT NULL,
  `idlang` int(1) unsigned NOT NULL,
  `country` char(200) NOT NULL,
  `isocode` char(2) NOT NULL,
  `telprefix` char(8) NOT NULL,
  PRIMARY KEY  (`idcountry`,`idlang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `client_countries` (`idcountry`, `idlang`, `country`, `isocode`, `telprefix`) VALUES (1, 1, 'Austria', 'AT', '+43'),
(2, 1, 'Belgio', 'BE', '+32'),
(3, 1, 'Bulgaria', 'BG', '+359'),
(4, 1, 'Cipro', 'CY', '+357'),
(5, 1, 'Danimarca', 'DK', '+45'),
(6, 1, 'Estonia', 'EE', '+372'),
(7, 1, 'Finlandia', 'FI', '+358'),
(8, 1, 'Francia', 'FR', '+33'),
(9, 1, 'Germania', 'DE', '+49'),
(10, 1, 'Grecia', 'GR', '+30'),
(11, 1, 'Irlanda', 'IR', '+353'),
(12, 1, 'Italia', 'IT', '+39'),
(13, 1, 'Lettonia', 'LV', '+371'),
(14, 1, 'Lituania', 'LT', '+370'),
(15, 1, 'Lussemburgo', 'LU', '+352'),
(16, 1, 'Malta', 'MT', '+356'),
(17, 1, 'Paesi Bassi', 'NL', '+31'),
(18, 1, 'Polonia', 'PL', '+48'),
(19, 1, 'Portogallo', 'PT', '+351'),
(20, 1, 'Regno Unito', 'GB', '+44'),
(21, 1, 'Repubblica Ceca', 'CZ', '+420'),
(22, 1, 'Romania', 'RO', '+40'),
(23, 1, 'Slovacchia', 'SK', '+421'),
(24, 1, 'Slovenia', 'SI', '+386'),
(25, 1, 'Spagna', 'ES', '+34'),
(26, 1, 'Svezia', 'SE', '+46'),
(27, 1, 'Ungheria', 'HU', '+36');

CREATE TABLE `client_languages` (
  `idl` int(1) unsigned NOT NULL,
  `idlang` int(1) unsigned NOT NULL,
  `language` char(200) NOT NULL,
  PRIMARY KEY  (`idl`,`idlang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `client_languages` (`idl`, `idlang`, `language`) VALUES (1, 1, 'Italiano'),
(2, 1, 'Inglese'),
(1, 2, 'Italian'),
(2, 2, 'English');

CREATE TABLE `client_logs` (
  `idl` int(4) unsigned NOT NULL auto_increment,
  `logtype` set('EppProto','Security','Generic') NOT NULL,
  `logtime` int(4) NOT NULL,
  `logdesc` char(255) NOT NULL,
  `logip` char(32) NOT NULL,
  PRIMARY KEY  (`idl`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `domain_contacts` (
  `idc` int(4) unsigned NOT NULL auto_increment,
  `contact_id` char(32) NOT NULL,
  `status` set('Active','AdminActive','Deleted','Pending','Errors','Suspended','FailedUpd','PendingUpd') NOT NULL,
  `name` char(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `company` char(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(32) NOT NULL,
  `city` char(200) NOT NULL,
  `province` char(200) NOT NULL,
  `country` char(200) NOT NULL,
  `nationality` char(200) NOT NULL,
  `usertype` int(1) unsigned NOT NULL,
  `cidtype` char(2) NOT NULL,
  `vatcode` char(36) NOT NULL,
  `fiscalcode` char(36) NOT NULL,
  `tel` char(36) NOT NULL,
  `fax` char(36) NOT NULL,
  `email` char(255) NOT NULL,
  `pubblish` set('True','False') NOT NULL,
  `sex` set('M','F') NOT NULL,
  PRIMARY KEY  (`idc`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `domain_flags` (
  `idf` int(4) unsigned NOT NULL auto_increment,
  `idd` int(4) unsigned NOT NULL,
  `status` char(200) NOT NULL,
  PRIMARY KEY  (`idf`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `domain_names` (
  `idd` int(4) unsigned NOT NULL auto_increment,
  `name` char(255) NOT NULL,
  `created` int(4) unsigned NOT NULL,
  `updated` int(4) unsigned NOT NULL,
  `expire` int(4) unsigned NOT NULL,
  `eppcode` varchar(36) NOT NULL,
  `status` int(1) unsigned NOT NULL,
  `idregistrant` char(32) NOT NULL,
  `idadmin` char(32) NOT NULL,
  `idtech` char(32) NOT NULL,
  `idbill` char(32) NOT NULL,
  PRIMARY KEY  (`idd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `domain_nameservers` (
  `idns` int(10) unsigned NOT NULL auto_increment,
  `idd` int(11) NOT NULL,
  `ns` char(255) NOT NULL,
  `ip` char(36) NOT NULL,
  PRIMARY KEY  (`idns`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `domain_status` (
  `idd` int(4) unsigned NOT NULL,
  `domain` char(255) NOT NULL,
  `status` int(1) unsigned NOT NULL,
  PRIMARY KEY  (`idd`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `epp_domstatus` (
  `ids` int(4) unsigned NOT NULL,
  `status` char(200) NOT NULL,
  PRIMARY KEY  (`ids`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `epp_domstatus` (`ids`, `status`) VALUES (1, 'clientUpdateProhibited'),
(2, 'clientTransferProhibited'),
(3, 'clientDeleteProhibited'),
(4, 'clientHold');

CREATE TABLE `epp_polling` (
  `idp` int(4) unsigned NOT NULL auto_increment,
  `code` int(4) unsigned NOT NULL,
  `data` char(200) NOT NULL,
  `title` char(255) NOT NULL,
  `qt` int(4) unsigned NOT NULL,
  `xml` text NOT NULL,
  `status` set('Waiting','Deleted') NOT NULL,
  PRIMARY KEY  (`idp`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `epp_psessions` (
  `idepp` int(4) unsigned NOT NULL auto_increment,
  `ida` int(1) unsigned NOT NULL,
  `ides` int(1) unsigned NOT NULL,
  `started` int(4) unsigned NOT NULL,
  `updated` int(4) unsigned NOT NULL,
  `status` set('Open','Closed','Expired') NOT NULL,
  `sessionid` char(255) NOT NULL,
  `crd_start` float NOT NULL,
  `crd_end` float NOT NULL,
  PRIMARY KEY  (`idepp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `epp_sessions` (
  `idepp` int(4) unsigned NOT NULL auto_increment,
  `ida` int(1) unsigned NOT NULL,
  `started` int(4) unsigned NOT NULL,
  `updated` int(4) unsigned NOT NULL,
  `status` set('Open','Closed','Expired') NOT NULL,
  `sessionid` char(255) NOT NULL,
  `crd_start` float NOT NULL,
  `crd_end` float NOT NULL,
  PRIMARY KEY  (`idepp`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `epp_test` (
  `idtest` int(1) unsigned NOT NULL,
  `username1` char(32) NOT NULL,
  `password1` char(32) NOT NULL,
  `server1` char(200) NOT NULL,
  `username2` char(32) NOT NULL,
  `password2` char(32) NOT NULL,
  `server2` char(200) NOT NULL,
  `status` char(42) NOT NULL,
  `https1` char(200) NOT NULL,
  `https2` char(200) NOT NULL,
  `polling_id` char(200) NOT NULL,
  PRIMARY KEY  (`idtest`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `epp_test` (`idtest`, `username1`, `password1`, `server1`, `username2`, `password2`, `server2`, `status`, `https1`, `https2`, `polling_id`) VALUES (1, 'XXXRO-REG', 'xxxxxxxxxx', 'epp-acc1.nic.it', 'XXXRO1-REG', 'xxxxxxxxxx', 'epp-acc1.nic.it', '111110011111111111111111111111111111111111', 'JSESSIONID=FA20CCAEB18D40B484EF67900C991CDF', 'JSESSIONID=AC34F345A04AA03AE28307564E5178E0', '3');

CREATE TABLE `servers_dns` (
  `idds` int(4) unsigned NOT NULL auto_increment,
  `description` char(200) NOT NULL,
  `ns1` char(255) NOT NULL,
  `ip1` char(32) NOT NULL,
  `ns2` char(255) NOT NULL,
  `ip2` char(32) NOT NULL,
  `ns3` char(255) NOT NULL,
  `ip3` char(32) NOT NULL,
  `ns4` char(255) NOT NULL,
  `ip4` char(32) NOT NULL,
  `ns5` char(255) NOT NULL,
  `ip5` char(32) NOT NULL,
  PRIMARY KEY  (`idds`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `servers_epp` (
  `ides` int(4) unsigned NOT NULL auto_increment,
  `tld` char(32) NOT NULL,
  `description` char(255) NOT NULL,
  `address` char(255) NOT NULL,
  `username` char(40) NOT NULL,
  `password` char(40) NOT NULL,
  `proto` set('EPPoTCP','EPPoHTTP','EPPoSMTP') NOT NULL default 'EPPoTCP',
  `port` char(8) NOT NULL,
  PRIMARY KEY  (`ides`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;