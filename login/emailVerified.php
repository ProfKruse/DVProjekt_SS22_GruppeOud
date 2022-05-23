<?php
session_start();
        include("../database/db_inc.php");
        include("../functions/functions.php");


        $emailAdresse = $_POST['emailAdresse']; 
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $strasse = $_POST['strasse'];  
        $hausNr = $_POST['hausNr']; 
        $plz = $_POST['plz']; 
        $ort = $_POST['ort']; 
        $land = $_POST['land'];
        $iban = $_POST['iban'];
        $bic = $_POST['bic'] ; 
        $telefonNr = $_POST['telefonNr']; 

        if(!empty($pseudo) && !empty($password)){
            
            $stmt = "insert into kunden (vorname, nachname, pseudo, password, strasse, hausNr, plz,ort, land, iban, bic, telefonNr, emailAdresse) 
            values ('$vorname','$nachname', '$pseudo','$hash','$strasse','$hausNr',$plz,'$ort','$land','$iban','$bic','$telefonNr','$emailAdresse')";

            mysqli_query($con,$stmt);
            header("Location: login.php");
            die;
        }else{
            echo "please enter some valide information!";
        }
?>