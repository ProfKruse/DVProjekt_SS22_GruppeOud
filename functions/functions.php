<?php
    //set_include_path('C:\xampp\htdocs\rentalCar');

    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    //require '/library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    //require '/library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    //require '/library/PHPMailer/src/SMTP.php';
    /* TCPDF Einbindung, um eine PDF zu erzeugen*/
    //require '/library/TCPDF/tcpdf.php';

    if(!isset($_SESSION)) session_start();
    require(realpath(dirname(__FILE__) . '/../library/PHPMailer/src/Exception.php'));
    /* PHPMailer-Klasse */
    require (realpath(dirname(__FILE__) . '/../library/PHPMailer/src/PHPMailer.php'));
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require (realpath(dirname(__FILE__) . '/../library/PHPMailer/src/SMTP.php'));
    /*TCPDF Einbindung, um eine PDF zu erzeugen*/
    require (realpath(dirname(__FILE__) . '/../library/TCPDF/tcpdf.php'));
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

function check_login($con){
    if(isset($_SESSION['pseudo'])){      
        $id = $_SESSION['pseudo'];
        $query = "select * from kunden where pseudo = '$id' limit 1";

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['kundeID'] = $user_data['kundeID'];
            return $user_data;
        } 
    }else{
        header("Location: ../login/logout.php");
        die;
    }
}
function check_login_Mitarbeiter($con){
    if(isset($_SESSION['pseudo'])){      
        $id = $_SESSION['pseudo'];
        $query = "select * from mitarbeiter where pseudo = '$id' limit 1";

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['mitarbeiterID'] = $user_data['mitarbeiterID'];
            return $user_data;
        } 
    }else{
        header("Location: ../login/logout.php");
        die;
    }
}

function check_no_login($con){
    if(isset($_SESSION['pseudo'])){      
        die;
    }
}


function send_mail($recipient,$subject, $message,$stringAttachment=null,$nameAttachment=null){
    $mail=new PHPMailer(true);
    try {
        
        //Debug Sendmail Pascal
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true)
            );

        $mail->isSMTP();
        $mail->Host='smtp.mail.yahoo.com';
        
        $mail->Username='sihem.ouldmohand@yahoo.com';
        $mail->Password='ugihmzgcrdnrhogf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
        $mail->Port=587;
    
        $mail->SMTPAuth = true;
    
        $mail->setFrom('sihem.ouldmohand@yahoo.com', 'Team Gamma');
    
        //recipient
        $mail->addAddress($recipient, '');
    
        //content
        $mail->isHTML(true); 
        $mail->Subject = $subject;
        $mail->Body= $message;
        
        if($stringAttachment != Null and $nameAttachment !=null){
            $mail->addStringAttachment($stringAttachment, $nameAttachment);
        }
        
        $mail->send();
    } 
    catch(Exception $e) {
        echo 'Email wurde nicht gesendet';
        echo 'Mailer Error: '.$mail->ErrorInfo;
    }
}



