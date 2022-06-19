LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/tarife.csv' 
INTO TABLE tarife 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kunden.csv' 
INTO TABLE kunden (column1, @dummy, column2, @dummy, column3)
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mitarbeiter.csv' 
INTO TABLE mitarbeiter 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietstationen.csv' 
INTO TABLE mietstationen 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/aktuellepersonalplaene.csv' 
INTO TABLE aktuellepersonalplaene 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kfztypen.csv' 
INTO TABLE kfztypen 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/kfzs.csv' 
INTO TABLE kfzs 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietstation_mietwagenbestaende.csv' 
INTO TABLE mietstation_mietwagenbestaende 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/reservierungen.csv' 
INTO TABLE reservierungen 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/vertraege.csv' 
INTO TABLE vertraege 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/mietvertraege.csv' 
INTO TABLE mietvertraege 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/rechnungen.csv' 
INTO TABLE rechnungen 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/ruecknahmeprotokolle.csv' 
INTO TABLE ruecknahmeprotokolle 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;