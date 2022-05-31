<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require '../library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    require '../library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require '../library/PHPMailer/src/SMTP.php';

    require '../library/TCPDF/tcpdf.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
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
        }
        header("Location: ../login/login.php");
        die;
    }
    
    
    function send_mail($recipient,$subject, $message,$stringAttachement=null,$nameAttachment=null){
        $mail=new PHPMailer(true);
        try {
            //settings
    
            $mail->isSMTP();
            $mail->Host='smtp.mail.yahoo.com';
            
            $mail->Username='gamma_autovermietung@yahoo.com';
            $mail->Password='njnzwgvpkcjmnsji';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            
            $mail->Port=587;
        
            $mail->SMTPAuth = true;
        
            $mail->setFrom('gamma_autovermietung@yahoo.com', 'Team Gamma');
        
            //recipient
            $mail->addAddress($recipient, '');
        
            //content
            $mail->isHTML(true); 
            $mail->Subject = $subject;
            $mail->Body= $message;
            
            if($stringAttachement != Null and $nameAttachment !=null){
                $mail->addStringAttachment($stringAttachement, $nameAttachment);
            }
            
            $mail->send();
    
    
        } 
        catch(Exception $e) {
            echo 'Email wurde nicht gesendet';
            echo 'Mailer Error: '.$mail->ErrorInfo;
        }
    }

    function mietvertragsAnzeige($mietvertragsdaten,$con){
        if (isset($mietvertragsdaten['mietvertragid'])) { 
            $_SESSION['mietvertragid'] = $mietvertragsdaten["mietvertragid"];  
            $statement = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $_SESSION['mietvertragid']; 
            $db_erg = mysqli_query( $con, $statement ); 
            if (!$db_erg ) 
            { 
                die('Fehler in der SQL Anfrage'); 
            }
            $count =  0;                 
            while ($zeile = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC)) 
            { 
                $count = $count+1; 
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
                            <td>{$zeile['mietvertragID']}</td> 
                            <td>{$zeile['status']}</td> 
                            <td>{$zeile['mietdauerTage']}</td> 
                            <td>{$zeile['mietgebuehr']}</td>     
                            <td>{$zeile['zahlart']}</td> 
                            <td>{$zeile['abholstation']}</td> 
                            <td>{$zeile['rueckgabestation']}</td> 
                            <td>{$zeile['vertragID']}</td> 
                            <td>{$zeile['kundeID']}</td> 
                        </tr>  
                    </tbody> 
                </table> 
                </center>";
                $_SESSION['kundenid'] = $zeile['kundeID'];
                $_SESSION['vertragid'] = $zeile['vertragID'];    
            } 
            if($count ==  0) 
            { 
                echo "<p>Die eingegebene ID existiert nicht in der DB</p>";
                $_SESSION['mietvertragID'] = null;
                $_SESSION['kundenid'] = null;
                $_SESSION['vertragid'] = null;
            }
            mysqli_free_result( $db_erg ); 
            mysqli_close($con); 
        } 
    }

    function sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragsid)
        {  
            $email = "";
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
                        if (isset($mietvertragsid)) 
                        {
                            try {
                                $statement = "INSERT INTO ruecknahmeprotokolle (ersteller,tank,sauberkeit, mechanik, kilometerstand, mietvertragID) VALUES (1,'$tank','$sauberkeit','$mechanik','$kilometerstand','$mietvertragsid')"; 
                                $ergebnis = $con->query($statement);
                                $kfzIDAbfrage =  "SELECT kfzID FROM vertraege WHERE vertragID = " . $_SESSION['vertragid'] . ";";
                                $kfzIDs = mysqli_query($con,$kfzIDAbfrage);
                                while($tupel = mysqli_fetch_assoc($kfzIDs)){
                                    $kfzID = $tupel["kfzID"];
                                }
                                $kfzUpdate = "UPDATE kfzs SET kilometerStand = " . $kilometerstand . " WHERE kfzID= " . $kfzID . ";";
                                mysqli_query($con, $kfzUpdate);

                                $emailAbfrage = "SELECT emailAdresse FROM kunden WHERE kundeID=" . $_SESSION['kundenid'] . ";";
                                $emailAdressen = mysqli_query($con,$emailAbfrage);
                                while($tupel = mysqli_fetch_assoc($emailAdressen)){
                                $email = $tupel["emailAdresse"];
                                }
                                $kundendatenAbfrage = "SELECT kundeID, vorname, nachname, strasse, hausNr, ort, emailAdresse FROM kunden WHERE kundeID=" . $_SESSION['kundenid'] . ";";
                                $kundendaten = mysqli_query($con,$kundendatenAbfrage);
                                while($tupel = mysqli_fetch_assoc($kundendaten)){
                                   $kunde = $tupel;
                                } 
                                mysqli_close($con);
                            } catch (mysqli_sql_exception $e) {
                                if ($e->getCode() == 1062) {
                                    echo "<p>Es wurde bereits ein Ruecknahmeprotokoll fuer die angegegebene Mietvertragsnummer erstellt.</p>";
                                } else {
                                    throw $e;
                                }
                            }                            
                            createRuecknahme_pdf($kunde,$nutzungsdaten,$mietvertragsid);
                            header("Location: ../return/return_dialog.php");                        
                        }
                        else
                        {
                            echo "<p>Die eingegebene ID existiert nicht in der DB oder es wurde bereits ein Ruecknahmeprotokoll erzeugt, bitte geben Sie eine korrekte ein und geben Sie dann erneut die nutzungsrelevanten Daten ein.</p>";
                        }
                    }
                }                       
            }              
        }
    }

    function createRuecknahme_pdf($kundendaten, $nutzungsdaten,$mietvertragsid) {
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
    
        $pdf->AddPage();
    
        $style = <<<EOF
            <style>
                * {
                    line-height: 100%;
                    font-family: Monospace;
                }
            </style>
            EOF;
    
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
    
        $invoices_data = 
            $style.'
            <b>Ruecknahmeprotokoll</b>
            <pre>
            Sehr geehrter Herr/Frau '.$kundendaten["nachname"].'
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
                    <th>'.$mietvertragsid.'</th>
                    <th>'.$nutzungsdaten['tank'].'</th>
                    <th>'.$nutzungsdaten['sauberkeit'].'</th>
                    <th>'.$nutzungsdaten['mechanik'].'</th>
                    <th>'.$nutzungsdaten['kilometerstand'].'</th>
                </tr>                  
            </table>
            <br>
            <hr>';
    
    
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
        ob_end_clean();
        $pdfString = $pdf->Output('rechnung'.$kundendaten["kundeID"]."_".date('Y-m-d').'.pdf', 'S');
        
        $subject = 'Ruecknahmeprotokoll';
        $message = '<!DOCTYPE html>
        <html>
        <body>
        <p>Sehr geehrter Kunde,</p>
        <p>anbei erhaelst du dein Ruecknahmeprotokoll. ;)</p>
        <br>
        <p>Mit lieben Gruessen</p>
        <p>Dein Pascal</p>
        </body>
        </html>';

        send_mail($kundendaten['emailAdresse'],$subject,$message,$pdfString, 'ruecknahmeprotokoll'.date('Y-m-d').'.pdf');
    }
    
    function pdf_area_separation($pdf_file, $separation_lines) {
        for ($i=0; $i<$separation_lines; $i++) {
            $pdf_file->Ln();
        }
    }
    
?>
