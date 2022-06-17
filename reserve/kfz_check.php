<!DOCTYPE html>
    <?php
        function verfuegbareKfzAnzeigen()
        {
            require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));

            $reservierungsdaten = mysqli_fetch_array($con->query("SELECT * FROM reservierungen WHERE reservierungID = ".$_GET["reservierungID"]));
            $kategorie = $reservierungsdaten["kfzTypID"];
            $kategorieBezeichnung = mysqli_fetch_array($con->query("SELECT typBezeichnung FROM kfztypen WHERE kfzTypID=".$kategorie));
            
            //Autos der gewünschten Kategorie, welche allgemein existieren
            $autosGewuenschterKategorie = $con->query("SELECT * FROM kfzs WHERE kfzTypID=".$kategorie);
            $kfzids = array();
            $kfz = array();

            if($autosGewuenschterKategorie) {
                while($row = $autosGewuenschterKategorie->fetch_array()) {
                    
                    //Autos von der gewünschten Kategorie, welche in der gewünschten Abholstation existieren
                    $autosAufBestand = mysqli_fetch_array($con->query("SELECT * FROM mietstationen_mietwagenbestaende WHERE mietstationID=".$reservierungsdaten["mietstationID"]
                    ." AND kfzID=".$row["kfzID"]));
                    if($autosAufBestand) {
                        array_push($kfzids, $autosAufBestand["kfzID"]);
                        echo $autosAufBestand["kfzID"];
                    }
                }
            }
            else {
                
            }


            //Alle Verträge mit einem Kfz der gewünschten Kategorie, welche in der gewünschten Abholstation existieren
            $vertraegeMitGewuenschterKategorie = $con->query("SELECT * FROM vertraege WHERE kfzID IN (".implode(",",$kfzids).")");
            $laufendeVertraege;

            if($vertraegeMitGewuenschterKategorie) {
                while($row = $vertraegeMitGewuenschterKategorie->fetch_array()) {
                    $heute = strtotime(date("Y-m-d"));
                    $datum = strtotime($row["datum"]);
                    $maxTage = ($heute-$datum)/86400;

                    //Alle Verträge mit einem Kfz der gewünschten Kategorie, welche spätestens heute enden
                    $laufendeVertraege = mysqli_fetch_array($con->query("SELECT * FROM mietvertraege WHERE vertragID=".$row["vertragID"].
                        " AND mietdauerTage <= $maxTage"));

                    //Der Mietvertrag, der der Vertrag ID zugeordnet ist, endet spätestens heute und ist damit wieder verfügbar
                    if($laufendeVertraege) {
                        array_push($kfz,$row["kfzID"]);
                        echo $row["kfzID"]." ist wieder verfügbar";
                    }                                     
                }
            }
            else {

            }


            /*Vermietbare/Verfügbare Autos: Autos mit der gewünschten Kategorie in der gewünschten Abholstation, welche noch nicht in einem Mietvertrag stehen, welcher
             *heute noch nicht abläuft (datum+mietdauerTage > heute)
             */ 


            //$vermieteteAutos = ($con->query("SELECT * FROM mietvertraege WHERE abholstation=".$reservierungsdaten["mietstationID"]
              //  ." AND vertragID IN (SELECT vertragID FROM vertraege WHERE kfzID IN (".implode(",",$kfzids)."))"));
            
            /*if($vermieteteAutos){
                while($row = $vermieteteAutos->fetch_array()) {
                    echo $row[""];
                }
            }/*
            $mietstationName = mysqli_fetch_array($con->query("SELECT beschreibung as name FROM mietstationen WHERE mietstationID=".$reservierungsdaten["mietstationID"]))["name"];
            if($vermieteteAutos) {
                while($row = $vermieteteAutos->fetch_array()) {
                    echo $row;
                }
            }
            
            /*
             *Sollte kein KFZ der gewünschten Kategorie zur Verfügung stehen, wird ein KFZ der nächsthöheren Kategorie angeboten 
             */

            //Variable Werte die abhängig von der verfügbarkeit eines Fahrzeugs bestimmt werden
            $tarifID_neu;
            $marke;
            $modell;
            $kfzTyp;
            $kennzeichen;
                
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
                                <td>".$reservierungsdaten['mietstationID']."</td>
                                <td>$mietstationName</td>
                                <td>$tarifID_neu</td>
                                <td>$marke</td>
                                <td>$modell</td>
                                <td>$kfzTyp</td>
                                <td>$kennzeichen</td>
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
                /div>
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