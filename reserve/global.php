<?php
    function databaseSelectQuery($spalte, $tabelle, $bedingung) {
        $connection = new mysqli("localhost","root","","autovermietung");
        if($connection->connect_error) {
            die("Es konnte keine Verbindung zur Datenbank aufgebaut werden");
            }

        $result = $connection->query("SELECT $spalte FROM $tabelle $bedingung");
        $array = array();
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($array, $row[$spalte]);
            }
        }
        $result->free_result();
        $connection->close();

        return $array;
    }
?>