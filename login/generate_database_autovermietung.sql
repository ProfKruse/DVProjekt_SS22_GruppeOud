CREATE TABLE `extras` (
  `ausstattungID` int NOT NULL,
  `ausstattungBez` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ausstattungID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tarife` (
  `tarifID` int NOT NULL,
  `tarifBez` varchar(45) DEFAULT NULL,
  `tarifPreis` double DEFAULT NULL,
  PRIMARY KEY (`tarifID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kfztypen` (
  `kfzTypID` int NOT NULL,
  `typBezeichnung` varchar(45) DEFAULT NULL,
  `tarifID` int NOT NULL,
  PRIMARY KEY (`kfzTypID`),
  KEY `tarifID_idx` (`tarifID`),
  CONSTRAINT `kfztypen_tarifID` FOREIGN KEY (`tarifID`) REFERENCES `tarife` (`tarifID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kfzs` (
  `kfzID` int NOT NULL,
  `marke` varchar(45) DEFAULT NULL,
  `modell` varchar(45) DEFAULT NULL,
  `standardRate` double DEFAULT NULL,
  `kfzTypID` int NOT NULL,
  `gesamtnote` int DEFAULT NULL,
  `lackZustand` int DEFAULT NULL,
  `innenraumNote` int DEFAULT NULL,
  `technikZustandNote` int DEFAULT NULL,
  `anmerkungen` varchar(45) DEFAULT NULL,
  `kilometerStand` int DEFAULT NULL,
  `kennzeichen` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`kfzID`),
  CONSTRAINT `kfzs_kfzTypID` FOREIGN KEY (`kfzID`) REFERENCES `kfztypen` (`kfzTypID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kfzs_extras` (
  `kfzID` int NOT NULL,
  `ausstattungID` int NOT NULL,
  PRIMARY KEY (`kfzID`,`ausstattungID`),
  KEY `extras_ausstattungID_idx` (`ausstattungID`),
  CONSTRAINT `extras_ausstattungID` FOREIGN KEY (`ausstattungID`) REFERENCES `extras` (`ausstattungID`),
  CONSTRAINT `extras_kfzID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kunden` (
 `creationDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
 `updateDate` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kundeID` int NOT NULL AUTO_INCREMENT,
  `vorname` varchar(45) DEFAULT NULL,
  `nachname` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `validatedAccount` Boolean DEFAULT NULL,
  `codeResetPassword` varchar(45) DEFAULT NULL,
  `strasse` varchar(45) DEFAULT NULL,
  `hausNr` varchar(4) DEFAULT NULL,
  `plz` int DEFAULT NULL,
  `ort` varchar(45) DEFAULT NULL,
  `land` varchar(45) DEFAULT NULL,
  `iban` varchar(45) DEFAULT NULL,
  `bic` varchar(45) DEFAULT NULL,
  `telefonNr` varchar(45) DEFAULT NULL,
  `emailAdresse` varchar(45) DEFAULT NULL,
  `kontostand` double DEFAULT NULL,
  PRIMARY KEY (`kundeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mietstationen` (
  `mietstationID` int NOT NULL,
  `mietstationTyp` varchar(45) DEFAULT NULL,
  `stellplaetze` int DEFAULT NULL,
  `lage` varchar(45) DEFAULT NULL,
  `groesse` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`mietstationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mietstationen_mietwagenbestaende` (
  `kfzID` int NOT NULL,
  `mietstationID` int NOT NULL,
  KEY `mietwagenbestaende_kfzTypID_idx` (`kfzID`),
  KEY `mietwagenbestaende_mietstationID_idx` (`mietstationID`),
  CONSTRAINT `mietwagenbestaende_kfzTypID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`),
  CONSTRAINT `mietwagenbestaende_mietstationID` FOREIGN KEY (`mietstationID`) REFERENCES `mietstationen` (`mietstationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `vertraege` (
  `vertragID` int NOT NULL,
  `datum` date DEFAULT NULL,
  `kundeID` int NOT NULL,
  `kfzID` int NOT NULL,
  PRIMARY KEY (`vertragID`),
  KEY `kundeID_idx` (`kundeID`),
  KEY `vertraege_kfzID_idx` (`kfzID`),
  CONSTRAINT `vertraege_kfzID` FOREIGN KEY (`kfzID`) REFERENCES `kfzs` (`kfzID`),
  CONSTRAINT `vertraege_kundeID` FOREIGN KEY (`kundeID`) REFERENCES `kunden` (`kundeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mietvertraege` (
  `mietvertragID` int NOT NULL,
  `status` enum('bestätigt','aktiv','storniert','abgeschlossen','in bearbeitung') DEFAULT NULL,
  `mietdauerTage` int DEFAULT NULL,
  `mietgebuehr` double DEFAULT NULL,
  `zahlart` varchar(45) DEFAULT NULL,
  `tarif` varchar(45) DEFAULT NULL,
  `abholstation` int NOT NULL,
  `rueckgabestation` int NOT NULL,
  `vertragID` int NOT NULL,
  PRIMARY KEY (`mietvertragID`,`vertragID`),
  KEY `mietvertraege_abholstation_idx` (`abholstation`),
  KEY `mietvertraege_rueckgabestation_idx` (`rueckgabestation`),
  KEY `mietvertraege_vertragID_idx` (`vertragID`),
  CONSTRAINT `mietvertraege_abholstation` FOREIGN KEY (`abholstation`) REFERENCES `mietstationen` (`mietstationID`),
  CONSTRAINT `mietvertraege_rueckgabestation` FOREIGN KEY (`rueckgabestation`) REFERENCES `mietstationen` (`mietstationID`),
  CONSTRAINT `mietvertraege_vertragID` FOREIGN KEY (`vertragID`) REFERENCES `vertraege` (`vertragID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mitarbeiter` (
  `mitarbeiterID` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `vorname` varchar(45) DEFAULT NULL,
  `geburtsDatum` date DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `abteilung` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`mitarbeiterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `aktuellePersonalplaene` (
  `personalplanID` int NOT NULL,
  `erstellDatum` date DEFAULT NULL,
  `gueltigBis` date DEFAULT NULL,
  `mitarbeiterID` int NOT NULL,
  `ersteller` int NOT NULL,
  PRIMARY KEY (`personalplanID`),
  KEY `aktuellePersonalplaene_mitarbeiterID_idx` (`mitarbeiterID`),
  KEY `aktuellePersonalplaene_ersteller_idx` (`ersteller`),
  CONSTRAINT `aktuellePersonalplaene_mitarbeiterID` FOREIGN KEY (`mitarbeiterID`) REFERENCES `mitarbeiter` (`mitarbeiterID`),
  CONSTRAINT `aktuellePersonalplaene_ersteller` FOREIGN KEY (`ersteller`) REFERENCES `mitarbeiter` (`mitarbeiterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `protokolle` (
  `protokollID` int NOT NULL,
  `protokollArt` varchar(45) DEFAULT NULL,
  `protokollDatum` date DEFAULT NULL,
  `ersteller` int DEFAULT NULL,
  `versionsNr` int DEFAULT NULL,
  PRIMARY KEY (`protokollID`),
  KEY `protokolle_ersteller_idx` (`ersteller`),
  CONSTRAINT `protokolle_ersteller` FOREIGN KEY (`ersteller`) REFERENCES `mitarbeiter` (`mitarbeiterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rechnungen` (
  `rechnungNr` int NOT NULL,
  `mietvertragID` int NOT NULL,
  `kundeID` int NOT NULL,
  `rechnungDatum` date DEFAULT NULL,
  `rechnungBetrag` double DEFAULT NULL,
  `mahnstatus` enum('keine','erste Mahnung','zweite Mahnung') DEFAULT NULL,
  PRIMARY KEY (`rechnungNr`),
  KEY `kundeID_idx` (`kundeID`),
  KEY `rechnungen_mietvertragID_idx` (`mietvertragID`),
  CONSTRAINT `rechnungen_kundeID` FOREIGN KEY (`kundeID`) REFERENCES `kunden` (`kundeID`),
  CONSTRAINT `rechnungen_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ruecknahmeprotokolle` (
  `ruecknahmeProtokollID` int NOT NULL,
  `mietvertragID` int NOT NULL,
  `protokollID` int NOT NULL,
  PRIMARY KEY (`ruecknahmeProtokollID`,`protokollID`),
  KEY `ruecknahmeProtokoll_mietvertragID_idx` (`mietvertragID`),
  KEY `ruecknahmeProtokolle_protokollID_idx` (`protokollID`),
  CONSTRAINT `ruecknahmeprotokolle_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`),
  CONSTRAINT `ruecknahmeprotokolle_protokollID` FOREIGN KEY (`protokollID`) REFERENCES `protokolle` (`protokollID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ruecknahmeprotokolle_maengel` (
  `ruecknahmeProtokollID` int NOT NULL,
  KEY `maengel_ruecknahmeProtokollID_idx` (`ruecknahmeProtokollID`),
  CONSTRAINT `maengel_ruecknahmeProtokollID` FOREIGN KEY (`ruecknahmeProtokollID`) REFERENCES `ruecknahmeprotokolle` (`ruecknahmeProtokollID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
