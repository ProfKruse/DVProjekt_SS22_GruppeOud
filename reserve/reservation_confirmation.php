<?php   
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");
    $user_data = check_login($con);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Reservierung erfolgreich</title>
     
    </head>
    <body>
        <!--Header-->
        <header>
            <nav>
                <ul>
                    <b>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="reservation.php">Reservieren</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b class="username"> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->

        <main>
            <center>
                    <?php
                        $anzahlVerfuegbareAutos = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzID IN (SELECT kfzID FROM kfzs WHERE kfzTypID=".$_SESSION["kfztyp"].")");
                        $anzahlReservierteAutos = databaseSelectQuery("kfzTypID","reservierungen","WHERE (mietstationID = ".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]." AND Mietende >= '".$_SESSION['Mietbeginn']."') AND (mietstationID = ".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]." AND Mietbeginn <= '".$_SESSION['Mietende']."')");  
                        $anzahlUebrigeAutos = count($anzahlVerfuegbareAutos)-count($anzahlReservierteAutos);
                        
                        if ($anzahlUebrigeAutos > 0 && $user_data != null) {
                            $record = "INSERT INTO reservierungen (kundeID, kfzTypID, mietstationID,abgabestationID, status,datum, Mietbeginn, Mietende,message) VALUES (".$user_data["kundeID"].",".$_SESSION["kfztyp"].",".$_SESSION["mietstation"].", ".$_SESSION["abgabestation"]." , 'bestätigt','".date('Y-m-d')."', '".$_SESSION['Mietbeginn']."','".$_SESSION['Mietende']."','".$_SESSION['message']."');";
                            /*echo "kundenid: ".$user_data["kundeID"]
                            ." kfztypid: ".$_SESSION["kfztyp"]
                            ." mietstationid: ".$_SESSION["mietstation"]
                            ." Mietbeginn: ".$_SESSION['Mietbeginn']
                            ." Mietende: ".$_SESSION['Mietende']
                            ." Message: ".$_SESSION['message'];*/
                            $result = $con->query($record);
                            $confirmation = "Reservierung durchgeführt";
                            $frametype = "successFrame";
                            $confirmationtype = "erfolgsmeldung";
                            $message = "<h2>Ihre Reservierung wurde erfolgreich durchgeführt! <br> Sie erhalten eine Bestätigung per E-Mail </h2>";
                            // get reservation id for the a cancel link
                            $stmtIdReserve = "SELECT MAX(reservierungID) AS MAXID FROM reservierungen;";
                            $erg = mysqli_query($con, $stmtIdReserve);
                            $reservierungID = mysqli_fetch_assoc($erg);
                            $mail= "<center><h2>Ihre Reservierung</h2> 
                            <p>Sie haben ein KFZ des Typs ".$_SESSION ['kfzTypBezeichnung'][0]." 
                            <br> in der Abholstation ". $_SESSION ['abholstationBezeichnung'][0]." 
                            reseriviert. Zeitraum von ".$_SESSION['Mietbeginn']." bis ".$_SESSION['Mietende']." <br> Sie können die reservierung bis 24 Std vor der Mitbeginn stornieren. <a href= 'localhost/rentalcar/reserve/reservation_cancel.php?reservierungID=".$reservierungID['MAXID']."'> Ihre Reservierung stornieren </a></h2><center>";
                            send_mail($user_data['emailAdresse'],"Ihre Reservierung bei Rentalcar GmBH wurde erfolgreich durchgeführt!",$mail);
                        }
  
                        else {
                            $confirmation = "Reservierungsfehler";
                            $frametype = "failureFrame";
                            $confirmationtype = "fehlermeldung";
                            $message = "<h2>Ihre Reservierung konnte nicht durchgeführt werden! Bitte wenden Sie sich an unsere Service</h2>";
                        }
                        
                        echo "<div id='$frametype' class='frame'>";
                        echo "<h1 id='$confirmationtype'>$confirmation</h1>";
                        echo $message;                     
                    ?>
                </div>
                <div class="buttons" style="width: 150px;">
                    <button type="button" onclick="window.location='..\\index.php'">Zurück</button>
                </div>
            </center>
        </main>
        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>