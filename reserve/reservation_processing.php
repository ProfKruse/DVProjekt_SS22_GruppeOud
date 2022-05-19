<?php
    session_start();
    $_SESSION["kfztyp"] = $_POST["kfztyp"];
    $_SESSION["abholstation"] = $_POST["abholstation"];
    $_SESSION["abgabestation"] = $_POST["abgabestation"];
    $_SESSION["message"] = $_POST["message"];

    $connection = new mysqli("localhost","root","","autovermietung");
    if($connection->connect_error) {
        die("Es konnte keine Verbindung zur Datenbank aufgebaut werden");
            }

    $result = $connection->query("SELECT * FROM mietstationen_mietwagenbestaende ".
                                " WHERE mietstationID = ".$_SESSION['abholstation'].
                                " AND kfzID = ANY(SELECT DISTINCT kfzID FROM kfzs WHERE kfzTypID=".$_SESSION['kfztyp'].")");
    
    ($result->fetch_array() == null) ? header("Location:reservation_failure.php") : header("Location:reservation_success.php");   
    
    $result->free_result();
    $connection->close();
?>    