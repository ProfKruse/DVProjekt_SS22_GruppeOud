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
        <title>Reservierung fehlgeschlagen</title>
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
                <div id="failureFrame" class="frame">
                    <h1 id="fehlermeldung">Prüfung fehlgeschlagen</h1>
                    <?php

                        echo "<h2>Es steht leider kein KFZ des Typs ". $_SESSION ['kfzTypBezeichnung'][0] ."<br> in der Abholstation ". $_SESSION ['abholstationBezeichnung'][0]. " zur Verfügung.</h2>";
  
                        $buttons;
                        // alle autos die zu der Abholstation gehören
                        $kfzids = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende", "WHERE mietstationID = ".$_SESSION['abholstation']);
                        $vorschlag = NULL;
                        if(count($kfzids) > 0) {
                            // alle kfztypids, die zu der abholstation gehören außer die ausgewählt wurde
                            $kfztypids = databaseSelectQuery("kfzTypID","kfzs","WHERE kfzID IN (".implode(',',$kfzids).") AND kfzTypID <> ".$_SESSION['kfztyp']);
                            $kfztypBeschreibung = databaseSelectQuery("TypBezeichnung","kfztypen","WHERE kfzTypID IN (".implode(',',$kfztypids).")");

                            // Für die nächste Session kfzTypBezeichnung updaten und behalten
                            $vorschlag = $kfztypBeschreibung[0];
                            $_SESSION ['kfzTypBezeichnung'][0] = $vorschlag;
                            $_SESSION["kfztyp"][0] = $kfztypids[0];

                        }               
                        // Check, ob auf der ausgewählten Station und kfztyp gar keine Autos mehr zu Verfügung sind
                        $stmt = "SELECT k.kfztypId FROM mietstationen_mietwagenbestaende as m INNER JOIN kfzs as k on k.kfzID = m.kfzID;";
                        $erg = mysqli_query($con, $stmt);
                        $availableKfz = mysqli_num_rows($erg);
 
                        if (($availableKfz -  $_SESSION["totavailableKfz"]) == 0 ) {
                            echo "<h3>Es steht aktuell kein Fahrzeug  für den ausgewählten Tag in der Abholstation zur Verfügung. 
                            <br>Bitte wählen Sie ein andere Zeitraum oder eine andere Station</h3>";
                            $buttons = "<button type='button' onclick=\"window.location='reservation.php'\">Zurück</button>";
                        }
                        else {
                            echo "<h2>Stattdessen ein KFZ vom Typ ".$vorschlag." reservieren? Oder eine andere Zeitraum auswählen?</h2>";
                            $buttons = "<button type='button' onclick=\"window.location='reservation_check.php'\">Ja</button>".
                                "<button type='button' onclick=\"window.location='reservation.php'\">Nein</button>";
                        }
                        ?>
                </div>

                <div class="buttons" style="width:175px">
                    <?php echo $buttons; ?>
                </div>
            </center>
            
        </main>
        <!--Sonstige Links-->
        <aside>

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>