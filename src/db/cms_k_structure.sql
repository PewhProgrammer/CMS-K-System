-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 13. Jun 2017 um 19:03
-- Server-Version: 5.6.34-log
-- PHP-Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitorhaslabel`
--

CREATE TABLE IF NOT EXISTS `monitorhaslabel` (
  `mID` int(3) NOT NULL,
  `lID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitorhasresource`
--

CREATE TABLE IF NOT EXISTS `monitorhasresource` (
  `mID` int(3) NOT NULL,
  `rID` int(3) NOT NULL,
  `until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `monitors`
--

CREATE TABLE IF NOT EXISTS `monitors` (
  `mID` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mac` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uID` int(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `pass` varchar(64) NOT NULL COMMENT 'SHA256'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `lID` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `monitors`
--
ALTER TABLE `monitors`
  MODIFY `mID` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `resources`
--
ALTER TABLE `resources`
  MODIFY `rID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `uID` int(3) NOT NULL AUTO_INCREMENT;
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
