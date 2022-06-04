<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require '../library/PHPMailer/src/Exception.php';
    /* PHPMailer-Klasse */
    require '../library/PHPMailer/src/PHPMailer.php';
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require '../library/PHPMailer/src/SMTP.php';
    
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
    }
    header("Location: ../login/login.php");
    die;
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
            $mail->addAttachment($stringAttachment, $nameAttachment);
        }
        
        $mail->send();
    } 
    catch(Exception $e) {
        echo 'Email wurde nicht gesendet';
        echo 'Mailer Error: '.$mail->ErrorInfo;
    }
}
?>