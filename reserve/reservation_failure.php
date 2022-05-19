<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_reservationProcessing.css">
        <title>Reservierung fehlgeschlagen</title>
    </head>
    <body>
        <!--Header-->
        <header>
            <nav>
                <ul>
                    <b>
                        <li><a href="">Reservieren</a></li>
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="">Rechnungen</a></li>
                        <li><a href="">Konto</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
            <h1>Reservierung fehlgeschlagen</h1>
            <center>
                <div id="failureFrame" class="frame">
                    <h1 id="fehlermeldung">Reservierung fehlgeschlagen</h1>
                    <?php
                        session_start();
                        include_once(__DIR__ . "\global.php");
                        $buttons;
                        
                        $kfzids = databaseSelectQuery("kfzID","mietstationen_mietwagenbestaende", "WHERE mietstationID = ".$_SESSION['abholstation']);
                        if(count($kfzids) > 0) {
                            $kfztypids = databaseSelectQuery("kfzTypID","kfzs","WHERE kfzID IN (".implode(',',$kfzids).")");
                            $_SESSION["altkfzid"] = $kfztypids[0];
                        }               
                        echo "<h1>Es steht leider kein KFZ des Typs ". $_SESSION['kfztyp'] ."<br> in der Abholstation ". $_SESSION['abholstation']. " zur Verfügung.</h1>";
                        
                        if (!isset($_SESSION['altkfzid'])) {
                            echo "<h2>Es steht aktuell kein Fahrzeug in der Abholstation zur Verfügung</h2>";
                            $buttons = "<button type='button' onclick=\"window.location='reservation.php'\">Zurück</button>";
                        }
                        else {
                            echo "<h2>Stattdessen ein KFZ vom Typ ".$_SESSION['altkfzid']." reservieren?</h2>";

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