<?php
    if(!isset($_SESSION)) { session_start(); } 
    require_once("../Database/db_inc.php");
    $_SESSION["pseudo"] = "SvenKappel";
    $_SESSION["kfztyp"] = $_POST["kfztyp"];
    $_SESSION["mietstation"] = $_POST["abholstation"];
    $_SESSION["abholstation"] = $_POST["abholstation"];
    $_SESSION["abgabestation"] = $_POST["abgabestation"];
    $_SESSION["message"] = $_POST["message"];

    /* 
        Prüft die Anzahl der verfügbaren Autos eines konkreten Typs und die Anzahl der bereits reservierten Kfz von diesem Typ und berechnet anhand ob
        vom konkreten Kfz-Typ noch ein Auto in der Abholstation zur Verfügung steht
        Fallunterscheidung: Positiver Fall: Aufruf der Seite zur erfolgreichen Bestätigung der Reservierungsmöglichkeit
                            Negativer Fall: Aufruf der Seite zur Ausgabe des negativen Überprüfungsergebnisses
    */
    $anzahlVerfuegbareAutos = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzID IN (SELECT kfzID FROM kfzs WHERE kfzTypID=".$_SESSION["kfztyp"].")");
    $anzahlReservierteAutos = databaseSelectQuery("kfzTypID","reservierungen","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]);

    $anzahlUebrigeAutos = count($anzahlVerfuegbareAutos)-count($anzahlReservierteAutos);
    $anzahlUebrigeAutos > 0 ?  header("Location:reservation_success.php") : header("Location:reservation_failure.php");   
?>    