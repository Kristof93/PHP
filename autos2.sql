-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Sep 2013 um 06:38
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `Projekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `autos`
--

CREATE TABLE IF NOT EXISTS `autos` (
  `autoID` int(11) NOT NULL AUTO_INCREMENT,
  `autoName` varchar(200) NOT NULL,
  `autoPreis` decimal(10,2) NOT NULL,
  `autoGruppe` varchar(200) NOT NULL,
  `autoBeschreibung` text NOT NULL,
  PRIMARY KEY (`autoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;


-- Daten für Tabelle `autos`
--

INSERT INTO `autos` (`autoID`, `autoName`, `autoPreis`, `autoGruppe`, `autoBeschreibung`) VALUES
(1, 'BMW 1', 141.00, 'Limousine', '5 Sitze, Diesel, 5 Türe, Manuell '),
(2, 'BMW X1', 180.00, 'Limousine', '5 Sitze, Diesel, 5 Türe, Automatik'),
(3, 'BMW 520d', 120.00, 'Limousine', '5 Sitze, Benzin, 5 Türe, Manuell'),
(4, 'BMW 7', 190.00, 'Limousine', '5 Sitze, Diesel, 5 Türe, Automatik'),
(5, 'Audi A4 Avant', 95.00, 'Kombi', '5 Sitze, Benzin, 5Türe, Manuell'),
(6, 'Audi R8', 98.00, 'Limousine', '2 Sitze, Diesel, 3 Türe, Automatik'),
(7, 'Audi RS3', 110.00, 'Limousine', '5 Sitze, Diesel, 5 Türe, Manuell'),
(8, 'Mercedes V-Class', 150.00, 'Kleinbus', '7 Sitze, Diesel, 4 Türe, Manuell'),
(9, 'Mercedes C-Class', 140.00, 'Limousine', '5 Sitze, Diesel, 5 Türe, Automatik'),
(10, 'Mercedes Vito', 160.00, 'Kleinbus', '9 Sitze, Diesel, 5 Türe, Manuell'),
(11, 'Chevrolet C6', 210.00, 'Limousine', '2 Sitze, Benzin, 3 Türe, Automatik'),
(12, 'Chevrolet Camaro', 230.00, 'Limousine', '2 Sitze, Benzin, 3 Türe, Automatik'),
(13, 'Ferrari F8 Tributo', 450.00, 'Limousine', '2 Sitze, Diesel, 3 Türe, Automatik'),
(14, 'Lamborghini Gallardo', 420.00, 'Limousine', '2 Sitze, Diesel, 3 Türe, Automatik'),
(15, 'Tesla Model S', 130.00, 'Limousine', '4 Sitze, Elektro, 5 Türe, Automatik');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