/*
      Parameter: $mietvertragsdaten: Uebergabe der Mietvertragsnummer als Array, wessen Daten angezeigt werden sollen
                 $con: Uebergabe der Datenbankverbindung
      Inhalt:    mietvertragsAnzeige() macht eine SQL Anfrage zu einer uebergebenen Mietvertragsnummer 
                 und zeigt die in der Datenbank enthaltenen Informationen zu dieser in einer generierten Tabelle an.
                 Es gibt eine Variable $ergebnisTupel, welche 'false' ist. Dieser wird bei der Anzeige jedes Tupels auf 'true' gesetzt.
                 Außerdem wereden die "kundenid" und "vertragsid" für die spätere Verwendung in $_SESSION gespeichert.
                 Wenn $ergebnistupel 'false' ist nach der Anzeige der Mietvertragsdaten, bedeutet das, dass es keinen Eintrag für diese Mietvertragsnummer gab,
                 dies wird als Nachricht ausgegeben und die $_SESSION werden auf null gesetzt.
                 Zum Schluss wird das Ergebnis freigegeben und die Datenbankverbindung beendet.
                 
    */
    function mietvertragsAnzeige($mietvertragsdaten,$con){
        //Abfrage der Mietvertragsdaten, welche nur geschehen soll, wenn eine 'mietvertragid' uebergeben wurde
        if (isset($mietvertragsdaten['mietvertragid'])) {   
            $statement = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $mietvertragsdaten["mietvertragid"];  
            $db_erg = mysqli_query( $con, $statement );
            //Fehlerbehandlung, falls die SQL-Anfrage falsch sein sollte 
            if (!$db_erg ) 
            { 
                die('Fehler in der SQL Anfrage'); 
            }
            //Count welcher die Ergebnistupel zaehlt
            $ergebnisTupel =  false;
            //Anzeige der Tabelle aus dem Ergebnis der Abfrage fuer die Mietvertragsdaten                 
            while ($zeile = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC)) 
            { 
                $ergebnisTupel = true; 
                echo"<center> 
                <table class='mietdaten'> 
                    <thead> 
                        <tr> 
                            <th>Mietvertragsnummer</th> 
                            <th>Status</th> 
                            <th>Mietdauer in Tagen</th> 
                            <th>Mietgebuehr</th> 
                            <th>Abholstation</th> 
                            <th>Rueckgabestation</th> 
                            <th>Vertragsnummer</th> 
                            <th>Kundennummer</th>
                            <th>Reservierung</th>
                        </tr> 
                    </thead> 
                    <tbody> 
                        <tr> 
                            <td>{$zeile['mietvertragID']}</td> 
                            <td>{$zeile['status']}</td> 
                            <td>{$zeile['mietdauerTage']}</td> 
                            <td>{$zeile['mietgebuehr']}</td>  
                            <td>{$zeile['abholstation']}</td> 
                            <td>{$zeile['rueckgabestation']}</td> 
                            <td>{$zeile['vertragID']}</td> 
                            <td>{$zeile['kundeID']}</td> 
                            <th>{$zeile['reservierungID']}</th>
                        </tr>  
                    </tbody> 
                </table> 
                </center>";
                //Speicherung der 'kundenid' und 'vertragid' fuer die spaetere Verwendung
                $_SESSION['kundenid'] = $zeile['kundeID'];
                $_SESSION['vertragid'] = $zeile['vertragID'];  
                $_SESSION['reservierungid'] = $zeile['reservierungID'];
                if($zeile['status']=="abgeschlossen")
                {
                    $ergebnisTupel =  false;
                }  
            }
            //Ueberpruefen ob $ergebnisTupel true ist. Falls nicht, wird die Fehlermeldung ausgegeben und die 'kundenid', 'vertragid' und 'reservierungid' auf null gesetzt
            if($ergebnisTupel ==  false) 
            { 
                echo "<br><br><br><br><br><p>Die eingegebene ID existiert nicht in der DB oder der Mietvertrag wurde schon abgeschlossen</p><br>";
                $_SESSION['kundenid'] = null;
                $_SESSION['vertragid'] = null;
                $_SESSION['reservierungid'] = null;
            } 
        } 
    }
    /*
        Parameter: $nutzungsdaten: Uebergabe der KFZ-relevanten Nutzungsdaten als Array, 
                   in dem alle dafuervorgesehenen Formulardaten enthalten sind.
                   $con: Uebergabe der Datenbankverbindung
                   $mietvertragid: Uebergabe der Mietvertragsnummer
        Inhalt:    sendeRuecknahmeprotokoll() wird fuer das Versenden des Ruecknahmeprotkolls als Email genutzt.
                   Dann wird ueberprueft ob alle nutzungsrelevanten Formulardaten uebergeben wurden.
                   Daraufhin wird ueberprueft ob $mietvertragid gesetzt wurde. 
                   Wenn dies nicht zutrifft, wird eine Fehlermeldung ausgegeben, dass es einen Fehler bei der Mietvertragsnummer gab.
                   Wenn all dies Zutrifft, beginnt ein try-catch Block, welcher zuerst versucht ein neues Tupel in ruecknahmeprotokolle mit allen angegegeben Informationen einzufuegen.
                   Daraufhin wird die kfzID ueber die 'vertragid' abgefragt. 
                   Mithilfe der kfzID wird der Kilometerstand des Kfzs in der Tabelle 'kfzs' aktualisiert.
                   Danach werden die Kundendaten abgefragt durch die $_SESSION['kundenid'], diese werden gespeichert und die Email wird entsprechend gesetzt.
                   Die Datenbankverbindung wird beendet und die createRuecknahme_pdf() wird mit den Kundendaten '$kunde' und den Parametern $nutzungsdaten und $mietvertragid aufgerufen,
                   welches das Ruecknahmeprotokoll als PDF erzeugt und an die Email Adresse aus den Kundendaten versendet. 
                   mysqli_sql_exceptions werden abgefangen im catch-Block. Falls es sich um einen Fehler mit der Nummer 1062 handelt, 
                   wird die Dopplungsfehlermeldung geworfen, andernfalls wird eine allgemeine Fehlermeldung ausgegeben.   
    */
    function sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragid)
        { 
            //Abfrage ob alle Nutzungsdaten eingetragen wurden und trimmen dieser.
            if (isset($nutzungsdaten['tank'])) 
            {
                $tank = trim($nutzungsdaten['tank']);
                if (isset($nutzungsdaten['kilometerstand'])) 
            {
                $kilometerstand = trim($nutzungsdaten['kilometerstand']);
                if (isset($nutzungsdaten['sauberkeit'])) 
                {
                    $sauberkeit = trim($nutzungsdaten['sauberkeit']);
                    if (isset($nutzungsdaten['mechanik'])) 
                    {
                        $mechanik = trim($nutzungsdaten['mechanik']);
                        //Abfrage ob die Mietvertragsnummer gesetzt ist.
                        if (isset($mietvertragid)) 
                        {
                            //try-catch Block, welcher die benoetigten Datenbank-Ab- und Anfragen ausfuehrt und die Methode zur Ruecknahmeprotokollerstellung als PDF und dem Email-Versand aufruft
                            try {
                                //Einfuegen des Ruecknahmeprotokolltupels in die Datenbank
                                $statement = "INSERT INTO ruecknahmeprotokolle (ersteller,tank,sauberkeit, mechanik, kilometerstand, mietvertragID) VALUES (". $_SESSION['mitarbeiterID'].",'$tank','$sauberkeit','$mechanik','$kilometerstand','$mietvertragid')"; 
                                $ergebnis = $con->query($statement);
                                //Abfrage der kfzID durch die vertragid
                                $kfzIDAbfrage =  "SELECT kfzID FROM vertraege WHERE vertragID = " . $_SESSION['vertragid'] . ";";
                                $kfzIDs = mysqli_query($con,$kfzIDAbfrage);
                                while($tupel = mysqli_fetch_assoc($kfzIDs)){
                                    $kfzID = $tupel["kfzID"];
                                }
                                //Aktualisierung des Kilometerstandes in der kfzs Datenbank
                                $kfzUpdate = "update kfzs SET kilometerStand = " . $kilometerstand . " WHERE kfzID= " . $kfzID . ";";
                                mysqli_query($con, $kfzUpdate);
                                //Aktualisierung des Reservierungsstatus in der Reservierungs Datenbank
                                $reservierungUpdate = "update reservierungen SET status = 'abgeschlossen' WHERE reservierungid= " . $_SESSION['reservierungid'] . ";";
                                mysqli_query($con, $reservierungUpdate);
                                //Abfrage der kundendaten
                                $kundendatenAbfrage = "select * FROM kunden WHERE kundeID=" . $_SESSION['kundenid'] . ";";
                                $kundendaten = mysqli_query($con,$kundendatenAbfrage);
                                $kunde = null;
                                while($tupel = mysqli_fetch_assoc($kundendaten)){
                                    $kunde = $tupel;
                                }
                                //Ruecknahmeprotokollerzeugungsmethodenaufruf
                                createRuecknahme_pdf($kunde,$nutzungsdaten,$mietvertragid);
                                header("Location: ../index.php");
                            //Catch Block zum Fehlerauswurf
                            } catch (mysqli_sql_exception $e) {
                                if ($e->getCode() == 1062) {
                                    echo "<p>Es wurde bereits ein Ruecknahmeprotokoll fuer die angegegebene Mietvertragsnummer erstellt.</p>";
                                } else {
                                    echo "<p>Fehler bei der Eingabe</p>";
                                    $_SESSION['errormessage'] = $e->getMessage();
                                }
                            }                                                  
                        }
                        //Ausgabe, das die Mietvertragsnummer nicht gesetzt ist.
                        else
                        {
                            echo "<p>Die eingegebene ID existiert nicht in der DB, bitte geben Sie eine korrekte ID ein und geben Sie dann erneut die nutzungsrelevanten Daten ein.</p>";
                        }
                    }
                }                       
            }              
        }
    }
    /*
        Parameter: $kundendaten: Kundendaten als Array
                   $nutzungsdaten: Nutzungsdaten als Array
                   $mietvertragid: Mietvertragsnummer
        Inhalt:    createRuecknahme_pdf() ist zur Erzeugung des Ruecknahmeprotokolls und der Email und dem Aufruf zum versenden der Email
    */
    function createRuecknahme_pdf($kundendaten, $nutzungsdaten,$mietvertragid) {
        //Erzeugung eines neuen PDF Files und setzen von Ersteller, Author, Titel und Thema
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Rentalcar GmbH');
        $pdf->setTitle('Ruecknahmeprotokoll');
        $pdf->setSubject('Ruecknahmeprotokoll');
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        //neue, bzw. erste Seite fuer die PDF
        $pdf->AddPage();
        //Style Vorgaben
        $style = <<<EOF
            <style>
                * {
                    line-height: 100%;
                    font-family: Monospace;
                }
            </style>
            EOF;
        //Kundenanschrift, Datum und Kundennummer
        $sender_receiver_information = 
            $style.'
            <h1 style="font-family: Arial;">Rentalcar</h1>
            <table>
                <tr>
                    <td>'.$kundendaten["vorname"]. " " . $kundendaten["nachname"].'</td>
                    <td style="text-align:right;">Ruecknahmedatum: '.date("d.m.Y").'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["strasse"]. " " . $kundendaten["hausNr"]. '</td>
                    <td style="text-align:right;">Kundennr.:'.$kundendaten["kundeID"].'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["ort"].'</td>
                </tr>
            </table>
            <br>';
        //Text zum Ruecknahmeprotokoll und Tabelle mit den nutzungsrelevanten Daten.
        $invoices_data = 
            $style.'
            <b>Ruecknahmeprotokoll</b>
            <pre>
Sehr geehrter Herr/Frau '.$kundendaten["nachname"].'
Vielen Dank für Ihre Rueckgabe.
Sie hatten folgende Nutzungsdaten:
            </pre>
            <table>
                <tr style="background-color: rgb(228, 228, 228);">
                    <th>Nr.</th>
                    <th>Tank</th>
                    <th>Sauberkeit</th>
                    <th>Mechanik</th>
                    <th>KM-Stand</th>
                </tr>
                <tr style="background-color: rgb(228, 228, 228);">
                    <th>'.$mietvertragid.'</th>
                    <th>'.$nutzungsdaten['tank'].'</th>
                    <th>'.$nutzungsdaten['sauberkeit'].'</th>
                    <th>'.$nutzungsdaten['mechanik'].'</th>
                    <th>'.$nutzungsdaten['kilometerstand'].'</th>
                </tr>                  
            </table>
            <br>
            <hr>';
    
        //Kontaktinformationen von Rental Car als Footer
        $contact_information = <<<EOF
            $style
            <table>
                <tr>
                    <td>Rentalcar GmbH</td>
                    <td>Telefon: +49 1234 5678</td>
                </tr>
                <tr>
                    <td>Straße 1</td>
                    <td>E-Mail: contact@rentalcar.com</td>
                </tr>
                <tr>
                    <td>12345 Ort</td>
                    <td>Web: www.rentalcar.com</td>
                </tr>
            </table>
            EOF;
        //Schreiben der obigen Texte in die PDF  
        $pdf->writeHTML($sender_receiver_information, true, false, true, false, '');
    
            pdf_area_separation($pdf, 5);
    
        $pdf->writeHTML($invoices_data, true, false, true, false, '');
    
            pdf_area_separation($pdf, 15);
    
    
        $pdf->writeHTML($contact_information, true, false, true, false, '');
        ob_end_clean();
        //Speichern der PDF als String
        $pdfString = $pdf->Output('rechnung'.$kundendaten["kundeID"]."_".date('Y-m-d').'.pdf', 'S');
        //Email Versendungsinformationen
        $subject = 'Ruecknahmeprotokoll';
        $message = '<!DOCTYPE html>
        <html>
        <body>
        <p>Sehr geehrter Herr/Frau '.$kundendaten["nachname"].',</p>
        <p>anbei erhaelst du dein Ruecknahmeprotokoll. ;)</p>
        <br>
        <p>Mit lieben Gruessen</p>
        <p>Dein RentalCar-Team</p>
        </body>
        </html>';
        //Aufruf der Emailversendungsmethode
        send_mail($kundendaten['emailAdresse'],$subject,$message,$pdfString, 'ruecknahmeprotokoll'.date('Y-m-d').'.pdf');
    }

    /*
        Inhalt: Erzeugt einen Mietvertrag als Datei im PDF-Format
        Parameter: $kundendaten: Alle relevanten über den Kunden, an den der Vertrag gestellt wird
                   $vertragsdaten: Alle relevanten Daten eines Mietvertrags, welche in die PDF übernommen werden
                   $type: Gibt an, ob der generierte Mietvertag als PDF im Format im Browser angezeigt wird oder ob dieser als PDF per E-Mail Anhang verschickt werden soll
    */
    function createMietvertragPDF($kundendaten, $vertragsdaten, $type) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Rentalcar GmbH');
        $pdf->setTitle('Mietvertrag');
        $pdf->setSubject('Mietverträge');
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
    
        $pdf->AddPage();
    
        $style = <<<EOF
            <style>
                * {
                    line-height: 100%;
                    font-family: Monospace;
                }
            </style>
            EOF;
    
        $vertragsdatum = date("d.m.Y");
    
        $sender_receiver_information = 
            $style.'
            <h1 style="font-family: Arial;">Rentalcar</h1>
            <table>
                <tr>
                    <td>'.$kundendaten["name"].'</td>
                    <td style="text-align:right;">Vertragsdatum: '.$vertragsdatum.'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["straße"].'</td>
                    <td style="text-align:right;">Kundennr.:'.$kundendaten["kundennr"].'</td>
                </tr>
            </table>
            <br>';
    
        $rental_data = 
            $style.'
            <b>Mietvertrag</b>
            <pre>
