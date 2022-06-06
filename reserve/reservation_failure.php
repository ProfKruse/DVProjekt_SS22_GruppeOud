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

                        $kfzTypBezeichnung = databaseSelectQuery("typBezeichnung","kfztypen", "WHERE kfzTypID = ".$_SESSION['kfztyp'] );
                        $abholstationBezeichnung= databaseSelectQuery("beschreibung","mietstationen", "WHERE mietstationID = ".$_SESSION['abholstation']);
                        $_SESSION ['kfzTypBezeichnung'] = $kfzTypBezeichnung[0];
                        $_SESSION ['abholstationBezeichnung'] = $abholstationBezeichnung[0];
                        echo "<h2>Es steht leider kein KFZ des Typs ". $_SESSION ['kfzTypBezeichnung'] ."<br> in der Abholstation ". $_SESSION ['abholstationBezeichnung']. " zur Verfügung.</h2>";
  
                        $buttons;
                        
                        $kfzids = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende", "WHERE mietstationID = ".$_SESSION['abholstation']);
                        $altkfzid = NULL;
                        if(count($kfzids) > 0) {
                            $kfztypids = databaseSelectQuery("kfzTypID","kfzs","WHERE kfzID IN (".implode(',',$kfzids).")");
                            $kfztypBeschreibung = databaseSelectQuery("TypBezeichnung","kfztypen","WHERE kfzTypID IN (".implode(',',$kfztypids).")");
                            $altkfzid = $kfztypBeschreibung[0];
                            $_SESSION ['kfzTypBezeichnung'] = $altkfzid;
                            $_SESSION["kfztyp"] = $kfztypids[0];
                        }               
                        
                        if ($altkfzid == NULL) {
                            echo "<h2>Es steht aktuell kein Fahrzeug in der Abholstation zur Verfügung</h2>";
                            $buttons = "<button type='button' onclick=\"window.location='reservation.php'\">Zurück</button>";
                        }
                        else {
                            echo "<h2>Stattdessen ein KFZ vom Typ ".$altkfzid." reservieren?</h2>";

                            //$_SESSION["kfztyp"] = $altkfzid;
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