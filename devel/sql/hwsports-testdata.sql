SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `authGroups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

INSERT INTO `authMeta` (`id`, `user_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 1, 'Admin', 'istrator', 'ADMIN', '0');

INSERT INTO `authUsers` (`id`, `group_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `remember_code`, `created_on`, `last_login`, `active`) VALUES
(1, 1, '127.0.0.1', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, 1268889823, 1268889823, 1);

INSERT INTO `centreData` (`centreID`, `key`, `value`) VALUES
(1, 'name', 'Heriot-Watt University Centre for Sport and Exercise'),
(1, 'address', 'Centre for Sport and Exercise, Heriot-Watt University, Edinburgh, EH14 4AS'),
(2, 'name', 'Edinburgh South Football Club'),
(2, 'address', 'Edinburgh South Football Club, Edinburgh, Midlothian, EH16 5UD');

INSERT INTO `match` (`matchID`, `venueID`, `sportID`) VALUES
(1, 3, 1),
(2, 4, 2),
(3, 4, 4),
(4, 5, 5);

INSERT INTO `matchData` (`matchID`, `key`, `value`) VALUES
(1, 'name', 'Heriot-Watt vs Edinburgh'),
(1, 'type', 'Friendly'),
(2, 'name', 'Women''s Hurdling Trials'),
(2, 'gender', 'Female'),
(3, 'name', 'Men''s Hurdling Trials'),
(3, 'gender', 'Male'),
(4, 'name', 'Celtic vs Rangers'),
(3, 'startTime', '2012-10-20 18:00:00'),
(3, 'endTime', '2012-10-20 19:00:00'),
(2, 'startTime', '2012-10-20 19:00:00'),
(2, 'endTime', '2012-10-20 20:00:00'),
(1, 'startTime', '2012-10-23 16:00:00'),
(1, 'endTime', '2012-10-23 18:00:00'),
(4, 'startTime', '2012-10-22 12:00:00'),
(4, 'endTime', '2012-10-22 14:00:00'),
(4, 'maxTickets', '2000');

INSERT INTO `sports` (`sportID`, `sportTypeID`, `sportName`) VALUES
(1, 18, 'WattBall'),
(2, 46, 'Mens Heriot Hurdling'),
(4, 46, 'Womens Heriot Hurdling'),
(5, 18, 'Football');

INSERT INTO `sportTypeData` (`sportTypeID`, `key`, `value`) VALUES
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

INSERT INTO `venueData` (`venueID`, `key`, `value`) VALUES
(1, 'name', 'Sports Hall 1'),
(1, 'maxTickets', '200'),
(2, 'name', 'Sports Hall 2'),
(2, 'maxTickets', '300'),
(3, 'name', 'Pitch 1'),
(4, 'name', 'Lane 1'),
(5, 'name', 'Pitch A'),
(6, 'name', 'Pitch B'),
(7, 'name', 'Lane 2'),
(8, 'name', 'Lane 3'),
(9, 'name', 'Lane 4'),
(10, 'name', 'Lane 5'),
(11, 'name', 'Lane 6');

INSERT INTO `venues` (`venueID`, `centreID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(5, 2),
(6, 2);

INSERT INTO `venuesSportTypes` (`venueID`, `sportTypeID`) VALUES
(1, 4),
(1, 3),
(1, 14),
(1, 28),
(1, 12),
(5, 18),
(6, 18),
(3, 18),
(4, 46),
(2, 4),
(2, 3),
(2, 14),
(2, 28),
(2, 12);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
