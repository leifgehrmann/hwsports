SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `authGroups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `authMeta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `authUsers` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `centreData` (
  `centreID` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `match` (
  `matchID` int(11) NOT NULL AUTO_INCREMENT,
  `venueID` int(11) NOT NULL,
  `sportID` int(11) NOT NULL,
  PRIMARY KEY (`matchID`),
  KEY `venueID` (`venueID`),
  KEY `sportID` (`sportID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `matchData` (
  `matchID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `personData` (
  `personID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `personID` (`personID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `persons` (
  `personID` int(11) NOT NULL AUTO_INCREMENT,
  `personType` int(11) NOT NULL,
  PRIMARY KEY (`personID`),
  KEY `personType` (`personType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `personTypes` (
  `personType` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `personType` (`personType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `results` (
  `resultsID` int(11) NOT NULL AUTO_INCREMENT,
  `matchID` int(11) NOT NULL,
  PRIMARY KEY (`resultsID`),
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `resultsData` (
  `resultsID` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  KEY `resultsID` (`resultsID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `sports` (
  `sportID` int(11) NOT NULL AUTO_INCREMENT,
  `sportTypeID` int(11) NOT NULL,
  `sportName` text NOT NULL,
  PRIMARY KEY (`sportID`),
  KEY `sportTypeID` (`sportTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `sportTypeData` (
  `sportTypeID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `sportTypeID` (`sportTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `teamData` (
  `teamID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `teamID` (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `teamsPersons` (
  `teamID` int(11) NOT NULL,
  `personID` int(11) NOT NULL,
  KEY `teamID` (`teamID`),
  KEY `personID` (`personID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ticketData` (
  `ticketID` int(11) NOT NULL,
  `key` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  KEY `ticketID` (`ticketID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tickets` (
  `ticketID` int(11) NOT NULL AUTO_INCREMENT,
  `ticketTypeID` int(11) NOT NULL,
  `personID` int(11) NOT NULL,
  PRIMARY KEY (`ticketID`),
  KEY `ticketTypeID` (`ticketTypeID`),
  KEY `personID` (`personID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ticketTypes` (
  `ticketTypeID` int(11) NOT NULL,
  `matchID` int(11) NOT NULL,
  `ticketTypeName` text NOT NULL,
  `ticketTypePrice` double NOT NULL,
  PRIMARY KEY (`ticketTypeID`),
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tournamentData` (
  `tournamentID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tournamentMatches` (
  `tournamentID` int(11) NOT NULL,
  `matchID` int(11) NOT NULL,
  KEY `tournamentID` (`tournamentID`),
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `venueData` (
  `venueID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  KEY `venueID` (`venueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `venues` (
  `venueID` int(11) NOT NULL AUTO_INCREMENT,
  `centreID` int(11) NOT NULL,
  PRIMARY KEY (`venueID`),
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

CREATE TABLE IF NOT EXISTS `venuesSportTypes` (
  `venueID` int(11) NOT NULL,
  `sportTypeID` int(11) NOT NULL,
  KEY `venueID` (`venueID`),
  KEY `sportTypeID` (`sportTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venues` (`venueID`),
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`sportID`) REFERENCES `sports` (`sportID`);

ALTER TABLE `matchData`
  ADD CONSTRAINT `matchData_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `match` (`matchID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `personData`
  ADD CONSTRAINT `personData_ibfk_1` FOREIGN KEY (`personID`) REFERENCES `persons` (`personID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `persons`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`personType`) REFERENCES `personTypes` (`personType`);

ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `match` (`matchID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `resultsData`
  ADD CONSTRAINT `resultsData_ibfk_1` FOREIGN KEY (`resultsID`) REFERENCES `results` (`resultsID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sports`
  ADD CONSTRAINT `sports_ibfk_1` FOREIGN KEY (`sportTypeID`) REFERENCES `sportTypeData` (`sportTypeID`);

ALTER TABLE `teamData`
  ADD CONSTRAINT `teamData_ibfk_1` FOREIGN KEY (`teamID`) REFERENCES `teamsPersons` (`teamID`);

ALTER TABLE `teamsPersons`
  ADD CONSTRAINT `teamsPersons_ibfk_1` FOREIGN KEY (`personID`) REFERENCES `persons` (`personID`);

ALTER TABLE `ticketData`
  ADD CONSTRAINT `ticketData_ibfk_2` FOREIGN KEY (`ticketID`) REFERENCES `tickets` (`ticketID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`ticketTypeID`) REFERENCES `ticketTypes` (`ticketTypeID`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`personID`) REFERENCES `persons` (`personID`);

ALTER TABLE `ticketTypes`
  ADD CONSTRAINT `ticketTypes_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `match` (`matchID`);

ALTER TABLE `tournamentData`
  ADD CONSTRAINT `tournamentData_ibfk_1` FOREIGN KEY (`tournamentID`) REFERENCES `tournamentMatches` (`tournamentID`);

ALTER TABLE `tournamentMatches`
  ADD CONSTRAINT `tournamentMatches_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `match` (`matchID`);

ALTER TABLE `venueData`
  ADD CONSTRAINT `venueData_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venues` (`venueID`);

ALTER TABLE `venues`
  ADD CONSTRAINT `venues_ibfk_2` FOREIGN KEY (`centreID`) REFERENCES `centreData` (`centreID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `venuesSportTypes`
  ADD CONSTRAINT `venuesSportTypes_ibfk_2` FOREIGN KEY (`sportTypeID`) REFERENCES `sportTypeData` (`sportTypeID`),
  ADD CONSTRAINT `venuesSportTypes_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venues` (`venueID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
