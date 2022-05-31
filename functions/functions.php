<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require '../library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    require '../library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require '../library/PHPMailer/src/SMTP.php';

    require '../library/pdfcreator/fpdf.php';
    
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
    
    
    function send_mail($recipient,$subject, $message,$pathAttachment=null,$nameAttachment=null){
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
            
            if($pathAttachment != Null and $nameAttachment !=null){
                $mail->addStringAttachment($pathAttachment, $nameAttachment);
            }
            
            $mail->send();
    
    
        } 
        catch(Exception $e) {
            echo 'Email wurde nicht gesendet';
            echo 'Mailer Error: '.$mail->ErrorInfo;
        }
    }

    function mietvertragsAnzeige($mietvertragsdaten,$con){
        #session_start(); 
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
            } 
            if($count ==  0) 
            { 
                echo "<p>Die eingegebene ID existiert nicht in der DB</p>";
                $_SESSION['mietvertragID'] = null;
                $_SESSION['kundenid'] = null;
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
                            } catch (mysqli_sql_exception $e) {
                                if ($e->getCode() == 1062) {
                                    echo "<p>Es wurde bereits ein Ruecknahmeprotokoll fuer die angegegebene Mietvertragsnummer erstellt.</p>";
                                    // Duplicate user
                                } else {
                                    throw $e;// in case it's any other error
                                }
                            
                            } 
                            //$statement = "UPDATE kfzs SET kilometerStand = " . $kilometerstand "WHERE ;"; 
                            //$ergebnis = $con->query($statement);
                            
                            $ergebnis = mysqli_query($con, "SELECT emailAdresse FROM kunden WHERE kundeID=" . $_SESSION['kundenid']);
                            while($dsatz = mysqli_fetch_assoc($ergebnis)){
                                $email = $dsatz["emailAdresse"];
                            }                          
                            mysqli_close($con);
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
                            $pdf = new FPDF();
                            $pdf->AddPage();
                            $pdf->SetFont('Arial','B',16);
                            $pdf->Cell(0,10,'Ruecknahmeprotokoll:',0,1);
                            $pdf->SetFont('Arial','B',12);
                            $pdf->Cell(0,10,'Der Tank war noch zu: ' . $tank . '% gefuellt.',1,1);
                            $pdf->Cell(0,10,'Das Auto war ' . $sauberkeit . '.',1,1);
                            $pdf->Cell(0,10,'Die Mechanik war ' . $mechanik . '.',1,1);
                            $pdf->Cell(0,10,'Du bist ' . $kilometerstand . 'km gefahren.',1,1);
                            $pdf->Cell(0,10,'Deine Mietvertragsnummer ist: ' . $mietvertragsid . '.',1,1);
                            $doc = $pdf->Output('S');
                            send_mail($email, $subject, $message,$doc,"Ruecknahmeprotokoll.pdf");
                            die;                             
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
?>
