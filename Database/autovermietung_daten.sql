-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Mai 2022 um 16:17
-- Server-Version: 10.4.24-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `autovermietung`
--

--
-- Daten für Tabelle `aktuellepersonalplaene`
--

INSERT INTO `aktuellepersonalplaene` (`personalplanID`, `erstellDatum`, `gueltigBis`, `mitarbeiterID`, `ersteller`, `abgabestation`) VALUES
(1, '2022-05-23', '2022-06-17', 1, 4, 1),
(2, '2022-05-23', '2022-07-20', 3, 4, 3),
(3, '2022-05-23', '2022-07-04', 2, 1, 4),
(4, '2022-05-23', '2022-07-13', 4, 3, 2);

--
-- Daten für Tabelle `kfzs`
--

INSERT INTO `kfzs` (`kfzID`, `marke`, `modell`, `kfzTypID`, `gesamtnote`, `lackZustand`, `innenraumNote`, `technikZustandNote`, `anmerkungen`, `kilometerStand`, `kennzeichen`) VALUES
(1, 'Ford', 'Mustang', 4, 2, 2, 1, 3, NULL, 15000, 'WES-DE-12'),
(2, 'Porsche', '911 Carrera', 4, 1, 1, 1, 1, NULL, 0, 'BO-CD-82'),
(3, 'Mercedes', 'GLC', 1, 3, 3, 2, 2, NULL, 2500, 'DU-UD-59'),
(4, 'Peugeot', '308 SW', 6, 1, 2, 1, 1, NULL, 2000, 'D-AZ-29');

--
-- Daten für Tabelle `kfztypen`
--

INSERT INTO `kfztypen` (`kfzTypID`, `typBezeichnung`, `tarifID`) VALUES
(1, 'SUV', 1),
(2, 'Limousine', 4),
(3, 'Bus', 4),
(4, 'Sportwagen', 3),
(5, 'Van', 2),
(6, 'Kombi', 1),
(7, 'Pickup', 2);

--
-- Daten für Tabelle `kunden`
--

INSERT INTO `kunden` ( `vorname`, `nachname`, `strasse`, `hausNr`, `plz`, `ort`, `land`, `iban`, `bic`, `telefonNr`, `emailAdresse`, `kontostand`, `pseudo`, `password`, `validatedAccount`, `codeResetPassword`,`AnzVersuche`) VALUES
( 'Anne', 'Kappel', 'Bleibtreustraße', 34, 82061, 'Berlin', 'Deutschland', 'DE78500105172923411175', 'DE78500105172923411175', '07807 66 60 89', 'AnneKappel@einrot.com', 100, 'AnneKappel', '$2y$10$ee9GJjP4Z8ecotEEadk4f.NAfLkuicMNlNBNrVzBsZEtZiF9KRYZK', 1, NULL,0),
( 'Sihem', 'Osterman', 'Neue Roßstraße', 80, 55545, 'Frankfurt', 'Deutschland', 'DE14500105174682434577', 'DE14500105174682434577', '0671 10 14 97', 'SihemOstermann@cuvox.de', 200, 'SihemOstermann', '$2y$10$N3lMm01agYLv71ClWzDxdOaufBbbERXvJG1VeqB5uIAyF.tK.8iCy' , 1, NULL,0),
( 'Annabell', 'Bader', 'Joachimstaler Straße', 50, 56288, 'Bocholt', 'Deutschland', 'DE18500105179694155718', 'DE18500105179694155718', '06762 13 64 46', 'AnnabellBader@einrot.com',500, 'AnnabellBader', '$2y$10$YkHckqRREHQDyCX6KBPy4eDEmJMNxVMXky9rgWvTkaYMm8NUsmZR2' , 1, NULL,0),
( 'Andrea', 'Osterhagen', 'Feldstrasse', 63, 39446, 'Vreden', 'Deutschland', 'DE85500105173378848553', 'DE85500105173378848553', ' 039265 38 37', 'AndreaOsterhagen@cuvox.de', 0, 'AndreaOsterhagen', '$2y$10$qvK7j7YpGV/bgKHIdgwoeuG7nmI2442/9uhBohPEst3kRDIicethW' , 1, NULL,0);

