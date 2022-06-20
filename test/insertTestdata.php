<?php
require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
$connection = new \PDO("mysql:host=localhost;dbname=autovermietung_test;", "root", "", array(
    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
if(!$con) {
    echo "Es konnte keine Verbindung hergestellt werden!".mysqli_connect_errno();   
    die();
}
$sqlStatements = "LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/ruecknahmeprotokolle.xml'
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
mietvertragID  = ExtractValue(@record, 'mietvertragID');";

echo "<br>".!$connection->query($sqlStatements);
?>