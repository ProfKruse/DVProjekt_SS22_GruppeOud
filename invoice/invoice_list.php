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
                <tbody>
                    <?php
                        include_once('invoice.php');
                        session_start();

                        $_SESSION['kunde'] = 3;

                        $connection = new mysqli("localhost","root","","autovermietung");
                            if($connection->connect_error) {
                                die("Es konnte keine Verbindung zur Datenbank aufgebaut werden");
                            }

                        $result = $connection->query("SELECT * FROM rechnungen WHERE kundeID=".$_SESSION["kunde"]);
        
                        //zahlungslimit Berechnung: nächster Wochenanfang/Monatsanfang/Quartalsanfang/Halbjahresanfang/Jahresanfang + zahlungszielTage
                        //Verspätung in Tagen: bezahltAm - zahlungslimit

                        //Ausgehändigte Rechnungen: Alle Rechnungen deren Rechnungsdatum <= Zahlungslimit UND noch nicht bezahlt

                        //Quartalsweise
                        //Ende erstes Quartal: 31. März
                        //Ende zweites Quartal: 30. Juni
                        //Ende drittes Quartal: 30. September
                        //Ende viertes Quartal: 31. Dezember

                        //Halbjährlich
                        //Endes erstes Halbjahr: 30. Juni
                        //Ende zweites Halbjahr: 31. Dezember

                        //Jährlich
                        //Ende des Jahres: 31. Dezember
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_array()) {
                            $sammelrechnungen = mysqli_fetch_array($connection->query("SELECT DISTINCT sammelrechnungen FROM kunden WHERE kundeID=".$_SESSION['kunde']))["sammelrechnungen"];
                            
                            //Tage nach Zusendung der Sammelrechnungen um Rechnungen zu begleichen
                            $zahlungszielTage = mysqli_fetch_array($connection->query("SELECT DISTINCT zahlungszielTage FROM kunden WHERE kundeID=".$_SESSION['kunde']))["zahlungszielTage"];
                            $rechnungdatum = strtotime($row["rechnungDatum"]);
                            $zahlungslimit = ($zahlungszielTage*86400)+$rechnungdatum;

                            switch ($sammelrechnungen) {
                                case "keine":
                                    echo date('Y-m-d',$zahlungslimit);
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
                                    <td>'.ceil((strtotime($row["bezahltAm"])-$zahlungslimit)/86400).'</td>
                                    <td><button type="button" onclick="">Download</button></td>
                                </tr>';

                                }
                            }

                        $result->free_result();
                        $connection->close();
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