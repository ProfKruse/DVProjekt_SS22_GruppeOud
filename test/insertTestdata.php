<?php
require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
$connection = new \PDO("mysql:host=localhost;dbname=autovermietung_test;", "root", "", array(
    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
if(!$con) {
    echo "Es konnte keine Verbindung hergestellt werden!".mysqli_connect_errno();   
    die();
}
$sqlStatements = "LOAD DATA LOCAL INFILE 'D:/STUDIUM/Semester/4/Module/DV Projekt/Projekt/testdata/dataset.xml'
INTO TABLE tarife
CHARACTER SET binary
LINES STARTING BY '<record>' TERMINATED BY '</record>'
(@record)
SET tarifID = ExtractValue(@record:=CONVERT(@record using utf8), 'tarifID')";

echo "<br>".!$connection->query($sqlStatements);
?>