<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Rechnungen</title>
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
            <h1>Rechnungen</h1>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>            
                        <th>Erstellt am</th>          
                        <th>Zu bezahlen bis</th>          
                        <th>Bezahlt am</th>          
                        <th>Verspätung in Tagen</th>    
                        <th>Herunterladen</th>                     
                    </tr>
                </thead>
                <!-- Inhalt -->
                <tbody id="rechnungen">
                    <?php
                        require_once('../database/db_inc.php');
                        if(!isset($_SESSION)) session_start();

                        $_SESSION['kunde'] = 3;
                        $kundendaten;
                        $rechnungsdaten = array();

                        function sammelrechnungen() {
                            global $con;
                            global $kundendaten;
                            global $rechnungsdaten;
                            
                            $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$_SESSION["kunde"]));
                            $kundendaten = array("kundennr"=>$kunde["kundeID"],"name"=>$kunde["vorname"]." ".$kunde["nachname"],"straße"=>$kunde["strasse"]." ".$kunde["hausNr"],"stadt"=>$kunde["plz"]." ".$kunde["stadt"]);

                            //Alle Rechnungen, welche noch nicht bezahlt wurden
                            $rechnungen = $con->query("SELECT * FROM rechnungen WHERE kundeID=".$_SESSION["kunde"]." AND bezahltAm IS NULL");
                            if($rechnungen != NULL) {
                                while($row = $rechnungen->fetch_array()) {
                                    $rechnungnr = $row["rechnungNr"];
                                    $gesamtpreis = $row["rechnungBetrag"];

                                    $mietvertrag = mysqli_fetch_array($con->query("SELECT * FROM mietvertraege WHERE mietvertragID=".$row["rechnungNr"]));
                                    $mietdauer = $mietvertrag["mietdauerTage"];

                                    $vertrag = mysqli_fetch_array($con->query("SELECT * FROM vertraege WHERE vertragID=".$mietvertrag["mietvertragID"]));
                                    $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=".$vertrag["kfzID"]));

                                    $marke = $kfz["marke"];
                                    $modell = $kfz["modell"];
                                    $kennzeichen = $kfz["kennzeichen"];
                                    
                                    array_push($rechnungsdaten,array("rechnungsnr"=>$rechnungnr,"marke"=>$marke,"modell"=>$modell,"kennzeichen"=>$kennzeichen,"mietdauer"=>$mietdauer,"gesamtpreis"=>$gesamtpreis));
                                }
                            }
                        }
    
                        sammelrechnungen();
    
                        $result = $con->query("SELECT * FROM rechnungen WHERE kundeID=".$_SESSION["kunde"]);

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_array()) {
                            $sammelrechnungen = mysqli_fetch_array($con->query("SELECT DISTINCT sammelrechnungen FROM kunden WHERE kundeID=".$_SESSION['kunde']))["sammelrechnungen"];
                            
                            //Tage nach Zusendung der Sammelrechnungen um Rechnungen zu begleichen
                            $zahlungszielTage = mysqli_fetch_array($con->query("SELECT DISTINCT zahlungszielTage FROM kunden WHERE kundeID=".$_SESSION['kunde']))["zahlungszielTage"];
                            $rechnungdatum = strtotime($row["rechnungDatum"]);
                            $zahlungslimit = ($zahlungszielTage*86400)+$rechnungdatum;
                            $verspaetung = $row["bezahltAm"] == NULL ? "-" : ceil((strtotime($row["bezahltAm"])-$zahlungslimit)/86400);                             
                            
                            switch ($sammelrechnungen) {
                                case "keine":
                                    break;

                                case "woechentlich":
                                    if (date('D',$rechnungdatum) != 'Mon') {
                                        $zahlungslimit = $zahlungslimit - $rechnungdatum + strtotime('next monday');
                                        
                                    }
                                    break;

                                case "monatlich":
                                    if(explode('-',$row['rechnungDatum'])[2] != '01') {
                                        $zahlungslimit = $zahlungslimit - $rechnungdatum + strtotime('first day of next month');
                                    }
                                    break;

                                case "quartalsweise":
                                    $quartale = array('03-31','06-30','09-30','12-31');
                                    
                                    if(!in_array(date('m-d',$rechnungdatum),$quartale)) {
                                        $quartal_1 = strtotime(date('Y-03-31'));
                                        $quartal_2 = strtotime(date('Y-06-30'));
                                        $quartal_3 = strtotime(date('Y-09-30'));
                                        $quartal_4 = strtotime(date('Y-12-31'));

                                        if($rechnungdatum < $quartal_1) {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_1;
                                        }

                                        if($rechnungdatum > $quartal_1 && $rechnungdatum < $quartal_2) {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_2;
                                        }

                                        if($rechnungdatum > $quartal_2 && $rechnungdatum < $quartal_3) {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_3;
                                        }

                                        if($rechnungdatum > $quartal_3) {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_4;
                                        }
                                    }

                                    break;

                                case "halbjaehrlich":
                                    //Noch überarbeiten und schauen ob bis Ende des des Halbjahres oder Anfang des neuen Halbjahres
                                    $halbjahre = array('06-30','12-31');

                                    if(!in_array(date('m-d',$rechnungdatum), $halbjahre)) {
                                        $erstes_halbjahr = strtotime(date('Y-06-30'));
                                        $zweites_halbjahr = strtotime(date('Y-12-31'));

                                        if ($rechnungdatum < $erstes_halbjahr) {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $erstes_halbjahr;
                                        }
                                        else {
                                            $zahlungslimit = $zahlungslimit - $rechnungdatum + $zweites_halbjahr;
                                        }
                                    }
                                    break;

                                case "jaehrlich":
                                    if(date('m-d',$rechnungdatum) != '01-01') {
                                        $zahlungslimit = $zahlungslimit - $rechnungdatum + strtotime(date('Y-01-01',strtotime('+1 year')));
                                    }
                                    break;
                                    }

                                    echo '<tr>
                                    <td>'.$row["rechnungNr"].'</td>
                                    <td>'.$row["rechnungDatum"].'</td>
                                    <td>'.date('Y-m-d',$zahlungslimit).'</td>
                                    <td>'.$row["bezahltAm"].'</td>
                                    <td>'.$verspaetung.'</td>
                                    <td><button type="button" onclick="window.location.href=\'invoice.php?invoice_type=file\'">Download</button></td>
                                    </tr>';

                                }
                            }

                        $_SESSION['invoice_kundendaten'] = $kundendaten;
                        $_SESSION['invoice_rechnungsdaten'] = $rechnungsdaten;
                        $result->free_result();
                        $con->close();
                    ?>

                </tbody>
            </table>

            <br>

		<h1>Mahnungen</h1>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>
                        <th>Mahnungssstatus</th>
                        <th>Betrag</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12_04_2022</td>
                        <td>1</td>
                        <td>500€</td>
                    </tr>
                </tbody>
            </table>

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