Sehr geehrter Herr/Frau '.$kundendaten["name"].'
Vielen Dank für ihre Aufträge.
Folgend die Mietvertragsdaten:
            </pre>
    
            <table>
                <tr style="background-color: rgb(228, 228, 228);">
                    <th>Nr.</th>
                    <th>Marke</th>
                    <th>Modell</th>
                    <th>Datum</th>
                    <th>Mietdauer</th>
                    <th>Mietgebühr</th>
                    <th>Abholstation</th>
                </tr>
                <tr>';


                foreach($vertragsdaten as $key => $value) {
                    if($key == 'mietgebuehr')
                        $value = round($value,2);
                    $rental_data.="<td>$value";

                    if($key == 'mietgebuehr')
                        $rental_data.="€";
                        
                    $rental_data.="</td>";
                }
        $rental_data.='</tr>
                    </table>
                    <br>
                    <hr>';
    
        $total_amount =
            $style.'
            <hr>
            <pre style="text-align: right;">
            Nettobetrag: ';
    
            $nettobetrag = $vertragsdaten["mietgebuehr"];
            $nettobetrag = round($nettobetrag,2);
        
            $total_amount .=  $nettobetrag.'€
            </pre>
            <hr>
            <br>';
    
        $contact_information = <<<EOF
            $style
            <table>
                <tr>
                    <td>Rentalcar GmbH</td>
                    <td>Telefon: +49 1234 5678</td>
                </tr>
                <tr>
                    <td>Straße 1</td>
                    <td>E-Mail: contact@rentalcar.com</td>
                </tr>
                <tr>
                    <td>12345 Ort</td>
                    <td>Web: www.rentalcar.com</td>
                </tr>
            </table>
            EOF;
    
        $pdf->writeHTML($sender_receiver_information, true, false, true, false, '');
    
            pdf_area_separation($pdf, 5);
    
        $pdf->writeHTML($rental_data, true, false, true, false, '');
    
            pdf_area_separation($pdf, 15);
    
        $pdf->writeHTML($total_amount, true, false, true, false, '');
    
            pdf_area_separation($pdf, 7);
    
        $pdf->writeHTML($contact_information, true, false, true, false, '');
        if (ob_get_contents()) ob_end_clean();
        
        $output_type = $type == 'file' ? 'I' : 'S';
        $pdfString = $pdf->Output("mietvertrag_".$kundendaten["kundennr"]."_".date('Y-m-d').'.pdf', $output_type);
    
        if($type == 'mail') {
            send_mail($kundendaten["email"],'Mietvertrag zum '.date('d.m.Y'),
            'Sehr geehrte/r Frau/Herr '.$kundendaten['name'].',<br><br>Dem Anhang koennen sie ihren Mietvertrag entnehmen.<br><br>Vielen Dank fuer ihren Auftrag.',
            $pdfString, 'mietvertrag_'.date('Y-m-d').'.pdf');
        }
    }

    /*
        Inhalt: Legt eine neue Rechnung für den Mietvertrag mit der übergebenen Mietvertrag ID in der Datenbank an
        Parameter: $mietvertragId: ID des Mietvertrags in der Datenbank, anhand dessen eine Rechnung erstellt werden soll
    */
    function rechnungAnlegen($mietvertragId) {
        global $con;

        $ID = 0;
        $mietvertrag = mysqli_fetch_array($con->query("SELECT * FROM mietvertraege WHERE mietvertragID=$mietvertragId"));
        if($mietvertrag != NULL) {
                $rechnungdatum   = strtotime(date("Y-m-d"));
                $zahlungslimit;
                $versanddatum;

                $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$mietvertrag["kundeID"]));
                $zahlungszielTage = $kunde["zahlungszielTage"];
                $zahlungslimit = ($zahlungszielTage*86400)+$rechnungdatum;

                switch ($kunde["sammelrechnungen"]) {
                    case "keine":
                        $versanddatum = strtotime(date("Y-m-d"));
                        break;

                    case "woechentlich":
                        if (date('D',$rechnungdatum) != 'Mon') {
                            $versanddatum = strtotime('next monday');
                            $zahlungslimit = $zahlungslimit - $rechnungdatum + strtotime('next monday');
                        
                        }
                        break;

                    case "monatlich":
                        if(explode('-',$mietvertrag['rechnungDatum'])[2] != '01') {
                            $versanddatum = strtotime('first day of next month');
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
                                $versanddatum = $quartal_1;
                                $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_1;
                            }

                            if($rechnungdatum > $quartal_1 && $rechnungdatum < $quartal_2) {
                                $versanddatum = $quartal_2;
                                $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_2;
                            }

                            if($rechnungdatum > $quartal_2 && $rechnungdatum < $quartal_3) {
                                $versanddatum = $quartal_3;
                                $zahlungslimit = $zahlungslimit - $rechnungdatum + $quartal_3;
                            }

                            if($rechnungdatum > $quartal_3) {
                                $versanddatum = $quartal_4;
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
                                $versanddatum = $erstes_halbjahr;
                                $zahlungslimit = $zahlungslimit - $rechnungdatum + $erstes_halbjahr;
                            }
                            else {
                                $versanddatum = $zweites_halbjahr;
                                $zahlungslimit = $zahlungslimit - $rechnungdatum + $zweites_halbjahr;
                            }
                        }
                        break;

                    case "jaehrlich":
                        if(date('m-d',$rechnungdatum) != '01-01') {
                            $versanddatum = strtotime(date('Y-01-01',strtotime('+1 year')));
                            $zahlungslimit = $zahlungslimit - $rechnungdatum + strtotime(date('Y-01-01',strtotime('+1 year')));
                        }
                        break;
                    }

                    $zahlungslimit = date('Y-m-d',$zahlungslimit);
                    $versanddatum = date('Y-m-d',$versanddatum);

                    $ID = mysqli_fetch_array($con->query("SELECT rechnungNr FROM rechnungen ORDER BY rechnungNr DESC"))[0]+1;
                    $insertStatement = "INSERT INTO rechnungen (mietvertragID, kundeID, rechnungDatum, rechnungBetrag, mahnstatus, zahlungslimit, versanddatum)
                        VALUES ($mietvertragId, ".$mietvertrag["kundeID"].", '".date('Y-m-d')."', ".$mietvertrag["mietgebuehr"].", 'keine', '$zahlungslimit', '$versanddatum') ";

                    $con->query($insertStatement);
            }
        return $ID;
    }

    /*
        Inhalt: Erzeugt eine Rechnung als Datei im PDF-Format
        Parameter: $kundendaten: Alle relevanten über den Kunden, an den die Rechnung gestellt wird
                   $rechnungsdaten: Alle relevanten Daten einer oder mehrerer Rechnungen, welche in die PDF übernommen werden
                   $type: Gibt an, ob der generierte Mietvertag als PDF im Format im Browser angezeigt wird oder ob dieser als PDF per E-Mail Anhang verschickt werden soll
                   $einzelrechnungNr: Unterscheidung in Einzelrechnung & Sammelrechnungen für die Bezeichnung innerhalb des Textes
    */
    function createRechnungPDF($kundendaten, $rechnungsdaten, $type) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Rentalcar GmbH');
        $pdf->setTitle('Rechnung');
        $pdf->setSubject('Rechnungen');
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
    
        $pdf->AddPage();
    
        $style = <<<EOF
            <style>
                * {
                    line-height: 100%;
                    font-family: Monospace;
                }
            </style>
            EOF;
    
        $rechnungsdatum = date("d.m.Y");
        $rechnungstyp = $kundendaten["sammelrechnungen"] == 'keine' ? 'Einzelrechnung' : 'Sammelrechnung';
    
        $sender_receiver_information = 
            $style.'
            <h1 style="font-family: Arial;">Rentalcar</h1>
            <table>
                <tr>
                    <td>'.$kundendaten["name"].'</td>
                    <td style="text-align:right;">Rechnungsdatum: '.$rechnungsdatum.'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["straße"].'</td>
                    <td style="text-align:right;">Kundennr.:'.$kundendaten["kundennr"].'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["stadt"].'</td>
                    <td style="text-align:right;">Zahlbar bis: '.date("d.m.Y",strtotime($rechnungsdaten[0]["zahlungslimit"])).'</td>
                </tr>
            </table>
            <br>';
    
        $invoices_data = 
            $style.'
            <b>Rechnung</b>
            <pre>
