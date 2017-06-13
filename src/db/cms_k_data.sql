-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 13. Jun 2017 um 19:32
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

--
-- Daten für Tabelle `labels`
--

INSERT INTO `labels` (`lID`, `name`, `custom`) VALUES
(1, 'horizontal', 0),
(2, 'vertical', 0);

--
-- Daten für Tabelle `monitorhaslabel`
--

INSERT INTO `monitorhaslabel` (`mID`, `lID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

--
-- Daten für Tabelle `monitorhasresource`
--

INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES
(1, 1, '2018-06-13 19:30:11'),
(2, 2, '2018-06-13 19:30:11');

--
-- Daten für Tabelle `monitors`
--

INSERT INTO `monitors` (`mID`, `name`, `mac`) VALUES
(1, 'Showroom-1', ''),
(2, 'Showroom-2', ''),
(3, 'Showroom-3', ''),
(4, 'Showroom-4', '');

--
-- Daten für Tabelle `resources`
--

INSERT INTO `resources` (`rID`, `name`, `type`, `data`, `created_by`) VALUES
(1, 'W3Schools Website', 'website', 'https://www.w3schools.com/', 1),
(2, 'Overview Slides', 'pdf', 'https://www.st.cs.uni-saarland.de/edu/se/2017/files/slides/Overview.pdf', 1);

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`uID`, `name`, `pass`) VALUES
(1, 'curd', 'a1cf52f3879ca4ee972837d4115a335eb5e77bb52abd15ee89c5c51bb5663c70');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
