<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require 'PHPMailer-Master/src/Exception.php';
    /* PHPMailer-Klasse */
    require 'PHPMailer-Master/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require 'PHPMailer-Master/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function send_mail($recipient,$subject, $message,$pdfAttachment=null,$nameAttachment=null){
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
            
            if($pdfAttachment != Null and $nameAttachment !=null){
                $mail->AddStringAttachment($pdfAttachment, $nameAttachment,'base64');
            }
            
            $mail->send();
    
    
        } 
        catch(Exception $e) {
            echo 'Email wurde nicht gesendet';
            echo 'Mailer Error: '.$mail->ErrorInfo;
        }
    }
?>