--
-- Daten für Tabelle `mietstationen`
--

INSERT INTO `mietstationen` (`mietstationID`, `mietstationTyp`, `stellplaetze`, `lage`, `groesse`) VALUES
(1, 'Abholstation', 300, 'Bestlage', 1000),
(2, 'Abgabestation', 100, 'einfache Lage', 500),
(3, 'Abgabestation', 400, 'durchschnittliche Lage', 1200),
(4, 'Abholstation', 750, 'gute Lage', 1600);

--
-- Daten für Tabelle `mietstationen_mietwagenbestaende`
--

INSERT INTO `mietstationen_mietwagenbestaende` (`kfzID`, `mietstationID`) VALUES
(1, 1),
(3, 4),
(4, 2),
(2, 3);

--
-- Daten für Tabelle `mietvertraege`
--

INSERT INTO `mietvertraege` (`mietvertragID`, `status`, `mietdauerTage`, `mietgebuehr`, `zahlart`, `abholstation`, `rueckgabestation`, `vertragID`) VALUES
(1, 'bestätigt', 30, 500, 'Kreditkarte', 1, 2, 1),
(2, 'bestätigt', 60, 2500, 'Rechnung', 4, 3, 2);

--
-- Daten für Tabelle `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`mitarbeiterID`, `name`, `vorname`, `geburtsDatum`, `position`, `abteilung`) VALUES
(1, 'Pascal', 'Ewald', '2001-01-01', 'Abteilungsleiter', 'Verwaltung'),
(2, 'Tim', 'Middeke', '2002-02-02', 'Schichtleiter', 'Vertrieb'),
(3, 'Bastian', 'Oymanns', '2003-03-03', 'Sales Manager', 'Vertrieb'),
(4, 'Julian ', 'Eckerskorn', '2005-05-05', 'Geschäftsführer', 'Geschäftsführung');

--
-- Daten für Tabelle `rechnungen`
--

INSERT INTO `rechnungen` (`rechnungNr`, `mietvertragID`, `kundeID`, `rechnungDatum`, `rechnungBetrag`, `mahnstatus`) VALUES
(1, 1, 1, '2022-05-23', 500, 'keine'),
(2, 2, 3, '2022-05-23', 2500, 'keine');

--
-- Daten für Tabelle `reservierungen`
--

INSERT INTO `reservierungen` (`kundeID`, `kfzTypID`, `mietstationID`, `status`, `datum`) VALUES
(1, 4, 1, 'bestätigt', '2022-05-28'),
(3, 1, 4, 'bestätigt', '2022-07-21');

--
-- Daten für Tabelle `ruecknahmeprotokolle`
--

INSERT INTO `ruecknahmeprotokolle` (`ruecknahmeprotokollID`, `ersteller`, `protokollDatum`, `tank`, `sauberkeit`, `mechanik`, `kilometerstand`, `mietvertragID`) VALUES
(1, 1, '2022-05-23', 100, 'neutral', NULL, 20000, 1),
(2, 2, '2022-05-23', 65, 'sauber', NULL, 4000, 2);

--
-- Daten für Tabelle `tarife`
--

INSERT INTO `tarife` (`tarifID`, `tarifBez`, `tarifPreis`) VALUES
(1, 'Tarif 1', 500),
(2, 'Tarif 2', 1000),
(3, 'Tarif 3', 250),
(4, 'Tarif 4', 300);

--
-- Daten für Tabelle `vertraege`
--

INSERT INTO `vertraege` (`vertragID`, `datum`, `kundeID`, `kfzID`) VALUES
(1, '2022-05-23', 1, 1),
(2, '2022-05-23', 3, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
