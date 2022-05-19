<?php
    session_start();
    include_once(__DIR__ . "\global.php");
    $_SESSION["kfztyp"] = $_POST["kfztyp"];
    $_SESSION["abholstation"] = $_POST["abholstation"];
    $_SESSION["abgabestation"] = $_POST["abgabestation"];
    $_SESSION["message"] = $_POST["message"];
    $_SESSION["vorname"] = "Vorname";
    $_SESSION["nachname"] = "Nachname";
    $_SESSION["telefonnr"] = "1234567890";
    $_SESSION["email"] = "vorname.nachname@gmail.com";

    $kfzids = databaseSelectQuery("kfzID","kfzs","WHERE kfzTypID = ".$_SESSION['kfztyp']);
    $verfugbare_autos = array();
    if (count($kfzids) > 0) {
        $verfugbare_autos = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende","WHERE mietstationID = ".$_SESSION['abholstation']." AND kfzID IN (".implode(',',$kfzids).")");
    }

    count($verfugbare_autos) > 0 ?  header("Location:reservation_success.php") : header("Location:reservation_failure.php");   
?>    