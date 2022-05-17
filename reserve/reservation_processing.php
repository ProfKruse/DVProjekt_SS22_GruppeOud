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
            <center>
                <div class="frame">
                    <?php
                        $kfztyp = $_POST["kfztyp"];
                        $abholstation = $_POST["abholstation"];
                        $abgabestation = $_POST["abgabestation"];
                        
                        $style_information = "";
                        $heading = "";
                        $box_content = "";

                        $connection = new mysqli("localhost","root","","autovermietung");
                        if($connection->connect_error) {
                            die("Es konnte keine Verbindung zur Datenbank aufgebaut werden");
                        }

                        $result = $connection->query("SELECT * FROM mietstationen_mietwagenbestaende ".
                                                    " WHERE mietstationID = $abholstation ".
                                                    " AND kfzID = ANY(SELECT DISTINCT kfzID FROM kfzs WHERE kfzTypID=$kfztyp)");
    
                        if ($result->fetch_array() == null) {
                            $style_information = "<style>div.frame {border: 3px solid #f65656;}</style>";
                            $heading = "<h1>Reservierung fehlgeschlagen</h1>";
                            $box_content = "<h1>Es steht leider kein KFZ des Typs". $_POST['kfztyp'] ." in der Abholstation ". $_POST['abholstation']. "</h1>".
                                            "<h2>zur Verfügung. Stattdessen xxx reservieren?</h2>";
                        }   

                        else {
                            $style_information = "<style>div.frame {border: 3px solid #49bd3f;}</style>";
                            $heading = "<h1>Reservierung erfolgreich</h1>";
                            $box_content = "<h1>KFZ des Typs ". $_POST['kfztyp'] ." kann in der Abholstation ". $_POST['abholstation']. "</h1>".
                                            "<h2>erfolgreich reserviert werden. Reservierungsdaten jetzt überprüfen?</h2>";
                        }

                        echo $style_information.$heading.$box_content;

                        $result->free_result();
                        $connection->close();
                    ?>    
                    <br>
                </div>

                <div id="buttons">
                    <button type="button">Ja</button>
                    <button type="button">Nein</button>
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
