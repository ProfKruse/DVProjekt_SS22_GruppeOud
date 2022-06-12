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
                <div id="failureFrame" class="frame">
                    <h1 id="fehlermeldung">Prüfung fehlgeschlagen</h1>
                    <?php
                        if(!isset($_SESSION)) { session_start(); } 
                        require_once("../Database/db_inc.php");
                        $buttons;
                        
                        //Wähle alle IDs der KFZs mit den Bedingungen:-
                        //1. Stehen in der ausgewählten Abholstation
                        //2. Nicht bereits komplett reserviert wurde
                        global $con; 

                        $autos = $con->query("SELECT DISTINCT kfzTypID FROM kfzs WHERE kfzID IN (SELECT kfzID FROM mietstationen_mietwagenbestaende WHERE mietstationID=".$_SESSION['abholstation'].");");
                        $uebrigeAutos = array();
                        
                        if($autos != null) {
                            while($row = $autos->fetch_assoc()) {
                                $anfrage = $con->query("SELECT COUNT(*)-
                                (SELECT COUNT(*) FROM reservierungen WHERE mietstationID=".$_SESSION['abholstation']." AND kfzTypID=".$row["kfzTypID"].") table1
                                FROM (SELECT * FROM mietstationen_mietwagenbestaende WHERE mietstationID=".$_SESSION['abholstation'].
                                " AND kfzID IN (SELECT kfzID FROM kfzs WHERE kfzTypID=".$row["kfzTypID"].")) table2;");
                                $anzahlUebrigeAutos = $anfrage->fetch_array();
                                if($anzahlUebrigeAutos[0] > 0) {
                                    array_push($uebrigeAutos, $row["kfzTypID"]);
                                }
                            }
                        }

                        
                        //$verfuegbareAutos->free_result();

                        $alternative = NULL;
                        if(count($uebrigeAutos) > 0) $alternative = $uebrigeAutos[0];
                        $typBezeichnung = databaseSelectQuery("typBezeichnung","kfztypen","WHERE kfzTypID = ".$_SESSION['kfztyp'])[0];      
                        $abholstationBeschreibung = databaseSelectQuery("beschreibung","mietstationen","WHERE mietstationID = ".$_SESSION['abholstation'])[0];         
                        echo "<h2>Es steht leider kein KFZ des Typs $typBezeichnung <br> in der Abholstation $abholstationBeschreibung zur Verfügung.</h2>";
                        
                        if ($alternative == NULL) {
                            echo "<h2>Es steht aktuell kein Fahrzeug in der Abholstation zur Verfügung</h2>";
                            $buttons = "<button type='button' onclick=\"window.location='reservation.php'\">Zurück</button>";
                        }
                        else {
                            $alternativeBezeichnung = databaseSelectQuery("typBezeichnung","kfztypen","WHERE kfzTypID = ".$alternative)[0];
                            echo "<h2>Stattdessen ein KFZ vom Typ ".$alternativeBezeichnung." reservieren?</h2>";

                            $_SESSION["kfztyp"] = $alternative;
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