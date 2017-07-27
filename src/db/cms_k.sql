-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 14. Jun 2017 um 10:51
-- Server-Version: 5.6.34-log
-- PHP-Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `cms_k`
--
CREATE DATABASE IF NOT EXISTS `cms_k` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cms_k`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `lID` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `custom` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `labels`
--

INSERT INTO `labels` (`lID`, `name`, `custom`) VALUES
(1, 'horizontal', 0),
(2, 'vertical', 0),
(3, 'Ground Floor', 0),
(4, '1st Floor', 0),
(5, '2nd Floor', 0),
(6, '3rd Floor', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitorhaslabel`
--

CREATE TABLE IF NOT EXISTS `monitorhaslabel` (
  `mID` int(3) NOT NULL,
  `lID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `monitorhaslabel`
--

INSERT INTO `monitorhaslabel` (`mID`, `lID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 4),
(15, 4),
(16, 5),
(17, 5),
(18, 6),
(19, 6),
(20, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitorhasresource`
--

CREATE TABLE IF NOT EXISTS `monitorhasresource` (
  `mID` int(3) NOT NULL,
  `rID` int(3) NOT NULL,
  `until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `monitorhasresource`
--

INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES
(1, 0, '2018-06-13 19:30:11'),
(2, 1, '2018-06-13 19:30:11'),
(3, 2, '2018-06-13 19:30:11'),
(4, 3, '2018-06-13 19:30:11'),
(5, 4, '2018-06-13 19:30:11'),
(6, 5, '2018-06-13 19:30:11'),
(7, 6, '2018-06-13 19:30:11');


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitors`
--

CREATE TABLE IF NOT EXISTS `monitors` (
  `mID` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mac` varchar(17) NOT NULL,
  `new` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `monitors`
--

INSERT INTO `monitors` (`mID`, `name`, `mac`, `new`) VALUES
(1, 'Showroom-1', '',FALSE ),
(2, 'Showroom-2', '',FALSE ),
(3, 'Showroom-3', '',FALSE ),
(4, 'Showroom-4', '',FALSE ),
(5, 'Showroom-5', '',FALSE ),
(6, 'Showroom-6', '',FALSE ),
(7, 'Showroom-7', '',FALSE ),
(8, 'Building plan/people - 1', '',FALSE ),
(9, 'Info - 1', '',FALSE ),
(10, 'Info - 2', '',FALSE ),
(11, 'Info - 3', '',FALSE ),
(12, 'Info - 4', '',FALSE ),
(13, 'Info - 5', '',FALSE ),
(14, 'Kitchen - 1', '',FALSE ),
(15, 'Office', '',FALSE ),
(16, 'Kitchen - 2', '',FALSE ),
(17, 'Meeting Room - 1', '',FALSE ),
(18, 'Kitchen - 3', '',FALSE ),
(19, 'Meeting Room - 2', '',FALSE ),
(20, 'Meeting Room - 3', '',FALSE );

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `rID` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL,
  `data` varchar(500) NOT NULL,
  `created_by` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `resources`
--

INSERT INTO `resources` (`rID`, `name`, `type`, `data`, `created_by`) VALUES
(0, 'Bus Plan', 'bus', '', 1),
(1, 'Mensa Plan', 'mensa', '', 1),
(2, 'W3Schools Website', 'website', 'https://www.w3schools.com/', 1),
(3, 'Overview Slides', 'pdf', 'https://www.st.cs.uni-saarland.de/edu/se/2017/files/slides/Overview.pdf', 1),
(4, 'Elephant', 'image', 'http://wallpaper-gallery.net/images/image/image-13.jpg', 1),
(5, 'RSS Sample Feed', 'rss', 'http://www.feedforall.com/blog-feed.xml', 1),
(6, 'Calendar Holiday', 'caldav', 'http://www.calendarlabs.com/templates/ical/US-Holidays.ics',1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uID` int(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `pass` varchar(64) NOT NULL COMMENT 'SHA256',
  `session_id` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`uID`, `name`, `pass`,`session_id`) VALUES
(1, 'curd', 'a1cf52f3879ca4ee972837d4115a335eb5e77bb52abd15ee89c5c51bb5663c70','');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`lID`);

--
-- Indizes für die Tabelle `monitorhaslabel`
--
ALTER TABLE `monitorhaslabel`
  ADD PRIMARY KEY (`mID`,`lID`),
  ADD KEY `lID` (`lID`);

--
-- Indizes für die Tabelle `monitorhasresource`
--
ALTER TABLE `monitorhasresource`
  ADD PRIMARY KEY (`mID`,`rID`),
  ADD KEY `rID` (`rID`);

--
-- Indizes für die Tabelle `monitors`
--
ALTER TABLE `monitors`
  ADD PRIMARY KEY (`mID`);


--
-- Indizes für die Tabelle `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`rID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `labels`
--
ALTER TABLE `labels`
  MODIFY `lID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `monitors`
--
ALTER TABLE `monitors`
  MODIFY `mID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `resources`
--
ALTER TABLE `resources`
  MODIFY `rID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `uID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `monitorhaslabel`
--
ALTER TABLE `monitorhaslabel`
  ADD CONSTRAINT `monitorhaslabel_ibfk_1` FOREIGN KEY (`mID`) REFERENCES `monitors` (`mID`),
  ADD CONSTRAINT `monitorhaslabel_ibfk_2` FOREIGN KEY (`lID`) REFERENCES `labels` (`lID`);

--
-- Constraints der Tabelle `monitorhasresource`
--
ALTER TABLE `monitorhasresource`
  ADD CONSTRAINT `monitorhasresource_ibfk_1` FOREIGN KEY (`mID`) REFERENCES `monitors` (`mID`),
  ADD CONSTRAINT `monitorhasresource_ibfk_2` FOREIGN KEY (`rID`) REFERENCES `resources` (`rID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
