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
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b> Hallo <?php echo $user_data['pseudo'] ?><b></li>
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
                        $anzahlReservierteAutos = databaseSelectQuery("kfzTypID","reservierungen","WHERE mietstationID=".$_SESSION['abholstation']." AND kfzTypID=".$_SESSION["kfztyp"]);
                        $anzahlUebrigeAutos = count($anzahlVerfuegbareAutos)-count($anzahlReservierteAutos);
                        

                        if ($anzahlUebrigeAutos > 0 && $user_data != null) {
                            $reservierungID = databaseSelectQuery("reservierungID","reservierungen","ORDER BY reservierungID DESC LIMIT 1;")[0]+1;
                            $record = "INSERT INTO reservierungen (reservierungID, kundeID, kfzTypID, mietstationID, status, datum) VALUES ($reservierungID,".$user_data["kundeID"].",".$_SESSION["kfztyp"].",".$_SESSION["mietstation"].", 'bestätigt', '".date('Y-m-d')."');";
                            $result = $con->query($record);
                            
                            $confirmation = "Reservierung durchgeführt";
                            $frametype = "successFrame";
                            $confirmationtype = "erfolgsmeldung";
                            $message = "<h2>Ihre Reservierung wurde erfolgreich durchgeführt! <br> Sie erhalten eine Bestätigung per E-Mail </h2>";
                        }
                        
                        else {
                            $confirmation = "Reservierungsfehler";
                            $frametype = "failureFrame";
                            $confirmationtype = "fehlermeldung";
                            $message = "<h2>Ihre Reservierung konnte nicht durchgeführt werden!</h2>";
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