<?php
    set_include_path('C:\xampp\htdocs\rentalCar');

    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require 'library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    require 'library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require 'library/PHPMailer/src/SMTP.php';
    /* TCPDF Einbindung, um eine PDF zu erzeugen*/
    require 'library/TCPDF/tcpdf.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

function check_login($con){
    if(isset($_SESSION['pseudo'])){      
        $id = $_SESSION['pseudo'];
        $query = "select * from kunden where pseudo = '$id' limit 1";

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['mitarbeiterID'] = $user_data['kundeID'];
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
                echo "<p>Die eingegebene ID existiert nicht in der DB oder der Mietvertrag wurde schon abgeschlossen</p>";
                $_SESSION['kundenid'] = null;
                $_SESSION['vertragid'] = null;
                $_SESSION['reservierungid'] = null;
            }
            //Ende der Datenbankverbindung
            mysqli_free_result( $db_erg ); 
            mysqli_close($con); 
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
                                //Datenbankverbindungsende
                                mysqli_close($con);
                                //Ruecknahmeprotokollerzeugungsmethodenaufruf
                                createRuecknahme_pdf($kunde,$nutzungsdaten,$mietvertragid);
                                header("Location: ../index.php");
                            //Catch Block zum Fehlerauswurf
                            } catch (mysqli_sql_exception $e) {
                                if ($e->getCode() == 1062) {
                                    echo "<p>Es wurde bereits ein Ruecknahmeprotokoll fuer die angegegebene Mietvertragsnummer erstellt.</p>";
                                } else {
                                    echo "<p>Fehler bei der Eingabe</p>";
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
            <table>
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
    
        $pdf->writeHTML($total_amount, true, false, true, false, '');
    
            pdf_area_separation($pdf, 7);
    
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
    
    function pdf_area_separation($pdf_file, $separation_lines) {
        for ($i=0; $i<$separation_lines; $i++) {
            $pdf_file->Ln();
        }
    }

    function checkIfIdProtocoleExist(){
        include("../database/db_inc.php");
        $stmt = "select ruecknahmeprotokollID from ruecknahmeprotokolle where mietvertragID = ".$_SESSION['mietvertragid'].";";
        $erg = mysqli_query($con, $stmt);
        $protocole_data = mysqli_fetch_assoc($erg); 
        if($protocole_data){
            return true;
        } else{
            return false;
        }
    }

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