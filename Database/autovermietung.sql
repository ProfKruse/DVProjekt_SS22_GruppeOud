-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 13. Jun 2022 um 08:56
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 7.4.29

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aktuellepersonalplaene`
--

CREATE TABLE `aktuellepersonalplaene` (
  `personalplanID` int(11) NOT NULL,
  `erstellDatum` date DEFAULT current_timestamp(),
  `gueltigBis` date DEFAULT NULL,
  `mitarbeiterID` int(11) NOT NULL,
  `ersteller` int(11) NOT NULL,
  `abgabestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `aktuellepersonalplaene`
--

INSERT INTO `aktuellepersonalplaene` (`personalplanID`, `erstellDatum`, `gueltigBis`, `mitarbeiterID`, `ersteller`, `abgabestation`) VALUES
(1, '2022-05-23', '2022-06-17', 1, 4, 1),
(2, '2022-05-23', '2022-07-20', 3, 4, 3),
(3, '2022-05-23', '2022-07-04', 2, 1, 4),
(4, '2022-05-23', '2022-07-13', 4, 3, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kfzs`
--

CREATE TABLE `kfzs` (
  `kfzID` int(11) NOT NULL,
  `marke` varchar(45) DEFAULT NULL,
  `modell` varchar(45) DEFAULT NULL,
  `kfzTypID` int(11) NOT NULL,
  `gesamtnote` int(11) DEFAULT NULL,
  `lackZustand` int(11) DEFAULT NULL,
  `innenraumNote` int(11) DEFAULT NULL,
  `technikZustandNote` int(11) DEFAULT NULL,
  `anmerkungen` varchar(45) DEFAULT NULL,
  `kilometerStand` int(11) DEFAULT NULL,
  `kennzeichen` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kfzs`
--

INSERT INTO `kfzs` (`kfzID`, `marke`, `modell`, `kfzTypID`, `gesamtnote`, `lackZustand`, `innenraumNote`, `technikZustandNote`, `anmerkungen`, `kilometerStand`, `kennzeichen`) VALUES
(1, 'Ford', 'Mustang', 4, 2, 2, 1, 3, NULL, 50, 'WES-DE-12'),
(2, 'Porsche', '911 Carrera', 4, 1, 1, 1, 1, NULL, 0, 'BO-CD-82'),
(3, 'Mercedes', 'GLC', 1, 3, 3, 2, 2, NULL, 50, 'DU-UD-59'),
(4, 'Peugeot', '308 SW', 6, 1, 2, 1, 1, NULL, 2000, 'D-AZ-29');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kfztypen`
--

CREATE TABLE `kfztypen` (
  `kfzTypID` int(11) NOT NULL,
  `typBezeichnung` varchar(45) NOT NULL,
  `tarifID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunden`
--

CREATE TABLE `kunden` (
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kundeID` int(11) NOT NULL,
  `vorname` varchar(45) DEFAULT NULL,
  `nachname` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `validatedAccount` tinyint(1) DEFAULT NULL,
  `token` varchar(45) DEFAULT NULL,
  `strasse` varchar(45) DEFAULT NULL,
  `hausNr` varchar(4) DEFAULT NULL,
  `plz` int(11) DEFAULT NULL,
  `ort` varchar(45) DEFAULT NULL,
  `land` varchar(45) DEFAULT NULL,
  `iban` varchar(45) DEFAULT NULL,
  `bic` varchar(45) DEFAULT NULL,
  `telefonNr` varchar(45) DEFAULT NULL,
  `emailAdresse` varchar(45) DEFAULT NULL,
  `AnzVersuche` int(11) DEFAULT 0,
  `kontostand` double DEFAULT NULL,
  `sammelrechnungen` enum('keine','woechentlich','monatlich','quartalsweise','halbjaehrlich','jaehrlich') CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `zahlungszielTage` int(11) DEFAULT NULL,
  `letzterRechnungsversand` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kunden`
--

INSERT INTO `kunden` (`creationDate`, `updateDate`, `kundeID`, `vorname`, `nachname`, `pseudo`, `password`, `validatedAccount`, `token`, `strasse`, `hausNr`, `plz`, `ort`, `land`, `iban`, `bic`, `telefonNr`, `emailAdresse`, `AnzVersuche`, `kontostand`, `sammelrechnungen`, `zahlungszielTage`) VALUES
('2022-06-06 21:36:06', '2022-06-06 21:36:06', 1, 'Anne', 'Kappel', 'AnneKappel', '$2y$10$ee9GJjP4Z8ecotEEadk4f.NAfLkuicMNlNBNrVzBsZEtZiF9KRYZK', 1, NULL, 'Bleibtreustraße', '34', 82061, 'Berlin', 'Deutschland', 'DE78500105172923411175', 'DE78500105172923411175', '07807 66 60 89', 'AnneKappel@einrot.com', 0, 100, 'keine', 1),
('2022-06-06 21:36:06', '2022-06-06 21:36:06', 2, 'Sihem', 'Osterman', 'SihemOstermann', '$2y$10$N3lMm01agYLv71ClWzDxdOaufBbbERXvJG1VeqB5uIAyF.tK.8iCy', 1, NULL, 'Neue Roßstraße', '80', 55545, 'Frankfurt', 'Deutschland', 'DE14500105174682434577', 'DE14500105174682434577', '0671 10 14 97', 'SihemOstermann@cuvox.de', 0, 200, 'woechentlich', 7),
('2022-06-06 21:36:06', '2022-06-06 21:36:06', 3, 'Annabell', 'Bader', 'AnnabellBader', '$2y$10$YkHckqRREHQDyCX6KBPy4eDEmJMNxVMXky9rgWvTkaYMm8NUsmZR2', 1, NULL, 'Joachimstaler Straße', '50', 56288, 'Bocholt', 'Deutschland', 'DE18500105179694155718', 'DE18500105179694155718', '06762 13 64 46', 'AnnabellBader@einrot.com', 0, 500, 'monatlich', 14),
('2022-06-06 21:36:06', '2022-06-06 21:36:06', 4, 'Andrea', 'Osterhagen', 'AndreaOsterhagen', '$2y$10$qvK7j7YpGV/bgKHIdgwoeuG7nmI2442/9uhBohPEst3kRDIicethW', 1, NULL, 'Feldstrasse', '63', 39446, 'Vreden', 'Deutschland', 'DE85500105173378848553', 'DE85500105173378848553', ' 039265 38 37', 'AndreaOsterhagen@cuvox.de', 0, 0, 'monatlich', 1),
('2022-06-06 21:51:30', '2022-06-06 23:52:05', 5, 'Sihem', 'Ould Mohand', 'SamCarter', '$2y$10$WHErDa2sEVV8a2.1vs63Lu2oPTNQmJqgzCbyU4gSRasr6tQNSsXne', 1, '16664', 'sdf', 'd', 4, 'd', 'd', 'd', 'd', 'd', 's.ouldmohand@gmail.com', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mietstationen`
--

CREATE TABLE `mietstationen` (
  `mietstationID` int(11) NOT NULL,
  `mietstationTyp` varchar(45) NOT NULL,
  `stellplaetze` int(11) NOT NULL,
  `lage` varchar(45) NOT NULL,
  `groesse` int(11) NOT NULL,
  `beschreibung` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `mietstationen`
--

INSERT INTO `mietstationen` (`mietstationID`, `mietstationTyp`, `stellplaetze`, `lage`, `groesse`, `beschreibung`) VALUES
(1, 'Abholstation', 300, 'Bestlage', 1000, 'Gubener Str. 17 Rosenheim'),
(2, 'Abgabestation', 100, 'einfache Lage', 500, 'Guentzelstrasse 55 Hessen'),
(3, 'Abgabestation', 400, 'durchschnittliche Lage', 1200, 'Ollenhauer Str. 32 Stuttgart'),
(4, 'Abholstation', 750, 'gute Lage', 1600, 'Chausseestr. 95 Pinneberg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mietstationen_mietwagenbestaende`
--

CREATE TABLE `mietstationen_mietwagenbestaende` (
  `kfzID` int(11) NOT NULL,
  `mietstationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `mietstationen_mietwagenbestaende`
--

INSERT INTO `mietstationen_mietwagenbestaende` (`kfzID`, `mietstationID`) VALUES
(1, 1),
(2, 1),
(4, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mietvertraege`
--

CREATE TABLE `mietvertraege` (
  `mietvertragID` int(11) NOT NULL,
  `status` enum('bestätigt','aktiv','storniert','abgeschlossen','in bearbeitung') NOT NULL,
  `mietdauerTage` int(11) NOT NULL,
  `mietgebuehr` double NOT NULL,
  `zahlart` varchar(45) NOT NULL,
  `abholstation` int(11) NOT NULL,
  `rueckgabestation` int(11) NOT NULL,
  `vertragID` int(11) NOT NULL,
  `kundeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `mietvertraege`
--

INSERT INTO `mietvertraege` (`mietvertragID`, `status`, `mietdauerTage`, `mietgebuehr`, `zahlart`, `abholstation`, `rueckgabestation`, `vertragID`, `kundeID`) VALUES
(1, 'bestätigt', 30, 500, 'Kreditkarte', 1, 2, 1, 1),
(2, 'bestätigt', 60, 2500, 'Rechnung', 4, 3, 2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitarbeiter`
--

CREATE TABLE `mitarbeiter` (
  `mitarbeiterID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `vorname` varchar(45) NOT NULL,
  `geburtsDatum` date NOT NULL,
  `position` varchar(45) NOT NULL,
  `abteilung` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`mitarbeiterID`, `name`, `vorname`, `geburtsDatum`, `position`, `abteilung`) VALUES
(1, 'Pascal', 'Ewald', '2001-01-01', 'Abteilungsleiter', 'Verwaltung'),
(2, 'Tim', 'Middeke', '2002-02-02', 'Schichtleiter', 'Vertrieb'),
(3, 'Bastian', 'Oymanns', '2003-03-03', 'Sales Manager', 'Vertrieb'),
(4, 'Julian ', 'Eckerskorn', '2005-05-05', 'Geschäftsführer', 'Geschäftsführung');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rechnungen`
--

CREATE TABLE `rechnungen` (
  `rechnungNr` int(11) NOT NULL,
  `mietvertragID` int(11) NOT NULL,
  `kundeID` int(11) NOT NULL,
  `rechnungDatum` date NOT NULL DEFAULT current_timestamp(),
  `rechnungBetrag` double NOT NULL,
  `mahnstatus` enum('keine','erste Mahnung','zweite Mahnung') NOT NULL,
  `zahlungslimit` date DEFAULT NULL,
  `bezahltAm` date DEFAULT NULL,
  `versanddatum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rechnungen`
--

INSERT INTO `rechnungen` (`rechnungNr`, `mietvertragID`, `kundeID`, `rechnungDatum`, `rechnungBetrag`, `mahnstatus`, `zahlungslimit`, `bezahltAm`) VALUES
(1, 1, 1, '2022-05-23', 500, 'keine', NULL, NULL),
(2, 2, 3, '2022-05-23', 2500, 'keine', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservierungen`
--

CREATE TABLE `reservierungen` (
  `reservierungID` int(11) NOT NULL,
  `kundeID` int(11) NOT NULL,
  `kfzTypID` int(11) NOT NULL,
  `mietstationID` int(11) NOT NULL,
  `status` enum('bestätigt','aktiv','storniert','abgeschlossen','in bearbeitung') NOT NULL,
  `datum` date NOT NULL,
  `Mietbeginn` date NOT NULL,
  `Mietende` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `reservierungen`
--

INSERT INTO `reservierungen` (`reservierungID`, `kundeID`, `kfzTypID`, `mietstationID`, `status`, `datum`, `Mietbeginn`, `Mietende`) VALUES
(65, 5, 4, 1, 'bestätigt', '2022-06-11', '2022-06-11', '2022-06-11'),
(66, 5, 4, 1, 'bestätigt', '2022-06-11', '2022-06-11', '2022-06-11'),
(67, 5, 4, 1, 'bestätigt', '2022-06-12', '2022-06-12', '2022-06-12'),
(68, 5, 4, 1, 'bestätigt', '2022-06-12', '2022-06-12', '2022-06-12');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ruecknahmeprotokolle`
--

CREATE TABLE `ruecknahmeprotokolle` (
  `ruecknahmeprotokollID` int(11) NOT NULL,
  `ersteller` int(11) NOT NULL,
  `protokollDatum` date NOT NULL DEFAULT current_timestamp(),
  `tank` float NOT NULL,
  `sauberkeit` enum('sehr schmutzig','leicht schmutzig','neutral','sauber','sehr sauber') NOT NULL,
  `mechanik` varchar(45) DEFAULT NULL,
  `kilometerstand` int(11) NOT NULL,
  `mietvertragID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tarife`
--

CREATE TABLE `tarife` (
  `tarifID` int(11) NOT NULL,
  `tarifBez` varchar(45) NOT NULL,
  `tarifPreis` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tarife`
--

INSERT INTO `tarife` (`tarifID`, `tarifBez`, `tarifPreis`) VALUES
(1, 'Tarif 1', 500),
(2, 'Tarif 2', 1000),
(3, 'Tarif 3', 250),
(4, 'Tarif 4', 300);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vertraege`
--

CREATE TABLE `vertraege` (
  `vertragID` int(11) NOT NULL,
  `datum` date NOT NULL DEFAULT current_timestamp(),
  `kundeID` int(11) NOT NULL,
  `kfzID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `vertraege`
--

INSERT INTO `vertraege` (`vertragID`, `datum`, `kundeID`, `kfzID`) VALUES
(1, '2022-05-23', 1, 1),
(2, '2022-05-23', 3, 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `aktuellepersonalplaene`
--
ALTER TABLE `aktuellepersonalplaene`
  ADD PRIMARY KEY (`personalplanID`),
  ADD UNIQUE KEY `aktuellepersonalplaene_abgabestation_idx` (`abgabestation`),
  ADD KEY `aktuellePersonalplaene_mitarbeiterID_idx` (`mitarbeiterID`),
  ADD KEY `aktuellePersonalplaene_ersteller_idx` (`ersteller`);

--
-- Indizes für die Tabelle `kfzs`
--
ALTER TABLE `kfzs`
  ADD PRIMARY KEY (`kfzID`),
  ADD KEY `kfzs_kfzTypID` (`kfzTypID`);

--
-- Indizes für die Tabelle `kfztypen`
--
ALTER TABLE `kfztypen`
  ADD PRIMARY KEY (`kfzTypID`),
  ADD KEY `kfztypen_tarifID_idx` (`tarifID`);

--
-- Indizes für die Tabelle `kunden`
--
ALTER TABLE `kunden`
  ADD PRIMARY KEY (`kundeID`);

--
-- Indizes für die Tabelle `mietstationen`
--
ALTER TABLE `mietstationen`
  ADD PRIMARY KEY (`mietstationID`);

--
-- Indizes für die Tabelle `mietstationen_mietwagenbestaende`
--
ALTER TABLE `mietstationen_mietwagenbestaende`
  ADD UNIQUE KEY `mietstationen_mietwagenbestaende_kfzID` (`kfzID`),
  ADD KEY `mietwagenbestaende_mietstationID_idx` (`mietstationID`),
  ADD KEY `mietwagenbestaende_kfzID_idx` (`kfzID`) USING BTREE;

--
-- Indizes für die Tabelle `mietvertraege`
--
ALTER TABLE `mietvertraege`
  ADD PRIMARY KEY (`mietvertragID`,`vertragID`),
  ADD KEY `mietvertraege_abholstation_idx` (`abholstation`),
  ADD KEY `mietvertraege_rueckgabestation_idx` (`rueckgabestation`),
  ADD KEY `mietvertraege_vertragID_idx` (`vertragID`),
  ADD KEY `mietvertraege_kundeID_idx` (`kundeID`);

--
-- Indizes für die Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  ADD PRIMARY KEY (`mitarbeiterID`);

--
-- Indizes für die Tabelle `rechnungen`
--
ALTER TABLE `rechnungen`
  ADD PRIMARY KEY (`rechnungNr`),
  ADD KEY `rechnungen_kundeID_idx` (`kundeID`),
  ADD KEY `rechnungen_mietvertragID_idx` (`mietvertragID`);

--
-- Indizes für die Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD PRIMARY KEY (`reservierungID`),
  ADD KEY `reservierungen_kfzTypID_idx` (`kfzTypID`),
  ADD KEY `reservierungen_mietstationID_idx` (`mietstationID`),
  ADD KEY `reservierungen_kundeID_idx` (`kundeID`) USING BTREE;

--
-- Indizes für die Tabelle `ruecknahmeprotokolle`
--
ALTER TABLE `ruecknahmeprotokolle`
  ADD PRIMARY KEY (`ruecknahmeprotokollID`),
  ADD UNIQUE KEY `ruecknahmeprotokolle_mietvertragID` (`mietvertragID`),
  ADD KEY `ruecknahmeprotokolle_ersteller` (`ersteller`);

--
-- Indizes für die Tabelle `tarife`
--
ALTER TABLE `tarife`
  ADD PRIMARY KEY (`tarifID`);

--
-- Indizes für die Tabelle `vertraege`
--
ALTER TABLE `vertraege`
  ADD PRIMARY KEY (`vertragID`),
  ADD KEY `vertrage_kundeID_idx` (`kundeID`),
  ADD KEY `vertraege_kfzID_idx` (`kfzID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `aktuellepersonalplaene`
--
ALTER TABLE `aktuellepersonalplaene`
  MODIFY `personalplanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `kfzs`
--
ALTER TABLE `kfzs`
  MODIFY `kfzID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `kfztypen`
--
ALTER TABLE `kfztypen`
  MODIFY `kfzTypID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `kunden`
--
ALTER TABLE `kunden`
  MODIFY `kundeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `mietstationen`
--
ALTER TABLE `mietstationen`
  MODIFY `mietstationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `mietvertraege`
--
ALTER TABLE `mietvertraege`
  MODIFY `mietvertragID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  MODIFY `mitarbeiterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `rechnungen`
--
ALTER TABLE `rechnungen`
  MODIFY `rechnungNr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  MODIFY `reservierungID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT für Tabelle `ruecknahmeprotokolle`
--
ALTER TABLE `ruecknahmeprotokolle`
  MODIFY `ruecknahmeprotokollID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `tarife`
--
ALTER TABLE `tarife`
  MODIFY `tarifID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `vertraege`
--
ALTER TABLE `vertraege`
  MODIFY `vertragID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `aktuellepersonalplaene`
--
ALTER TABLE `aktuellepersonalplaene`
  ADD CONSTRAINT `aktuellePersonalplaene_abgabestation` FOREIGN KEY (`abgabestation`) REFERENCES `mietstationen` (`mietstationID`),
  ADD CONSTRAINT `aktuellePersonalplaene_ersteller` FOREIGN KEY (`ersteller`) REFERENCES `mitarbeiter` (`mitarbeiterID`),
  ADD CONSTRAINT `aktuellePersonalplaene_mitarbeiterID` FOREIGN KEY (`mitarbeiterID`) REFERENCES `mitarbeiter` (`mitarbeiterID`);

--
-- Constraints der Tabelle `kfzs`
--
ALTER TABLE `kfzs`
  ADD CONSTRAINT `kfzs_kfzTypID` FOREIGN KEY (`kfzTypID`) REFERENCES `kfztypen` (`kfzTypID`);

--
-- Constraints der Tabelle `kfztypen`
--
ALTER TABLE `kfztypen`
  ADD CONSTRAINT `kfztypen_tarifID` FOREIGN KEY (`tarifID`) REFERENCES `tarife` (`tarifID`);

--
-- Constraints der Tabelle `mietstationen_mietwagenbestaende`
--
ALTER TABLE `mietstationen_mietwagenbestaende`
  ADD CONSTRAINT `mietwagenbestaende_kfzID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`),
  ADD CONSTRAINT `mietwagenbestaende_mietstationID` FOREIGN KEY (`mietstationID`) REFERENCES `mietstationen` (`mietstationID`);

--
-- Constraints der Tabelle `mietvertraege`
--
ALTER TABLE `mietvertraege`
  ADD CONSTRAINT `mietvertraege_abholstation` FOREIGN KEY (`abholstation`) REFERENCES `mietstationen` (`mietstationID`),
  ADD CONSTRAINT `mietvertraege_rueckgabestation` FOREIGN KEY (`rueckgabestation`) REFERENCES `mietstationen` (`mietstationID`),
  ADD CONSTRAINT `mietvertraege_vertragID` FOREIGN KEY (`vertragID`) REFERENCES `vertraege` (`vertragID`);

--
-- Constraints der Tabelle `rechnungen`
--
ALTER TABLE `rechnungen`
  ADD CONSTRAINT `rechnungen_kundeID` FOREIGN KEY (`kundeID`) REFERENCES `kunden` (`kundeID`),
  ADD CONSTRAINT `rechnungen_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`);

--
-- Constraints der Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD CONSTRAINT `reservierungen_kfzTypID` FOREIGN KEY (`kfzTypID`) REFERENCES `kfztypen` (`kfzTypID`),
  ADD CONSTRAINT `reservierungen_kundeID` FOREIGN KEY (`kundeID`) REFERENCES `kunden` (`kundeID`),
  ADD CONSTRAINT `reservierungen_mietstationID` FOREIGN KEY (`mietstationID`) REFERENCES `mietstationen` (`mietstationID`);

--
-- Constraints der Tabelle `ruecknahmeprotokolle`
--
ALTER TABLE `ruecknahmeprotokolle`
  ADD CONSTRAINT `ruecknahmeprotokolle_ersteller` FOREIGN KEY (`ersteller`) REFERENCES `mitarbeiter` (`mitarbeiterID`),
  ADD CONSTRAINT `ruecknahmeprotokolle_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`);

--
-- Constraints der Tabelle `vertraege`
--
ALTER TABLE `vertraege`
  ADD CONSTRAINT `vertraege_kfzID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`),
  ADD CONSTRAINT `vertraege_kundeID` FOREIGN KEY (`kundeID`) REFERENCES `kunden` (`kundeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
