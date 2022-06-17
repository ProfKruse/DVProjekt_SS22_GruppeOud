<!DOCTYPE html>
    <?php
        function verfuegbareKfzAnzeigen() {
            require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));

            $reservierungsdaten = mysqli_fetch_array($con->query("SELECT * FROM reservierungen WHERE reservierungID = ".$_GET["reservierungID"]));
            $kategorie = $reservierungsdaten["kfzTypID"];
            $abholstation = $reservierungsdaten["mietstationID"];
            
            $kfzids = $con->query("SELECT kfzID FROM kfzs WHERE kfzTypID=$kategorie AND kfzID IN (SELECT kfzID FROM mietstationen_mietwagenbestaende WHERE
                mietstationID=$abholstation)");
            $id;
            $ids = array();

            //Alle IDs der KFZ speichern, welche von der gewünschten Kategorie sind und in der Abholstation stehen
            if($kfzids) {
                while($row = $kfzids->fetch_array()) {
                    array_push($ids,$row["kfzID"]);
                }
            }

            //Alle IDs der KFZ suchen, welche von der gewünschten Kategorie sind und in der Abholstation stehen und zur Zeit bereits schon vermietet sind
            $vertragids = $con->query("SELECT kfzID FROM vertraege WHERE vertragID IN (SELECT vertragID FROM mietvertraege WHERE abholstation=$abholstation AND status!='abgeschlossen')
                AND kfzID IN (".implode(",",$ids).")");            

            //Entfernen der IDs der KFZ, welche bereits vermietet sind (Übrige KFZ der gewünschten Kategorie)
            if($vertragids) {
                while($row = $vertragids->fetch_array()) {
                    unset($ids[array_search($row["kfzID"],$ids)]);
                }
            }

            //Kein Auto der gewünschten Kategorie in der Abholstation verfügbar 
            if(!$ids) {
                $kfzids = $con->query("SELECT kfzID FROM kfzs WHERE kfzTypID!=$kategorie AND kfzID IN (SELECT kfzID FROM mietstationen_mietwagenbestaende WHERE
                    mietstationID=$abholstation) ORDER BY kfzTypID");

                //Wenn alternative Autos zur Verfügung stehen werden deren IDs gespeichert
                if($kfzids) {
                    while($row = $kfzids->fetch_array()) {
                        $vermietet = mysqli_fetch_array($con->query("SELECT kfzID FROM vertraege WHERE vertragID IN (SELECT vertragID FROM mietvertraege WHERE abholstation=$abholstation AND status!='abgeschlossen')
                            AND kfzID=".$row["kfzID"]));    
    
                        //Alternatives Auto anbieten, wenn dieses noch nicht vermietet wurde
                        if(!$vermietet) {
                            echo "Stattdessen ".$row["kfzID"]." zum selben Tarif mieten?";
                            array_push($ids,$row["kfzID"]);

                            //Wenn angemommen: break;
                            //Sonst: Zurück & Abbrechen
                            break;
                        }            
                    }
                }

                else {
                    echo "Es existiert kein Fahrzeug der gewünschten Kategorie oder alternatives Fahrzeug zur Verfügung";
                }
            }         
            
            $id = array_values($ids)[0];
            $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=$id"));

            $tarif = mysqli_fetch_array($con->query("SELECT tarifBez FROM tarife WHERE tarifID = (SELECT tarifID FROM kfztypen WHERE kfzTypID=$kategorie)"))[0];
            $abholstation = mysqli_fetch_array($con->query("SELECT beschreibung FROM mietstationen WHERE mietstationID = ".$abholstation))[0];
            $kfzTyp = mysqli_fetch_array($con->query("SELECT typBezeichnung FROM kfztypen WHERE kfzTypID = ".$kfz["kfzTypID"]))[0];
            $zustand;
            $kilometerstand;
                
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
                            <td>".$reservierungsdaten['mietstationID']."</td>
                            <td>$abholstation</td>
                            <td>$tarif</td>
                            <td>".$kfz['marke']."</td>
                            <td>".$kfz['modell']."</td>
                            <td>$kfzTyp</td>
                            <td>".$kfz['kennzeichen']."</td>
                        </tr> 
                    </tbody>
                </table>
                </center>";

                //Set status = aktiv
                    
                mysqli_close($con);
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
                    <?php
                        verfuegbareKfzAnzeigen();
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