LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/tarife.xml'
INTO TABLE tarife
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET tarifID = ExtractValue(@record:=CONVERT(@record using utf8), 'tarifID'),
tarifBez = ExtractValue(@record, 'tarifBez'),
tarifPreis = ExtractValue(@record, 'tarifPreis');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kunden.xml'
INTO TABLE kunden
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET kundeID = ExtractValue(@record:=CONVERT(@record using utf8), 'kundeID'),
creationDate = ExtractValue(@record, 'creationDate'),
updateDate = ExtractValue(@record, 'updateDate'),
vorname = ExtractValue(@record, 'vorname'),
nachname = ExtractValue(@record, 'nachname'),
pseudo = ExtractValue(@record, 'pseudo'),
password = ExtractValue(@record, 'password'),
validatedAccount = ExtractValue(@record, 'validatedAccount'),
token = ExtractValue(@record, 'token'),
strasse = ExtractValue(@record, 'strasse'),
hausNr = ExtractValue(@record, 'hausNr'),
plz = ExtractValue(@record, 'plz'),
ort = ExtractValue(@record, 'ort'),
land = ExtractValue(@record, 'land'),
iban = ExtractValue(@record, 'iban'),
bic = ExtractValue(@record, 'bic'),
telefonNr = ExtractValue(@record, 'telefonNr'),
emailAdresse = ExtractValue(@record, 'emailAdresse'),
AnzVersuche = ExtractValue(@record, 'AnzVersuche'),
kontostand = ExtractValue(@record, 'kontostand'),
sammelrechnungen = ExtractValue(@record, 'sammelrechnungen'),
zahlungszielTage = ExtractValue(@record, 'zahlungszielTage');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mitarbeiter.xml'
INTO TABLE mitarbeiter
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET mitarbeiterID  = ExtractValue(@record:=CONVERT(@record using utf8), 'mitarbeiterID'),
creationDate = ExtractValue(@record, 'creationDate'),
updateDate = ExtractValue(@record, 'updateDate'),
nachname = ExtractValue(@record, 'nachname'),
vorname = ExtractValue(@record, 'vorname'),
geburtsDatum = ExtractValue(@record, 'geburtsDatum'),
position = ExtractValue(@record, 'position'),
abteilung = ExtractValue(@record, 'abteilung'),
pseudo = ExtractValue(@record, 'pseudo'),
password = ExtractValue(@record, 'password'),
validatedAccount = ExtractValue(@record, 'validatedAccount'),
token = ExtractValue(@record, 'token'),
AnzVersuche = ExtractValue(@record, 'AnzVersuche'),
emailAdresse = ExtractValue(@record, 'emailAdresse');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietstationen.xml'
INTO TABLE mietstationen
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET mietstationID  = ExtractValue(@record:=CONVERT(@record using utf8), 'mietstationID'),
mietstationTyp = ExtractValue(@record, 'mietstationTyp'),
stellplaetze = ExtractValue(@record, 'stellplaetze'),
lage = ExtractValue(@record, 'lage'),
groesse = ExtractValue(@record, 'groesse'),
beschreibung = ExtractValue(@record, 'beschreibung');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/aktuellePersonalplaene.xml'
INTO TABLE aktuellepersonalplaene
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET personalplanID = ExtractValue(@record:=CONVERT(@record using utf8), 'personalplanID'),
creationDate = ExtractValue(@record, 'creationDate'),
updateDate = ExtractValue(@record, 'updateDate'),
erstellDatum = ExtractValue(@record, 'erstellDatum'),
gueltigBis = ExtractValue(@record, 'gueltigBis'),
mitarbeiterID = ExtractValue(@record, 'mitarbeiterID'),
ersteller = ExtractValue(@record, 'ersteller'),
abgabestation = ExtractValue(@record, 'abgabestation');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kfztypen.xml'
INTO TABLE kfztypen
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET kfzTypID  = ExtractValue(@record:=CONVERT(@record using utf8), 'kfzTypID'),
typBezeichnung = ExtractValue(@record, 'typBezeichnung'),
tarifID = ExtractValue(@record, 'tarifID');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kfzs.xml'
INTO TABLE kfzs
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET kfzID  = ExtractValue(@record:=CONVERT(@record using utf8), 'kfzID'),
marke = ExtractValue(@record, 'marke'),
modell = ExtractValue(@record, 'modell'),
kfzTypID  = ExtractValue(@record, 'kfzTypID'),
gesamtnote = ExtractValue(@record, 'gesamtnote'),
lackZustand = ExtractValue(@record, 'lackZustand'),
innenraumNote = ExtractValue(@record, 'innenraumNote'),
technikZustandNote = ExtractValue(@record, 'technikZustandNote'),
anmerkungen = ExtractValue(@record, 'anmerkungen'),
kilometerStand = ExtractValue(@record, 'kilometerStand'),
kennzeichen = ExtractValue(@record, 'kennzeichen');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietstationen_mietwagenbestaende.xml'
INTO TABLE mietstationen_mietwagenbestaende
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET kfzID  = ExtractValue(@record:=CONVERT(@record using utf8), 'kfzID'),
mietstationID  = ExtractValue(@record, 'mietstationID');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/reservierungen.xml'
INTO TABLE reservierungen
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET reservierungID = ExtractValue(@record:=CONVERT(@record using utf8), 'reservierungID'),
kundeID = ExtractValue(@record, 'kundeID'),
kfzTypID = ExtractValue(@record, 'kfzTypID'),
mietstationID = ExtractValue(@record, 'mietstationID'),
abgabestationID = ExtractValue(@record, 'abgabestationID'),
status = ExtractValue(@record, 'status'),
datum = ExtractValue(@record, 'datum'),
Mietbeginn = ExtractValue(@record, 'Mietbeginn'),
Mietende = ExtractValue(@record, 'Mietende'),
message = ExtractValue(@record, 'message');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/vertraege.xml'
INTO TABLE vertraege
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET vertragID = ExtractValue(@record:=CONVERT(@record using utf8), 'vertragID'),
datum = ExtractValue(@record, 'datum'),
kundeID = ExtractValue(@record, 'kundeID'),
kfzID = ExtractValue(@record, 'kfzID');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietvertraege.xml'
INTO TABLE mietvertraege
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET mietvertragID = ExtractValue(@record:=CONVERT(@record using utf8), 'mietvertragID'),
status = ExtractValue(@record, 'status'),
mietdauerTage = ExtractValue(@record, 'mietdauerTage'),
mietgebuehr = ExtractValue(@record, 'mietgebuehr'),
abholstation = ExtractValue(@record, 'abholstation'),
rueckgabestation = ExtractValue(@record, 'rueckgabestation'),
vertragID = ExtractValue(@record, 'vertragID'),
kundeID = ExtractValue(@record, 'kundeID');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/rechnungen.xml'
INTO TABLE rechnungen
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET rechnungNr = ExtractValue(@record:=CONVERT(@record using utf8), 'rechnungNr'),
mietvertragID = ExtractValue(@record, 'mietvertragID'),
kundeID = ExtractValue(@record, 'kundeID'),
rechnungDatum = ExtractValue(@record, 'rechnungDatum'),
rechnungBetrag = ExtractValue(@record, 'rechnungBetrag'),
mahnstatus = ExtractValue(@record, 'mahnstatus'),
zahlungslimit = ExtractValue(@record, 'zahlungslimit'),
versanddatum = ExtractValue(@record, 'versanddatum');

LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/ruecknahmeprotokolle.xml'
INTO TABLE ruecknahmeprotokolle
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET ruecknahmeprotokollID  = ExtractValue(@record:=CONVERT(@record using utf8), 'ruecknahmeprotokollID'),
ersteller  = ExtractValue(@record, 'ersteller'),
protokollDatum = ExtractValue(@record, 'protokollDatum'),
tank = ExtractValue(@record, 'tank'),
sauberkeit = ExtractValue(@record, 'sauberkeit'),
kilometerstand = ExtractValue(@record, 'kilometerstand'),
mietvertragID  = ExtractValue(@record, 'mietvertragID');