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
                        $connection = new mysqli("localhost","root","","autovermietung");
                            if($connection->connect_error) {
                                die("Es konnte keine Verbindung zur Datenbank aufgebaut werden");
                            }

                        $result = $connection->query("SELECT kfzTypID FROM kfzs WHERE kfzID IN (SELECT kfzID FROM mietstationen_mietwagenbestaende WHERE mietstationID = ".$_SESSION['abholstation'].")");

                        $altKfzID = $result->fetch_assoc()["kfzTypID"];

                        #$alternative = ($result->fetch_array() == null) ? "a" : "b";
    
                        $result->free_result();
                        $connection->close();
                            echo "<h1>Es steht leider kein KFZ des Typs ". $_SESSION['kfztyp'] ."<br> in der Abholstation zur Verfügung ". $_SESSION['abholstation']. "</h1>".
                                    "<h2>Stattdessen ein KFZ vom Typ $altKfzID reservieren?</h2>";
                        ?>
                </div>

                <div class="buttons" style="width:175px">
                    <button type="button" onclick="window.location=''">Ja</button>
                    <button type="button" onclick="window.location='reservation.php'">Nein</button>
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