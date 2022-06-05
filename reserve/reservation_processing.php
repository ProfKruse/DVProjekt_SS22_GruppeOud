<?php   
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");
    $user_data = check_login($con);

    $_SESSION["kfztyp"] = $_POST["kfztyp"];
    $_SESSION["mietstation"] = $_POST["abholstation"];
    $_SESSION["abholstation"] = $_POST["abholstation"];
    $_SESSION["abgabestation"] = $_POST["abgabestation"];
    $_SESSION["message"] = $_POST["message"];

    echo $_SESSION["kfztyp"]." ".$_SESSION["mietstation"]." ".$_SESSION["abholstation"]." ".$_SESSION["abgabestation"];

    $anzahlVerfuegbareAutos = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzID IN (SELECT kfzID FROM kfzs WHERE kfzTypID=".$_SESSION["kfztyp"].")");
    $anzahlReservierteAutos = databaseSelectQuery("kfzTypID","reservierungen","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]);

    $anzahlUebrigeAutos = count($anzahlVerfuegbareAutos)-count($anzahlReservierteAutos);
    $anzahlUebrigeAutos > 0 ?  header("Location:reservation_success.php") : header("Location:reservation_failure.php");   

    //$_SESSION["test"] = implode(",",$anzahlVerfuegbareAutos)." und ".implode(",",$anzahlReservierteAutos)." geben ".$anzahlUebrigeAutos." zurück " ;
/* 
    Fall 1 (Happy Path): 
        Typ: Sportwagen (4)
        Abholstation: Gubener Str. 17 Rosenheim (1)
        Abgabestation: Egal solange wir kein risige Datenmenge in der Datenbankhaben, 
                       da müssen wir checken welche Station nicht voll ist
    
    Fall 2 (Kein KFZ auf der Station verfügbar): 
        Typ: 
        Abholstation: 
        Abgabestation: 

    Fall 2 (Kein Ersatz KFZ verfügbar): 
        Typ: Sportwagen (4)
        Abholstation: 
        Abgabestation: 
*/
?>    

