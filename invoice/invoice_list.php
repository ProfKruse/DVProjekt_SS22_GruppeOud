<?php
if(!isset($_SESSION)) session_start();
include("../database/db_inc.php");
include("../functions/functions.php");
if(check_login_mitarbeiter($con)) {
    header("Location: ../index.php");
}
$user_data = check_login($con);
?>

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
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../reserve/reservation.php">Reservieren</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b class="username"> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Hauptteil-->
        <main>
            <h1>Rechnungen</h1>
            <br>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>            
                        <th>Versanddatum</th>          
                        <th>Zu bezahlen bis</th>          
                        <th>Bezahlt am</th>          
                        <th>Verspätung in Tagen</th>    
                        <th>Herunterladen</th>                     
                    </tr>
                </thead>
                <!-- Rechnungen -->
                <tbody id="rechnungen">
                    <?php
                        $kundendaten;
                        $rechnungsdaten = array();

                        /*
                            Entnimmt aus allen Rechnungen des Kunden die notwendigen Daten um diese zu speichern um daraus später Rechnungen erzeugen zu können
                        */
                        function rechnungsdaten() {
                            global $con;
                            global $kundendaten;
                            global $rechnungsdaten;
                            global $user_data;

                            $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$user_data["kundeID"]));
                            $kundendaten = array("kundennr"=>$kunde["kundeID"],"name"=>$kunde["vorname"]." ".$kunde["nachname"],"straße"=>$kunde["strasse"]." ".$kunde["hausNr"],"stadt"=>$kunde["plz"]." ".$kunde["ort"],"email"=>$kunde["emailAdresse"],"sammelrechnungen"=>$kunde["sammelrechnungen"]);

                            $rechnungen = $con->query("SELECT * FROM rechnungen WHERE kundeID=".$user_data["kundeID"]." AND bezahltAm IS NULL");
                            if($rechnungen != NULL) {
                                while($row = $rechnungen->fetch_array()) {
                                    $rechnungnr = $row["rechnungNr"];
                                    $gesamtpreis = $row["rechnungBetrag"];

                                    $mietvertrag = mysqli_fetch_array($con->query("SELECT * FROM mietvertraege WHERE mietvertragID=".$row["mietvertragID"]));
                                    $mietdauer = $mietvertrag["mietdauerTage"];

                                    $vertrag = mysqli_fetch_array($con->query("SELECT * FROM vertraege WHERE vertragID=".$mietvertrag["vertragID"]));
                                    $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=".$vertrag["kfzID"]));

                                    $marke = $kfz["marke"];
                                    $modell = $kfz["modell"];
                                    $kennzeichen = $kfz["kennzeichen"];
                                    
                                    array_push($rechnungsdaten,array("rechnungsnr"=>$rechnungnr,"marke"=>$marke,"modell"=>$modell,"kennzeichen"=>$kennzeichen,"mietdauer"=>$mietdauer,"gesamtpreis"=>$gesamtpreis,"zahlungslimit"=>$row["zahlungslimit"]));
                                }
                            }
                        }
    
                        rechnungsdaten();
                        $_SESSION['invoice_kundendaten'] = $kundendaten;
                        $_SESSION['invoice_rechnungsdaten'] = $rechnungsdaten;
    
                        $result = $con->query("SELECT * FROM rechnungen WHERE kundeID=".$user_data["kundeID"]);

                        /*
                            Einfügen der Rechnungsdaten in eine neue Tabellenzeile
                        */
                        if($result) {
                            while($row = $result->fetch_array()) {
                                $verspaetung = "-";
                                $bezahltAm = $row["bezahltAm"];
                                if($row["bezahltAm"] != NULL && strtotime($row["bezahltAm"]) > strtotime($row["zahlungslimit"])) {
                                    $verspaetung = ceil((strtotime($row["bezahltAm"])-strtotime($row["zahlungslimit"]))/86400);
                                }
                                if($row["bezahltAm"] == NULL) {
                                    $bezahltAm = "-";
                                }                   

                                echo '<tr>
                                <td>'.$row["rechnungNr"].'</td>
                                <td>'.$row["versanddatum"].'</td>
                                <td>'.$row["zahlungslimit"].'</td>
                                <td>'.$bezahltAm.'</td>
                                <td>'.$verspaetung.'</td>
                                <td><button type="button" onclick="window.location.href=\'invoice.php?invoice_type=file&einzelrechnungnr='.$row["rechnungNr"].'\'">Download</button></td>
                                </tr>';

                                }
                            }
                            
                        $result->free_result();
                    ?>

                </tbody>
            </table>

            <br>

		<h1>Mahnungen</h1>
        <br>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>
                        <th>Mahnungssstatus</th>
                        <th>Betrag</th>
                        <th>Mahngebühr</th>
                        <th>Zahlungsfrist</th>
                        <th>Herunterladen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        function mahnungen() {
                            global $con;
                            global $user_data;
                            $result = $con->query("SELECT * FROM rechnungen WHERE kundeID=".$user_data["kundeID"]." AND mahnstatus != 'keine'");
                            
                            if($result) {
                                while($row = $result->fetch_assoc()) {
                                    $mahngebuehr = ($row["mahnstatus"] == "erste Mahnung") ? 0 : round((0.05*$row["rechnungBetrag"]),2);
                                    $verlaengerung = ($row["mahnstatus"] == "erste Mahnung") ? 7 : 14;

                                    if($row["mahnstatus"] == "dritte Mahnung")
                                        $verlaengerung = 21;
                                        $zahlungsfrist = date("Y-m-d",strtotime($row["zahlungslimit"])+($verlaengerung*86400));

                                    if ($mahngebuehr < 5)
                                        $mahngebuehr = 5;

                                    if($mahngebuehr > 150)
                                        $mahngebuehr = 150;

                                    echo "<tr>".
                                    "<td>".$row["rechnungNr"]."</td>".
                                    "<td>".$row["mahnstatus"]."</td>".
                                    "<td>".$row["rechnungBetrag"]."€</td>".
                                    "<td>".$mahngebuehr."€</td>".
                                    "<td>".$zahlungsfrist."</td>".
                                    '<td><button type="button" onclick="window.location.href=\'reminder.php?reminder_type=file&einzelrechnungnr='.$row["rechnungNr"].'\'">Download</button></td>'.
                                    "</tr>";
                                }
                            }
                        }
                            
                        mahnungen();
                        $con->close();
                    ?>
                </tbody>
            </table>
            <br>
            <br>
            <br>

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