Sehr geehrter Herr/Frau '.$kundendaten["name"].'
Vielen Dank für ihre Aufträge.
Wir erlauben uns folgende Rechnungsstellung:
            </pre>
    
            <table>
                <tr style="background-color: rgb(228, 228, 228);">
                    <th>Nr.</th>
                    <th>Marke</th>
                    <th>Modell</th>
                    <th>Kennzeichen</th>
                    <th>Mietdauer</th>
                    <th>Gesamtpreis</th>
                </tr>';


    
                foreach($rechnungsdaten as $rechnung) {
                    $invoices_data.='<tr>';
                    foreach($rechnung as $key => $value) {
                        if ($key == "zahlungslimit")
                            continue;
                        $invoices_data.="<td>$value</td>";
                    }
                    $invoices_data.='</tr>';
                }
    
        $invoices_data.='
            </table>
            <br>
            <hr>';
    
        $total_amount =
            $style.'
            <hr>
            <pre style="text-align: right;">
            Nettobetrag: ';
    
            $nettobetrag = 0;
            foreach($rechnungsdaten as $rechnung) {
                $nettobetrag += $rechnung["gesamtpreis"];
            }
        
            $total_amount .=  $nettobetrag.'€
            zzgl. 19% MwSt: '.($nettobetrag*0.19).'€
            <b>Gesamtbetrag:'.($nettobetrag+($nettobetrag*0.19)).'€</b>
            </pre>
            <hr>
            <br>';
    
        $contact_information = <<<EOF
            $style
            <table>
                <tr>
                    <td>Rentalcar GmbH</td>
                    <td>Telefon: +49 1234 5678</td>
                </tr>
                <tr>
                    <td>Straße 1</td>
                    <td>E-Mail: contact@rentalcar.com</td>
                </tr>
                <tr>
                    <td>12345 Ort</td>
                    <td>Web: www.rentalcar.com</td>
                </tr>
            </table>
            EOF;
    
        $pdf->writeHTML($sender_receiver_information, true, false, true, false, '');
    
            pdf_area_separation($pdf, 5);
    
        $pdf->writeHTML($invoices_data, true, false, true, false, '');
    
            pdf_area_separation($pdf, 15);
    
        $pdf->writeHTML($total_amount, true, false, true, false, '');
    
            pdf_area_separation($pdf, 7);
    
        $pdf->writeHTML($contact_information, true, false, true, false, '');
        if (ob_get_contents()) ob_end_clean();
        
        $output_type = $type == 'file' ? 'I' : 'S';
        $pdfString = $pdf->Output("rechung_".$kundendaten["kundennr"]."_".date('Y-m-d').'.pdf', $output_type);
    
        if($type == 'mail') {
            send_mail($kundendaten["email"],'Rechnung zum '.date('d.m.Y'),
            'Sehr geehrte/r Frau/Herr '.$kundendaten['name'].',<br><br>Dem Anhang koennen sie ihre '.$rechnungstyp.' entnehmen.<br><br>Vielen Dank fuer ihren Auftrag.',
            $pdfString, 'rechnung_'.date('Y-m-d').'.pdf');
        }
    }

    /*
        Inhalt: Erzeugt eine Rechnung als Datei im PDF-Format
        Parameter: $kundendaten: Alle relevanten über den Kunden, an den die Rechnung gestellt wird
                   $rechnungsdaten: Alle relevanten Daten einer oder mehrerer Rechnungen, welche in die PDF übernommen werden
                   $type: Gibt an, ob der generierte Mietvertag als PDF im Format im Browser angezeigt wird oder ob dieser als PDF per E-Mail Anhang verschickt werden soll
                   $einzelrechnungNr: Unterscheidung in Einzelrechnung & Sammelrechnungen für die Bezeichnung innerhalb des Textes
    */
    function createMahnungPDF($kundendaten, $mahnungsdaten, $type) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Rentalcar GmbH');
        $pdf->setTitle('Mahnung');
        $pdf->setSubject('Mahnungen');
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
    
        $pdf->AddPage();
        
    
        $style = <<<EOF
            <style>
                * {
                    line-height: 100%;
                    font-family: Monospace;
                }
            </style>
            EOF;
        
        $betrag = $mahnungsdaten["rechnungbetrag"]+($mahnungsdaten["rechnungbetrag"]*0.19);

        $mahngebuehr = 0;
        $verzugszinsen = 0;
        if($mahnungsdaten["mahnungnr"] > 1) {
            $mahngebuehr = (0.05*$betrag) > 150 ? 150 : (0.05*$betrag);
            if($mahngebuehr < 5) {
                $mahngebuehr = 5;
            }
            
            $säumnistage = (strtotime(date("Y-m-d"))-strtotime($mahnungsdaten["alte_zahlungsfrist"]))/86400;
            $forderungsbetrag = $betrag;
            $verzugszinsen = sprintf("%.2f",$forderungsbetrag*0.05*$säumnistage/365*100);             
        }
        $mahngebuehr = round($mahngebuehr,2);    
        $mahnungsdatum = date("d.m.Y");
    
        $sender_receiver_information = 
            $style.'
            <h1 style="font-family: Arial;">Rentalcar</h1>
            <table>
                <tr>
                    <td>'.$kundendaten["name"].'</td>
                    <td style="text-align:right;">Rechnungsdatum: '.$mahnungsdatum.'</td>
                </tr>
                <tr>
                    <td>'.$kundendaten["straße"].'</td>
                    <td style="text-align:right;">Kundennr.:'.$kundendaten["kundennr"].'</td>
                </tr>
            </table>
            <br>';
    
        $reminder_1 = 
            $style.'
            <br>Da das Zahlungsziel nicht eingehalten wurde bitten wir sie bis zum <br>'.$mahnungsdaten["neue_zahlungsfrist"].
            ' den geforderten Betrag von '.$mahnungsdaten["rechnungbetrag"].' zu zahlen.<br>'.
            '<br>Wir erlauben uns Ihnen eine Mahngebühr und Verzugszinsen beim Überschreiten der neuen Zahlungsfrist in Rechnung zu stellen.';

        $reminder_2 = 
        $style.'
            <br>Da das Zahlungsziel erneut nicht eingehalten wurde fordern wir sie <br>erneut zu einer Zahlung des Betrags bis zum '.$mahnungsdaten["neue_zahlungsfrist"].' auf.
            <br>Da die zweite Zahlungsfrist nicht eingehalten wurde, wird eine Mahngebühr in Höhe von '.$mahngebuehr.'€ erhoben zuzüglich Verzugszinsen in Höhe von <br>4% p.a.';
           
        $reminder_3 = 
            $style.'
            <br>Da der geforderte Betrag nach zweimaliger Aufforderungen nicht innerhalb der verlängerten Zahlungsfrist beglichen wurde, werden wir von<br>einem gerichtlichen Mahnverfahren Gebrauch machen, sollte der<br>
