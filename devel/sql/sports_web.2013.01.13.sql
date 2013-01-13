-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2013 at 09:28 PM
-- Server version: 5.1.66-cll
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sports_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `centreData`
--

CREATE TABLE IF NOT EXISTS `centreData` (
  `centreID` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`centreID`,`key`),
  UNIQUE KEY `centreID_2` (`centreID`,`key`),
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `centreData`
--

INSERT INTO `centreData` (`centreID`, `key`, `value`) VALUES
(1, 'address', 'Centre for Sport and Exercise, Heriot-Watt University, Edinburgh, EH14 4AS'),
(1, 'backgroundColour', 'E7EEF9'),
(1, 'headerColour', '00468C'),
(1, 'legalText', 'Â© Heriot-Watt University, Edinburgh, Scotland, UK EH14 4AS, Tel: +44 (0) 131 449 5111 Scottish registered charity number: SC000278'),
(1, 'name', 'Heriot-Watt University Centre for Sport and Exercise'),
(1, 'shortName', 'Heriot-Watt University'),
(1, 'slug', 'hwsports'),
(2, 'name', 'Some Other University'),
(2, 'slug', 'sou');

-- --------------------------------------------------------

--
-- Table structure for table `gameData`
--

CREATE TABLE IF NOT EXISTS `gameData` (
  `gameID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`gameID`,`key`),
  UNIQUE KEY `games` (`gameID`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `gameID` int(11) NOT NULL,
  `tournamentID` int(11) NOT NULL,
  `sportID` int(11) NOT NULL,
  PRIMARY KEY (`gameID`),
  KEY `tournamentID` (`tournamentID`,`sportID`),
  KEY `tournamentID_2` (`tournamentID`,`sportID`),
  KEY `sportID` (`sportID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loginAttempts`
--

CREATE TABLE IF NOT EXISTS `loginAttempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `matchData`
--

CREATE TABLE IF NOT EXISTS `matchData` (
  `matchID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `matchID` (`matchID`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `matchID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL,
  `venueID` int(11) NOT NULL,
  PRIMARY KEY (`matchID`),
  KEY `gameID` (`gameID`,`venueID`),
  KEY `venueID` (`venueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resultData`
--

CREATE TABLE IF NOT EXISTS `resultData` (
  `resultID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `resultID` (`resultID`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `resultID` int(11) NOT NULL,
  `matchID` int(11) NOT NULL,
  PRIMARY KEY (`resultID`),
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sportData`
--

CREATE TABLE IF NOT EXISTS `sportData` (
  `sportID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`sportID`,`key`),
  KEY `sportTypeID` (`sportID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sportData`
--

INSERT INTO `sportData` (`sportID`, `key`, `value`) VALUES
(1, 'name', 'Air Sports'),
(2, 'name', 'Archery Variants'),
(3, 'name', 'Ball-over-net games'),
(4, 'name', 'Basketball Family'),
(5, 'name', 'Bat-and-Ball'),
(6, 'name', 'Boarding'),
(7, 'name', 'Bowls'),
(8, 'name', 'Bowling'),
(9, 'name', 'Catch'),
(10, 'name', 'Climbing'),
(11, 'name', 'Cycling'),
(12, 'name', 'Combat'),
(13, 'name', 'Cue'),
(14, 'name', 'Dance'),
(15, 'name', 'Equine'),
(16, 'name', 'Fishing'),
(17, 'name', 'Flying Disk'),
(18, 'name', 'Football Family'),
(19, 'name', 'Golf'),
(20, 'name', 'Gymnastics'),
(21, 'name', 'Handball'),
(22, 'name', 'Hunting'),
(23, 'name', 'Kite'),
(24, 'name', 'Mixed'),
(25, 'name', 'Swimming'),
(26, 'name', 'Orienteering Family'),
(27, 'name', 'Paddle'),
(28, 'name', 'Racket'),
(29, 'name', 'Remote Control'),
(30, 'name', 'Sailing'),
(31, 'name', 'Skiing'),
(32, 'name', 'Sledding'),
(33, 'name', 'Shooting'),
(34, 'name', 'Stick and Ball'),
(35, 'name', 'Street Stunts'),
(36, 'name', 'Tag'),
(37, 'name', 'Walking'),
(38, 'name', 'Wall and Ball'),
(39, 'name', 'Water Ball'),
(40, 'name', 'Diving'),
(41, 'name', 'Weightlifting'),
(42, 'name', 'Land Motorsports'),
(43, 'name', 'Water Motorsports'),
(44, 'name', 'Mind Sports'),
(45, 'name', 'Miscellaneous'),
(46, 'name', 'Running'),
(47, 'name', 'Sailing');

-- --------------------------------------------------------

--
-- Table structure for table `teamData`
--

CREATE TABLE IF NOT EXISTS `teamData` (
  `teamID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`teamID`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `teamID` int(11) NOT NULL,
  `centreID` int(11) NOT NULL,
  PRIMARY KEY (`teamID`),
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teamsUsers`
--

CREATE TABLE IF NOT EXISTS `teamsUsers` (
  `teamID` int(11) NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  KEY `teamID` (`teamID`),
  KEY `personID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticketData`
--

CREATE TABLE IF NOT EXISTS `ticketData` (
  `ticketID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `ticketID_2` (`ticketID`,`key`),
  KEY `ticketID` (`ticketID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `ticketID` int(11) NOT NULL AUTO_INCREMENT,
  `ticketTypeID` int(11) NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ticketID`),
  KEY `ticketTypeID` (`ticketTypeID`),
  KEY `personID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketTypes`
--

CREATE TABLE IF NOT EXISTS `ticketTypes` (
  `ticketTypeID` int(11) NOT NULL,
  `ticketTypeName` text NOT NULL,
  `ticketTypePrice` double NOT NULL,
  PRIMARY KEY (`ticketTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tournamentData`
--

CREATE TABLE IF NOT EXISTS `tournamentData` (
  `tournamentID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`tournamentID`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `tournamentID` int(11) NOT NULL,
  `centreID` int(11) NOT NULL,
  PRIMARY KEY (`tournamentID`),
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userData`
--

CREATE TABLE IF NOT EXISTS `userData` (
  `userID` mediumint(8) unsigned NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`userID`,`key`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userData`
--

INSERT INTO `userData` (`userID`, `key`, `value`) VALUES
(1, 'centreID', '1'),
(1, 'firstName', 'Andrew'),
(1, 'lastName', 'Beveridge'),
(1, 'phone', '07835171222'),
(10, 'centreID', '1'),
(10, 'firstName', 'Marta'),
(10, 'lastName', 'Llamas'),
(10, 'phone', '9999999999'),
(11, 'centreID', '1'),
(11, 'firstName', 'Leif'),
(11, 'lastName', 'Gehrmann'),
(11, 'phone', '2342432452432'),
(12, 'centreID', '0'),
(12, 'firstName', 'Connor'),
(12, 'lastName', 'Boyle'),
(12, 'phone', '07518745997'),
(13, 'centreID', '0'),
(13, 'firstName', 'Leif'),
(13, 'lastName', 'Gehrmann'),
(13, 'phone', '0118999881999');

-- --------------------------------------------------------

--
-- Table structure for table `userGroups`
--

CREATE TABLE IF NOT EXISTS `userGroups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userGroups`
--

INSERT INTO `userGroups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator of Infusion Sports'),
(2, 'centreadmin', 'Administrator of a Sports Centre'),
(3, 'centrestaff', 'Staff of a Sports Centre'),
(4, 'user', 'All other roles');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`) VALUES
(1, '\0\0', 'hwsports@techfixuk.com', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'hwsports@techfixuk.com', '', NULL, NULL, '9d029802e28cd9c768e8e62277c0df49ec65c48c', 1268889823, 1358096991, 1),
(10, 'V”>‹', 'hwsports@andrewbeveridge.co.uk', 'cad0b0d402cf63c27a55da5d062b3c4e9840b660', NULL, 'hwsports@andrewbeveridge.co.uk', NULL, '0ef3285ef7f7913d48b61ee91518c7c2345d961b', 1357320950, NULL, 1357253296, 1357256364, 1),
(11, 'V”>‹', 'leif.gehrmann@gmail.com', '477c9a3bd6336ae412209f037410c71b33d5a79c', NULL, 'leif.gehrmann@gmail.com', NULL, NULL, NULL, '8c1c0dd59e4e6a986d64c6bc434efbd1cf32a9d3', 1357253393, 1358077286, 1),
(12, '©»', 'cboyle5@hotmail.co.uk', 'e2b5d3dd259701c01237928558d4e8de89ad5462', NULL, 'cboyle5@hotmail.co.uk', NULL, NULL, NULL, NULL, 1357603806, 1357603829, 1),
(13, 'Í‚', 'lg90@hw.ac.uk', '4abe79df6aca96135494500b13550bbfe3db506b', NULL, 'lg90@hw.ac.uk', NULL, NULL, NULL, NULL, 1357764797, 1357862055, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usersGroups`
--

CREATE TABLE IF NOT EXISTS `usersGroups` (
  `userID` mediumint(8) unsigned NOT NULL,
  `groupID` mediumint(8) unsigned NOT NULL,
  KEY `userID` (`userID`),
  KEY `groupID` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersGroups`
--

INSERT INTO `usersGroups` (`userID`, `groupID`) VALUES
(1, 1),
(10, 4),
(11, 1),
(12, 4),
(13, 4);

-- --------------------------------------------------------

--
-- Table structure for table `venueData`
--

CREATE TABLE IF NOT EXISTS `venueData` (
  `venueID` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`venueID`,`key`),
  UNIQUE KEY `venueID_2` (`venueID`,`key`),
  KEY `venueID` (`venueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venueData`
--

INSERT INTO `venueData` (`venueID`, `key`, `value`) VALUES
(14, 'description', 'This is nice'),
(14, 'directions', 'Get here, fast!'),
(14, 'lat', '55.909403'),
(14, 'lng', '-3.3206991'),
(14, 'name', 'marllasco'),
(15, 'description', 'This is nice'),
(15, 'directions', 'Get here, wdsdd!'),
(15, 'lat', '55.909403'),
(15, 'lng', '-3.3206991'),
(15, 'name', 'Sports Hall 1'),
(16, 'description', 'borign'),
(16, 'directions', 'no fun'),
(16, 'lat', '55.91144755129656'),
(16, 'lng', '-3.325602178079181'),
(16, 'name', 'edwin chadwick'),
(17, 'description', 'it is here'),
(17, 'lat', '55.90792764772625'),
(17, 'lng', '-3.317845229608112'),
(17, 'name', 'Pitch C'),
(18, 'description', 'Tennis court near Car Park C'),
(18, 'directions', 'Facing the south east direction of The Ave near the roundabout, turn left and walk past the Golf Academy.'),
(18, 'lat', '55.90999608141687'),
(18, 'lng', '-3.315904651385837'),
(18, 'name', 'Tennis Court A'),
(19, 'description', 'Tennis court near Car Park C'),
(19, 'directions', 'Facing the south east direction of The Ave near the roundabout, turn left and walk past the Golf Academy.'),
(19, 'lat', '55.910090041518814'),
(19, 'lng', '-3.315712873441272'),
(19, 'name', 'Tennis Court B'),
(20, 'description', 'Tennis court near Car Park C'),
(20, 'directions', 'Facing the south east direction of The Ave near the roundabout, turn left and walk past the Golf Academy.'),
(20, 'lat', '55.9101682161501'),
(20, 'lng', '-3.315517072183185'),
(20, 'name', 'Tennis Court C'),
(21, 'description', 'test'),
(21, 'directions', 'test'),
(21, 'lat', '55.909403'),
(21, 'lng', '-3.3206991'),
(21, 'name', 'test'),
(23, 'description', 'Directions are hard to write. So I''m not going to bother.'),
(23, 'directions', 'Directions are hard to write. So I''m not going to bother.'),
(23, 'lat', '55.90728016023888'),
(23, 'lng', '-3.3197442335906557'),
(23, 'name', 'Pitch A'),
(24, 'description', 'Directions are hard to write. So I''m not going to bother.'),
(24, 'directions', 'Directions are hard to write. So I''m not going to bother.'),
(24, 'lat', '55.90728016023888'),
(24, 'lng', '-3.3197442335906557'),
(24, 'name', 'Pitch A'),
(28, 'description', 'sdfew'),
(28, 'directions', 'sdfew'),
(28, 'lat', '55.910894330675305'),
(28, 'lng', '-3.3196262163940005'),
(28, 'name', 'ermagerhd'),
(29, 'description', 'ektjeghrhjk'),
(29, 'directions', 'ektjeghrhjk'),
(29, 'lat', '55.907598894301955'),
(29, 'lng', '-3.3183816714110903'),
(29, 'name', 'sdjhfkrufoirjfehru');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE IF NOT EXISTS `venues` (
  `venueID` int(11) NOT NULL AUTO_INCREMENT,
  `centreID` int(11) NOT NULL,
  PRIMARY KEY (`venueID`),
  KEY `centreID` (`centreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venueID`, `centreID`) VALUES
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(23, 1),
(24, 1),
(29, 1),
(21, 2),
(28, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`sportID`) REFERENCES `sportData` (`sportID`),
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`);

--
-- Constraints for table `matchData`
--
ALTER TABLE `matchData`
  ADD CONSTRAINT `matchData_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`venueID`) REFERENCES `venues` (`venueID`),
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`);

--
-- Constraints for table `resultData`
--
ALTER TABLE `resultData`
  ADD CONSTRAINT `resultData_ibfk_1` FOREIGN KEY (`resultID`) REFERENCES `results` (`resultID`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`);

--
-- Constraints for table `teamData`
--
ALTER TABLE `teamData`
  ADD CONSTRAINT `teamData_ibfk_1` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`centreID`) REFERENCES `centreData` (`centreID`);

--
-- Constraints for table `teamsUsers`
--
ALTER TABLE `teamsUsers`
  ADD CONSTRAINT `teamsUsers_ibfk_3` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`),
  ADD CONSTRAINT `teamsUsers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticketData`
--
ALTER TABLE `ticketData`
  ADD CONSTRAINT `ticketData_ibfk_2` FOREIGN KEY (`ticketID`) REFERENCES `tickets` (`ticketID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`ticketTypeID`) REFERENCES `ticketTypes` (`ticketTypeID`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `tournamentData`
--
ALTER TABLE `tournamentData`
  ADD CONSTRAINT `tournamentData_ibfk_1` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`);

--
-- Constraints for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `tournaments_ibfk_1` FOREIGN KEY (`centreID`) REFERENCES `centreData` (`centreID`);

--
-- Constraints for table `userData`
--
ALTER TABLE `userData`
  ADD CONSTRAINT `userData_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `usersGroups`
--
ALTER TABLE `usersGroups`
  ADD CONSTRAINT `usersGroups_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usersGroups_ibfk_2` FOREIGN KEY (`groupID`) REFERENCES `userGroups` (`id`);

--
-- Constraints for table `venueData`
--
ALTER TABLE `venueData`
  ADD CONSTRAINT `venueData_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venues` (`venueID`);

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_ibfk_2` FOREIGN KEY (`centreID`) REFERENCES `centreData` (`centreID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
