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
    $_SESSION["Mietbeginn"] = strval($_POST["Mietbeginn"]);
    $_SESSION["Mietende"] = strval($_POST["Mietende"]);
    $_SESSION["kfzTypBezeichnung"]= databaseSelectQuery("typBezeichnung","kfztypen","WHERE kfzTypID=".$_SESSION["kfztyp"]);
    $_SESSION ['abholstationBezeichnung'] =  databaseSelectQuery("beschreibung","mietstationen","WHERE mietstationID=".$_SESSION["abholstation"]);

    $anzahlVerfuegbareAutos = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende","WHERE mietstationID = ".$_SESSION['abholstation']." AND kfzID IN (SELECT kfzID FROM kfzs WHERE kfzTypID=".$_SESSION["kfztyp"].")");
    $anzahlReservierteAutos = databaseSelectQuery("kfzTypID","reservierungen","WHERE (mietstationID = ".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]." AND Mietende >= '".$_SESSION['Mietbeginn']."') AND (mietstationID = ".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]." AND Mietbeginn <= '".$_SESSION['Mietende']."')");  
    $totavailableKfz = databaseSelectQuery("kfzTypID","reservierungen","WHERE (mietstationID = ".$_SESSION['abholstation']." AND Mietende >= '".$_SESSION['Mietbeginn']."') AND (mietstationID = ".$_SESSION['abholstation']."  AND Mietbeginn <= '".$_SESSION['Mietende']."')");  
    
    $_SESSION["anzahlVerfuegbareAutos"] = count($anzahlVerfuegbareAutos);
    $_SESSION["anzahlReservierteAutos"] = count($anzahlReservierteAutos);
    $_SESSION["totavailableKfz"] = count($totavailableKfz);
    
    $anzahlUebrigeAutos = count($anzahlVerfuegbareAutos)-count($anzahlReservierteAutos);
    $anzahlUebrigeAutos > 0 ?  header("Location:reservation_success.php") : header("Location:reservation_failure.php");   





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