unten geforderte Betrag nicht innerhalb von 7 Tagen, bis zum<br>'.$mahnungsdaten["neue_zahlungsfrist"].' eingangen sein.';

        $reminder = ($mahnungsdaten["mahnungnr"] == 1) ? $reminder_1 : $reminder_2;

        if($mahnungsdaten["mahnungnr"] == 3) {
            $reminder = $reminder_3;
        }

        $reminder_data = 
            $style.'
            <b>Mahnung</b>
            <pre>
Sehr geehrter Herr/Frau '.$kundendaten["name"].'<br><
<br>Die Rechnung mit der Nr. '.$mahnungsdaten["rechnungnr"].' vom '.$mahnungsdaten["rechnungdatum"].' hat eine Zahlungsfrist
von '.$kundendaten["zahlungsziel"].' Tagen und war zum '.$mahnungsdaten["alte_zahlungsfrist"].' fällig.<br>'.$reminder.'
            </pre>
            <br>
            <hr>';
    
       $total_amount =
            $style.'
            <hr>
            <pre style="text-align: right;">
            Nettobetrag: ';
    
            $nettobetrag = $mahnungsdaten["rechnungbetrag"];
        
            $total_amount .=  $nettobetrag.'€
            zzgl. 19% MwSt: '.($nettobetrag*0.19).'€
            <br>Mahngebühr +'.$mahngebuehr.'€
            Verzugszinsen +'.$verzugszinsen.'€
            <b>Gesamtbetrag:'.($betrag+$mahngebuehr+$verzugszinsen).'€</b>
            </pre>
            <hr>
            <br>';
    
        $contact_information = <<<EOF
            $style
            <table>
                <tr>
                    <td>Rentalcar GmbH</td>
                    <td>Telefon: +49 1234 5678</td>
                </tr>
                <tr>
                    <td>Straße 1</td>
                    <td>E-Mail: contact@rentalcar.com</td>
                </tr>
                <tr>
                    <td>12345 Ort</td>
                    <td>Web: www.rentalcar.com</td>
                </tr>
            </table>
            EOF;
    
        $pdf->writeHTML($sender_receiver_information, true, false, true, false, '');
    
            pdf_area_separation($pdf, 5);
    
        $pdf->writeHTML($reminder_data, true, false, true, false, '');
    
            pdf_area_separation($pdf, 15);
    
        $pdf->writeHTML($total_amount, true, false, true, false, '');
    
            pdf_area_separation($pdf, 7);
    
        $pdf->writeHTML($contact_information, true, false, true, false, '');
        if (ob_get_contents()) ob_end_clean();
        
        $output_type = $type == 'file' ? 'I' : 'S';
        $pdfString = $pdf->Output("mahnung_".$kundendaten["kundennr"]."_".date('Y-m-d').'.pdf', $output_type);
    
        if($type == 'mail') {
            send_mail($kundendaten["email"],'Mahnung zum '.date('d.m.Y'),
            'Sehr geehrte/r Frau/Herr '.$kundendaten['name'].',<br><br>Dem Anhang koennen sie die Mahnung zur Zahlungsauforderung entnehmen.<br><br>Ihr Rentalcar Team.',
            $pdfString, 'mahnung_'.date('Y-m-d').'.pdf');
        }
    }

    /*
        Generiert für, für jeden Kunden einzeln, Mahnungen für die Rechnungen, dessen Zahlungslimit auf den aktuellen Tag fällt und noch nicht beglichen wurden und verschickt
        diese per E-Mail an den jeweilgen Kunden.
        Die Funktion wird 1x am Tag von der Aufgabe "Mahnungen_Versand", beschrieben in trigger/Mahnungen_Versand.xml, von der Windows Aufgabenplanung aufgerufen
    */
    function mahnungenEvent() {
        require_once(realpath(dirname(__FILE__) . '/../invoice/reminder.php'));
        $con = mysqli_connect($host, $user, $passwd, $schema);
        $rechnungnummern = array();

        $rechnungen = $con->query("SELECT * FROM rechnungen WHERE bezahltAm IS NULL");
        if($rechnungen) {
            while($row = $rechnungen->fetch_assoc()) {
                $verzug = 0;
                if($row["mahnstatus"] == 'erste Mahnung') {
                    $verzug = 7;
                }
                if($row["mahnstatus"] == 'zweite Mahnung') {
                    $verzug = 14;
                }
                if($row["mahnstatus"] == 'dritte Mahnung') {
                    $verzug = 21;
                }
                $zahltag = date("Y-m-d",  strtotime(" + ".($verzug+1)." day", strtotime($row["zahlungslimit"])));

                if(date("Y-m-d") == $zahltag) {
                    array_push($rechnungnummern, $row["rechnungNr"]);
                }
            }
        }

        foreach($rechnungnummern as $nummer) {
            sendReminder($nummer,'mail');
        }
    }

    /*
        Generiert für , jeden Kunden einzeln welcher Sammelrechnungen vereinbart hat, aus allen Rechnungen die am aktuellen Tag zu versenden sind eine Sammelrechnung und verschickt
        diese per E-Mail an den jeweiligen Kunden.
        Die Funktion wird 1x am Tag von der Aufgabe "Sammelrechnungen_Versand", beschrieben in trigger/Sammelrechnungen_Versand.xml, von der Windows Aufgabenplanung aufgerufen
    */
    function sammelrechnungenEvent() {
        require_once(realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
        $con = mysqli_connect($host, $user, $passwd, $schema);
        $heute = date("Y-m-d");
        echo $heute;
        $zahlungsausstehendeKunden = $con->query("SELECT DISTINCT kundeID FROM rechnungen WHERE kundeID IN (SELECT DISTINCT kundeID FROM kunden WHERE sammelrechnungen != 'keine') AND versanddatum = '$heute'");
        $kundendaten;
        $rechnungsdaten = array();

        if($zahlungsausstehendeKunden != null) {
            
            while($rowKunde = $zahlungsausstehendeKunden->fetch_assoc()) {
                $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$rowKunde["kundeID"]));
                $kundendaten = array("kundennr"=>$kunde["kundeID"],"name"=>$kunde["vorname"]." ".$kunde["nachname"],"straße"=>$kunde["strasse"]." ".$kunde["hausNr"],"stadt"=>$kunde["plz"]." ".$kunde["ort"],"email"=>$kunde["emailAdresse"],"sammelrechnungen"=>$kunde["sammelrechnungen"]);

                $heutigeRechnungen = $con->query("SELECT * FROM rechnungen WHERE kundeID = ".$rowKunde['kundeID']." AND versanddatum = '$heute'");
                if($heutigeRechnungen != null) {
                    while($rowRechnung = $heutigeRechnungen->fetch_assoc()) {
                        $rechnungnr = $rowRechnung["rechnungNr"];
                        $gesamtpreis = $rowRechnung["rechnungBetrag"];
    
                        $mietvertrag = mysqli_fetch_array($con->query("SELECT * FROM mietvertraege WHERE mietvertragID=".$rowRechnung["mietvertragID"]));
                        $mietdauer = $mietvertrag["mietdauerTage"];
    
                        $vertrag = mysqli_fetch_array($con->query("SELECT * FROM vertraege WHERE vertragID=".$mietvertrag["vertragID"]));
                        $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=".$vertrag["kfzID"]));
    
                        $marke = $kfz["marke"];
                        $modell = $kfz["modell"];
                        $kennzeichen = $kfz["kennzeichen"];
                        
                        array_push($rechnungsdaten,array("rechnungsnr"=>$rechnungnr,"marke"=>$marke,"modell"=>$modell,"kennzeichen"=>$kennzeichen,"mietdauer"=>$mietdauer,"gesamtpreis"=>$gesamtpreis,"zahlungslimit"=>$rowRechnung["zahlungslimit"]));
                    }
                    createRechnungPDF($kundendaten,$rechnungsdaten,'mail');
                }
            }
        }
    }
    
    function pdf_area_separation($pdf_file, $separation_lines) {
        for ($i=0; $i<$separation_lines; $i++) {
            $pdf_file->Ln();
        }
    }

    function checkIfIdProtocoleExist(){
        include(realpath(dirname(__FILE__) . '/../database/db_inc.php'));
        $stmt = "select ruecknahmeprotokollID from ruecknahmeprotokolle where mietvertragID = ".$_SESSION['mietvertragid'].";";
        $erg = mysqli_query($con, $stmt);
        $protocole_data = mysqli_fetch_assoc($erg); 
        if($protocole_data){
            return true;
        } else{
            return false;
        }
    }

    function checkIfIdMietvertragExist(){
        include(realpath(dirname(__FILE__) . '/../database/db_inc.php'));
        try{
            $stmt = "select mietvertragID from mietvertraege where mietvertragID = ". $_SESSION['mietvertragid'].";";
            $erg = mysqli_query($con, $stmt);
            $protocole_data = mysqli_fetch_assoc($erg);
            if($protocole_data){
                return true;
            } else{
                return false;
            } 
        }
        catch(mysqli_sql_exception $e){
            return false;
        }
    }

        /*
        Inhalt: Schickt eine SELECT-Anfrage mit konkreter Spalte, konkreter Tabelle und Bedingung an die Datenbank
        Parameter: $spalte: SELECT Teil der Anfrage / Einzelne Spalte (* nicht möglich) welche abgefragt wird
                   $tabelle: FROM Teil der Anfrage / Tabelle von welcher der Spaltenwert abgefragt wird
                   $bedingung: WHERE Teil der Anfrage / Bedingung, welche erfüllt werden muss, damit ein Spaltenwert mit in das Ergebnis übernommen wird
                   $con: Connection-Objekt über welches eine Verbindung zur Datenbank besteht an die die Anfrage geschickt wird 
        Return: Gibt ein Array zurück in welchem Zeilenweise die Werte für die Spalte gespeichert sind
    */
    function databaseSelectQuery($spalte, $tabelle, $bedingung=NULL) {
        global $con; 
    
        $result = $con->query("SELECT $spalte FROM $tabelle $bedingung");
        $array = array();
        
        if($result != null) {
            while($row = $result->fetch_assoc()) {
                array_push($array, $row[$spalte]);
            }
            $result->free_result();
        }
        return $array;
    }
    
    function getUserData() {
        if(!isset($_SESSION)) { session_start(); } 
    
        global $con;
    
        if(!isset($_SESSION['pseudo'])) {
            return null;
        }
    
        $result = $con->query("SELECT * FROM kunden WHERE pseudo='".$_SESSION['pseudo']."'");
    
        $data = array();
        if($result != null > 0) {
            while($row = $result->fetch_assoc()) {
                $data["kundeID"] = $row["kundeID"];
                $data["vorname"] = $row["vorname"];
                $data["nachname"] = $row["nachname"];
                $data["strasse"] = $row["strasse"];
                $data["hausNr"] = $row["hausNr"];
                $data["plz"] = $row["plz"];
                $data["ort"] = $row["ort"];
                $data["land"] = $row["land"];
                $data["iban"] = $row["iban"];
                $data["bic"] = $row["bic"];
                $data["telefonNr"] = $row["telefonNr"];
                $data["emailAdresse"] = $row["emailAdresse"];
                $data["kontostand"] = $row["kontostand"];
                $data["sammelrechnungen"] = $row["sammelrechnungen"];
                $data["zahlungszielTage"] = $row["zahlungszielTage"];
            }
        }
        return $data;
    }
    
?>