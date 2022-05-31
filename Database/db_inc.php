<?php
/* Host name of the MySQL server */
$host = 'localhost';

/* MySQL account username */
$user = 'root';

/* MySQL account password */
$passwd = '';

/* The schema you want to use */
$schema = 'autovermietung';

/* Connection with MySQLi, procedural-style */
$con = mysqli_connect($host, $user, $passwd, $schema);

/* Check if the connection succeeded */
if (!$con)
{
   echo 'Connection failed<br>';
   echo 'Error number: ' . mysqli_connect_errno() . '<br>';
   echo 'Error message: ' . mysqli_connect_error() . '<br>';
   die();
}

function databaseSelectQuery($spalte, $tabelle, $bedingung) {
    global $con; 

    $result = $con->query("SELECT $spalte FROM $tabelle $bedingung");
    $array = array();
    
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($array, $row[$spalte]);
        }
    }
    $result->free_result();

    return $array;
}

function getUserData() {
    if(!isset($_SESSION)) { session_start(); } 

    global $con;
    $result;

    if(!isset($_SESSION['pseudo'])) {
        return null;
    }

    $result = $con->query("SELECT * FROM kunden WHERE pseudo='".$_SESSION['pseudo']."'");

    $data = array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data["kundeID"] = $row["kundeID"];
            $data["vorname"] = $row["vorname"];
            $data["nachname"] = $row["nachname"];
            $data["strasse"] = $row["strasse"];
            $data["hausNr"] = $row["hausNr"];
            $data["plz"] = $row["plz"];
            $data["stadt"] = $row["stadt"];
            $data["land"] = $row["land"];
            $data["iban"] = $row["iban"];
            $data["bic"] = $row["bic"];
            $data["telefonNr"] = $row["telefonNr"];
            $data["emailAdresse"] = $row["emailAdresse"];
            $data["kontostand"] = $row["kontostand"];
            $data["sammelrechnungen"] = $row["sammelrechnungen"];
            $data["zahlungszielTage"] = $row["zahlungszielTage"];
        }
    }

    return $data;
}

?>