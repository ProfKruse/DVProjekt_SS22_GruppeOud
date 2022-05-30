<!DOCTYPE html>
    <?php
        function verfuegbareKfzAnzeigen()
        {
            include("db_con.php");
            if (isset($_POST['mietstationID'])) 
            {
                $mietstationID = $_POST["mietstationID"];
                $tarifID = $_POST["tarifID"];
                //Falls ein höherer Tarif gewählt werden muss
                $tarifID_neu = $tarifID;

                //<!--SQL Abfragen für die einzelnen geforderten Felder - Abbruch bei Fehlern-->
                $statement = "SELECT name FROM mietstationen WHERE mietstationID=" . $mietstationID;
                $db_erg = mysqli_query( $con, $statement );
                if(!$db_erg) 
                { 
                    die('Fehler in der SQL Anfrage'); 
                }
                else
                {
                    $mietstationName = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC);
                }
                $statement = "SELECT marke FROM kfzs JOIN mietstationen_mietwagenbestaende ON kfzs.kfzID = mietstationen_mietwagenbestaende.kfzID JOIN kfztypen ON kfzs.kfzTypID = kfztypen.kfzTypID WHERE (mietstationID =". $mietstationID .") AND (tarifID =" . $tarifID .")";
                $db_erg = mysqli_query( $con, $statement );
                if (!$db_erg ) 
                { 
                    die('Fehler in der SQL Anfrage'); 
                }
                else
                {
                    $marke = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);
                }
                //Was ist der maximale Tarif??? hier z.B. 10
                while($marke == NULL && $tarifID_neu < 10)
                {
                    $tarifID_neu++;
                    $statement = "SELECT marke FROM kfzs JOIN mietstationen_mietwagenbestaende ON kfzs.kfzID = mietstationen_mietwagenbestaende.kfzID JOIN kfztypen ON kfzs.kfzTypID = kfztypen.kfzTypID WHERE (mietstationID =". $mietstationID .") AND (tarifID =" . $tarifID_neu .")";
                    $db_erg = mysqli_query( $con, $statement );                
                    $marke = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);
                }
                $statement = "SELECT modell FROM kfzs JOIN mietstationen_mietwagenbestaende ON kfzs.kfzID = mietstationen_mietwagenbestaende.kfzID JOIN kfztypen ON kfzs.kfzTypID = kfztypen.kfzTypID WHERE (mietstationID =". $mietstationID .") AND (tarifID =" . $tarifID_neu .")";
                $db_erg = mysqli_query( $con, $statement );
                if (!$db_erg ) 
                { 
                    die('Fehler in der SQL Anfrage'); 
                }
                else
                {
                    $modell = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);
                }
                $statement = "SELECT typBezeichnung FROM kfztypen JOIN kfzs ON kfztypen.kfzTypID = kfzs.kfzTypID JOIN mietstationen_mietwagenbestaende ON mietstationen_mietwagenbestaende.kfzID = kfzs.kfzID WHERE (mietstationID =". $mietstationID .") AND (tarifID =" . $tarifID_neu .")";
                $db_erg = mysqli_query( $con, $statement );
                if (!$db_erg ) 
                { 
                    die('Fehler in der SQL Anfrage'); 
                }
                else
                {
                    $kfzTyp = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);
                }
                $statement = "SELECT kennzeichen FROM kfzs JOIN mietstationen_mietwagenbestaende ON kfzs.kfzID = mietstationen_mietwagenbestaende.kfzID JOIN kfztypen ON kfzs.kfzTypID = kfztypen.kfzTypID WHERE (mietstationID =". $mietstationID .") AND (tarifID =" . $tarifID_neu .")";
                $db_erg = mysqli_query( $con, $statement );
                if (!$db_erg ) 
                { 
                    die('Fehler in der SQL Anfrage'); 
                }
                else
                {
                    $kennzeichen = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);
                }        
                
                if($marke != NULL)
                {
                    echo"<center>
                    <table class='mietdaten'>
                        <thead>
                            <tr>
                                <th>Mietstation ID</th>
                                <th>Mietstation Name</th>
                                <th>Tarif ID</th>
                                <th>Marke</th>
                                <th>Modell</th>
                                <th>Typ Bezeichnung</th>
                                <th>Kennzeichen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$mietstationID}</td>
                                <td>{$mietstationName['name']}</td>
                                <td>{$tarifID_neu}</td>
                                <td>{$marke['marke']}</td>
                                <td>{$modell['modell']}</td>
                                <td>{$kfzTyp['typBezeichnung']}</td>
                                <td>{$kennzeichen['kennzeichen']}</td>
                            </tr> 
                        </tbody>
                    </table>
                    </center>";
                    if($tarifID != $tarifID_neu)
                    {
                        echo "<span class=form_font_error>Fahrzeug mit Tarifnummer $tarifID sind nicht verfügbar. Nächsthöhere verfügbare Tarifnummer: $tarifID_neu</span>";
                    }
                    
                }
                //<!--Roter Text bei Eingabe einer ungültigen Reservierungsnummer-->
                else
                {
                    echo"<span class=form_font_error>Keine Fahrzeuge mit gewünschten Tarif (oder höher) gefunden!</span>";
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
            <h1>Fahrzeug Verfügbarkeit anzeigen</h1>
            <center>
            <div class="frame">
            <form action="kfz_check.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="mietstationID"><b>*Mietstation ID</b></label>
                    <input type="number" name="mietstationID" id="mietstationID" maxlength=11 required >
                </div>
                <div class="group">
                    <label for="tarifID"><b>*Tarif ID</b></label>
                    <input type="number" name="tarifID" id="tarifID" max="10" required > <!-- Max Value für Tarif z.B. 10 -->
                </div>
                <br><br><br><br><br>
                <div>
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <?php
                verfuegbareKfzAnzeigen();
            ?>  
            </form>
            
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