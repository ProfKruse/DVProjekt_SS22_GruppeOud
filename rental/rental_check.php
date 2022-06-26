<!DOCTYPE html>
    <?php
        if(!isset($_SESSION)) session_start();
        require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
        require_once(realpath(dirname(__FILE__) . '/../functions/functions.php'));
        $user_data = check_login_mitarbeiter($con);

        function verfuegbareKfzAnzeigen() {

            global $con;

            $reservierungsdaten = mysqli_fetch_array($con->query("SELECT * FROM reservierungen WHERE reservierungID = ".$_GET["reservierungID"]));
            $kategorie = $_GET["kategorie"];
            $abholstation = $reservierungsdaten["mietstationID"];
            
            $kfzids = $con->query("SELECT kfzID FROM kfzs WHERE kfzTypID=$kategorie AND kfzID IN (SELECT kfzID FROM mietstationen_mietwagenbestaende WHERE
                mietstationID=$abholstation)");
            $id = null;
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
                            $typ = mysqli_fetch_array($con->query("SELECT * FROM kfztypen WHERE kfzTypID=(SELECT kfzTypID FROM kfzs WHERE kfzID=".$row["kfzID"].")"));
                            $ausgabe = "<h1 style='color:red'>Nicht verfügbar</h1><br> 
                                        <h2 style='font-size:1.2em;'>Leider ist kein Fahrzeug der gewünschten<br> Kategorie verfügbar.</h2><br><br>
                                        <br><h3>Soll stattdessen ein Fahrzeug des Typs ".$typ['typBezeichnung']." zum selben Tarif gebucht werden?</h3>";
                            $buttons = '<div class="buttons" style="width:175px; margin: 25px;">
                                            <button type="button" onclick="window.location=\'rental_check.php?reservierungID='.$_GET["reservierungID"].'&kategorie='.$typ['kfzTypID'].'\'">Ja</button>
                                            <button type="button" onclick="window.history.go(-1); return false;">Nein</button>
                                        </div>';

                            $id = $row["kfzID"];
                            echo $ausgabe.$buttons;

                            //Wenn angemommen: break;
                            //Sonst: Zurück & Abbrechen
                            break;
                        }            
                    }
                }

                if(!$id) {
                    $fehlerausgabe = "<h2 style='color:red'>Es steht leider kein Fahrzeug zur Verfügung!</h2><br>
                                    <button type='button' onclick='window.history.go(-1); return false;'>Zurück</button>";
                    echo $fehlerausgabe;
                }
            }
            
            else {
                $id = array_values($ids)[0];
            }
            
            //Wenn ein Fahrzeug verfügbar ist oder ein Fahrzeug ausgewählt wurde
            if($ids) {
                $id = array_values($ids)[0];
                $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=$id"));

                $tarif = mysqli_fetch_array($con->query("SELECT tarifBez FROM tarife WHERE tarifID = (SELECT tarifID FROM kfztypen WHERE kfzTypID=$kategorie)"))[0];
                $abholstation = mysqli_fetch_array($con->query("SELECT beschreibung FROM mietstationen WHERE mietstationID = ".$abholstation))[0];
                $kfzTyp = mysqli_fetch_array($con->query("SELECT typBezeichnung FROM kfztypen WHERE kfzTypID = ".$kfz["kfzTypID"]))[0];
                $zustand;
                $kilometerstand;
                
                $mietvertragDaten = 
                "<h1 style='color:green'>Fahrzeug auf Lager!</h1>
                <br>
                <hr>
                <center>
                    <br>
                    <br>    
                    <br>
                    <h2>Mietvertragsdaten</h2>
                    <table>
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
                echo $mietvertragDaten;
                
                $erstellButton = '<button type="button" onclick="window.location=\'rental_contract_completion.php?reservierungID='.$_GET["reservierungID"].'&kfzid='.$id.'\'">Mietvertrag abschließen</button>';
                echo $erstellButton;
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
                        <li><a href="../index.php">Home</a></li>
                        <li><b><a href="../return/return_dialog.php">KFZ zurücknehmen</a></b></li>
                        <li><b class="username"> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
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