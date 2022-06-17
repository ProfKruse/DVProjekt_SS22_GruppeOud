<!DOCTYPE html>
    <?php
        function reservierungsdatenAnzeigen()
        {
            //Datei für die Verbindung zur Datenbank
            require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
            if (isset($_GET['reservierungID'])) 
            {
                $reservierungID = $_GET["reservierungID"];

                //SQL Abfragen für die einzelnen geforderten Felder - Abbruch bei Fehlern
                $result = mysqli_fetch_array($con->query("SELECT vorname, nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $reservierungID));

                if (!$result) 
                { 
                    die('Es konnten keine Daten gefunden werden'); 
                }
                else
                {
                    $vorname = $result["vorname"];
                    $nachname = $result["nachname"];
                }
                
                $result = mysqli_fetch_array($con->query("SELECT typBezeichnung FROM kfztypen JOIN reservierungen ON kfztypen.kfzTypID = reservierungen.kfzTypID WHERE reservierungID =" . $reservierungID));
                if (!$result ) 
                { 
                    die('Es konnten keine Daten gefunden werden'); 
                }
                else
                {
                    $kfztyp = $result["typBezeichnung"];
                }

                $result = mysqli_fetch_array($con->query("SELECT status FROM reservierungen WHERE reservierungID =" . $reservierungID));
                if (!$result) 
                { 
                    die('Es konnten keine Daten gefunden werden');  
                }
                else
                {
                    $status = $result["status"];
                }

                $result = mysqli_fetch_array($con->query("SELECT beschreibung FROM mietstationen JOIN reservierungen ON mietstationen.mietstationID = reservierungen.mietstationID WHERE reservierungID =" . $reservierungID));
                if (!$result ) 
                { 
                    die('Es konnten keine Daten gefunden werden');  
                }
                else
                {
                    $abholstation = $result["beschreibung"];
                }

                $result = mysqli_fetch_array($con->query("SELECT datum FROM reservierungen WHERE reservierungID =" . $reservierungID));
                if (!$result ) 
                { 
                    die('Es konnten keine Daten gefunden werden'); 
                }
                else
                {
                    $datum = $result["datum"];
                }
                //<!--Ausgabe der Tabelle mit gewünschten Daten falls kein Fehler vorliegt-->
                if($vorname != NULL)
                {
                    echo"<center>
                    <table class='mietdaten'>
                        <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>Kfz-Typ</th>
                                <th>Status</th>
                                <th>Abholstation</th>
                                <th>Reservierungsdatum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>$vorname</td>
                                <td>$nachname</td>
                                <td>$kfztyp</td>
                                <td>$status</td>    
                                <td>$abholstation</td>
                                <td>$datum</td>
                            </tr> 
                        </tbody>
                    </table>
                    </center>";
                }
                //<!--Roter Text bei Eingabe einer ungültigen Reservierungsnummer-->
                else
                {
                    echo"<span class=form_font_error>Keine Datenbankeinträge gefunden!</span>";
                }
                    mysqli_close($con);
                }
            }
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css">
        <title>Reservierungsdaten anzeigen</title>
    </head>
    <body style="background-image:url()">   
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
            <h1>Reservierungsdaten anzeigen</h1>
            <center>
            <div class="frame">
            <form action="reservation_display.php" method="GET">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="reservierungID"><b>*Reservierungsnummer</b></label>
                    <input type="number" name="reservierungID" id="reservierungID" maxlength=11 required >
                </div>
                
                <div class="group">
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <?php
                reservierungsdatenAnzeigen();
                if (isset($_GET['reservierungID'])) {
                    echo '<button type="submit" name="mieten" onclick="window.location.href=\'kfz_check.php?reservierungID='.$_GET['reservierungID'].'\'">Kfz mieten</button>';
                }
            ?>

             
            
        </div>
        </center>
            
        </main>
        <!--Sonstige Links-->

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>