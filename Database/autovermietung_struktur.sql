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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kfztypen`
--

CREATE TABLE `kfztypen` (
  `kfzTypID` int(11) NOT NULL,
  `typBezeichnung` varchar(45) NOT NULL,
  `tarifID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunden`
--

CREATE TABLE `kunden` (
  `kundeID` int(11) NOT NULL,
  `strasse` varchar(45) NOT NULL,
  `hausNr` int(11) NOT NULL,
  `plz` int(11) NOT NULL,
  `land` varchar(45) NOT NULL,
  `iban` varchar(45) NOT NULL,
  `bic` varchar(45) NOT NULL,
  `telefonNr` varchar(45) NOT NULL,
  `emailAdresse` varchar(45) NOT NULL,
  `kontostand` double NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pseudo` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `validatedAccount` tinyint(1) DEFAULT NULL,
  `codeResetPassword` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mietstationen`
--

CREATE TABLE `mietstationen` (
  `mietstationID` int(11) NOT NULL,
  `mietstationTyp` varchar(45) NOT NULL,
  `stellplaetze` int(11) NOT NULL,
  `lage` varchar(45) NOT NULL,
  `groesse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mietstationen_mietwagenbestaende`
--

CREATE TABLE `mietstationen_mietwagenbestaende` (
  `kfzID` int(11) NOT NULL,
  `mietstationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `vertragID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `mahnstatus` enum('keine','erste Mahnung','zweite Mahnung') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservierungen`
--

CREATE TABLE `reservierungen` (
  `kundeID` int(11) NOT NULL,
  `kfzTypID` int(11) NOT NULL,
  `mietstationID` int(11) NOT NULL,
  `status` enum('bestätigt','aktiv','storniert','abgeschlossen','in bearbeitung') NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `kilometerstand` float NOT NULL,
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
  ADD KEY `mietwagenbestaende_kfzTypID_idx` (`kfzID`),
  ADD KEY `mietwagenbestaende_mietstationID_idx` (`mietstationID`);

--
-- Indizes für die Tabelle `mietvertraege`
--
ALTER TABLE `mietvertraege`
  ADD PRIMARY KEY (`mietvertragID`,`vertragID`),
  ADD KEY `mietvertraege_abholstation_idx` (`abholstation`),
  ADD KEY `mietvertraege_rueckgabestation_idx` (`rueckgabestation`),
  ADD KEY `mietvertraege_vertragID_idx` (`vertragID`);

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
  ADD PRIMARY KEY (`kundeID`,`kfzTypID`,`mietstationID`),
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
  ADD CONSTRAINT `mietwagenbestaende_kfzTypID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`),
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
