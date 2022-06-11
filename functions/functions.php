<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require '../library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    require '../library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require '../library/PHPMailer/src/SMTP.php';
    /* TCPDF Einbindung, um eine PDF zu erzeugen*/
    require '../library/TCPDF/tcpdf.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function check_login($con){
        if(isset($_SESSION['pseudo'])){      
            $id = $_SESSION['pseudo'];
            $query = "select * from kunden where pseudo = '$id' limit 1";
    
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
                 Es gibt eine Variable $result, welche 'false' ist. Dieser wird bei der Anzeige jedes Tupels auf 'true' gesetzt.
                 Außerdem wereden die "kundenid" und "vertragsid" für die spätere Verwendung in $_SESSION gespeichert.
                 Wenn $result 'false' ist nach der Anzeige der Mietvertragsdaten, bedeutet das, dass es keinen Eintrag für diese Mietvertragsnummer gab,
                 dies wird als Nachricht ausgegeben und die $_SESSION werden auf null gesetzt.
                 Zum Schluss wird das erg freigegeben und die Datenbankverbindung beendet.
                 
    */
    function mietvertragsAnzeige($mietvertragsdaten,$con){
        //Abfrage der Mietvertragsdaten, welche nur geschehen soll, wenn eine 'mietvertragid' uebergeben wurde
        if (isset($mietvertragsdaten['mietvertragid'])) {   
            $stmt = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $mietvertragsdaten["mietvertragid"]; 
            $erg = mysqli_query( $con, $stmt );
            //Fehlerbehandlung, falls die SQL-Anfrage falsch sein sollte 
            if (!$erg ) 
            { 
                die('Fehler in der SQL Anfrage'); 
            }
            //Count welcher die result zaehlt
            $result =  false;
            //Anzeige der Tabelle aus dem erg der Abfrage fuer die Mietvertragsdaten                 
            while ($lease_data = mysqli_fetch_array( $erg, MYSQLI_ASSOC)) 
            { 
                $result = true; 
                echo"<center> 
                <table class='mietdaten'> 
                    <thead> 
                        <tr> 
                            <th>Mietvertragsnummer</th> 
                            <th>Status</th> 
                            <th>Mietdauer in Tagen</th> 
                            <th>Mietgebuehr</th> 
                            <th>Zahlart</th> 
                            <th>Abholstation</th> 
                            <th>Rueckgabestation</th> 
                            <th>Vertragsnummer</th> 
                            <th>Kundennummer</th>
                        </tr> 
                    </thead> 
                    <tbody> 
                        <tr> 
                            <td>{$lease_data['mietvertragID']}</td> 
                            <td>{$lease_data['status']}</td> 
                            <td>{$lease_data['mietdauerTage']}</td> 
                            <td>{$lease_data['mietgebuehr']}</td>     
                            <td>{$lease_data['zahlart']}</td> 
                            <td>{$lease_data['abholstation']}</td> 
                            <td>{$lease_data['rueckgabestation']}</td> 
                            <td>{$lease_data['vertragID']}</td> 
                            <td>{$lease_data['kundeID']}</td> 
                        </tr>  
                    </tbody> 
                </table> 
                </center>";
                //Speicherung der 'kundenid' und 'vertragid' fuer die spaetere Verwendung
                $_SESSION['kundenid'] = $lease_data['kundeID'];
                $_SESSION['vertragid'] = $lease_data['vertragID'];    
            }
            //Ueberpruefen ob $result true ist. Falls nicht, wird die Fehlermeldung ausgegeben und die 'kundenid' und 'vertragid' auf null gesetzt
            if($result == false) 
            { 
                echo "<p>Die eingegebene ID existiert nicht in der DB</p>";
                $_SESSION['kundenid'] = null;
                $_SESSION['vertragid'] = null;
            }
            //Ende der Datenbankverbindung
            mysqli_free_result( $erg ); 
            mysqli_close($con);
            
            
        } 
    }
    /*
        Parameter: $usage_data: Uebergabe der KFZ-relevanten usage_data als Array, 
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
                   Danach werden die customer_data abgefragt durch die $_SESSION['kundenid'], diese werden gespeichert und die Email wird entsprechend gesetzt.
                   Die Datenbankverbindung wird beendet und die createRuecknahme_pdf() wird mit den customer_data '$kunde' und den Parametern $usage_data und $mietvertragid aufgerufen,
                   welches das Ruecknahmeprotokoll als PDF erzeugt und an die Email Adresse aus den customer_data versendet. 
                   mysqli_sql_exceptions werden abgefangen im catch-Block. Falls es sich um einen Fehler mit der Nummer 1062 handelt, 
                   wird die Dopplungsfehlermeldung geworfen, andernfalls wird eine allgemeine Fehlermeldung ausgegeben.   

    */
    function sendeRuecknahmeprotokoll($usage_data,$con,$mietvertragid)
        {  
            //Abfrage ob alle usage_data eingetragen wurden und trimmen dieser.
            if (isset($usage_data['tank'])) 
            {
                $tank = trim($usage_data['tank']);
                if (isset($usage_data['kilometerstand'])) 
            {
                $kilometerstand = trim($usage_data['kilometerstand']);
                if (isset($usage_data['sauberkeit'])) 
                {
                    $sauberkeit = trim($usage_data['sauberkeit']);
                    if (isset($usage_data['mechanik'])) 
                    {
                        $mechanik = trim($usage_data['mechanik']);
                        //Abfrage ob die Mietvertragsnummer gesetzt ist.
                        if (isset($mietvertragid)) 
                        {
                            //try-catch Block, welcher die benoetigten Datenbank-Ab- und Anfragen ausfuehrt und die Methode zur Ruecknahmeprotokollerstellung als PDF und dem Email-Versand aufruft
                            try {
                                //Einfuegen des Ruecknahmeprotokolltupels in die Datenbank #ALTERNATIVE:".$_SESSION['pseudo']."
                                $stmt = "insert INTO ruecknahmeprotokolle (ersteller, tank, sauberkeit, mechanik, kilometerstand, mietvertragID) VALUES ('1','$tank','$sauberkeit','$mechanik','$kilometerstand','$mietvertragid')"; 
                                $erg = $con->query($stmt);
                                //Abfrage der kfzID durch die vertragid
                                $kfzIDAbfrage =  "select kfzID FROM vertraege WHERE vertragID = " . $_SESSION['vertragid'] . ";";
                                $kfzIDs = mysqli_query($con,$kfzIDAbfrage);
                                while($tupel = mysqli_fetch_assoc($kfzIDs)){
                                    $kfzID = $tupel["kfzID"];
                                }
                                //Aktualisierung des Kilometerstandes in der kfzs Datenbank
                                $kfzUpdate = "update kfzs SET kilometerStand = " . $kilometerstand . " WHERE kfzID= " . $kfzID . ";";
                                mysqli_query($con, $kfzUpdate);
                                //Abfrage der customer_data
                                $customer_data_stmt = "select * FROM kunden WHERE kundeID=" . $_SESSION['kundenid'] . ";";
                                $customer_data = mysqli_query($con,$customer_data_stmt);
                                while($tupel = mysqli_fetch_assoc($customer_data)){
                                    $kunde = $tupel;
                                } 
                                //Datenbankverbindungsende
                                mysqli_close($con);
                                //Ruecknahmeprotokollerzeugungsmethodenaufruf
                                createRuecknahme_pdf($kunde,$usage_data,$mietvertragid);
                                header("Location: ../return/return_dialog.php");
                            //Catch Block zum Fehlerauswurf
                            } catch (mysqli_sql_exception $e) {
                                echo "<p>Fehler bei der Eingabe</p>";
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
        Parameter: $customer_data: customer_data als Array
                   $usage_data: Nutzungsdaten als Array
                   $mietvertragid: Mietvertragsnummer
        Inhalt:    createRuecknahme_pdf() ist zur Erzeugung des Ruecknahmeprotokolls und der Email und dem Aufruf zum versenden der Email
    */
    function createRuecknahme_pdf($customer_data, $usage_data,$mietvertragid) {
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
                    <td>'.$customer_data["vorname"]. " " . $customer_data["nachname"].'</td>
                    <td style="text-align:right;">Ruecknahmedatum: '.date("d.m.Y").'</td>
                </tr>
                <tr>
                    <td>'.$customer_data["strasse"]. " " . $customer_data["hausNr"]. '</td>
                    <td style="text-align:right;">Kundennr.:'.$customer_data["kundeID"].'</td>
                </tr>
                <tr>
                    <td>'.$customer_data["ort"].'</td>
                </tr>
            <table>
            <br>';
        //Text zum Ruecknahmeprotokoll und Tabelle mit den nutzungsrelevanten Daten.
        $invoices_data = 
            $style.'
            <b>Ruecknahmeprotokoll</b>
            <pre>
            Sehr geehrter Herr/Frau '.$customer_data["nachname"].'
            Vielen Dank für deine Rueckgabe.
            Du hattest folgende Nutzungsdaten:
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
                    <th>'.$usage_data['tank'].'</th>
                    <th>'.$usage_data['sauberkeit'].'</th>
                    <th>'.$usage_data['mechanik'].'</th>
                    <th>'.$usage_data['kilometerstand'].'</th>
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
        $pdfString = $pdf->Output('rechnung'.$customer_data["kundeID"]."_".date('Y-m-d').'.pdf', 'S');
        //Email Versendungsinformationen
        $subject = 'Ruecknahmeprotokoll';
        $message = '<!DOCTYPE html>
        <html>
        <body>
        <p>Sehr geehrter Herr/Frau '.$customer_data["nachname"].',</p>
        <p>anbei erhaelst du dein Ruecknahmeprotokoll. ;)</p>
        <br>
        <p>Mit lieben Gruessen</p>
        <p>Dein RentalCar-Team</p>
        </body>
        </html>';
        //Aufruf der Emailversendungsmethode
        send_mail($customer_data['emailAdresse'],$subject,$message,$pdfString, 'ruecknahmeprotokoll'.date('Y-m-d').'.pdf');
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
?>