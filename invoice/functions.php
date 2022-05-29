<?php
    /* Klasse zur Behandlung von Ausnahmen und Fehlern */
    require_once('..\..\..\php\PHPMailer\src\Exception.php');
    /* PHPMailer-Klasse */
    require_once('..\..\..\php\PHPMailer\src\PHPMailer.php');
    /* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
    require_once('..\..\..\php\PHPMailer\src\SMTP.php');
    
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
        
        $mail->Username='sihem.ouldmohand@yahoo.com';
        $mail->Password='fytbevyafkbqzien';
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
        
        if($pathAttachment != Null and $nameAttachment !=null){
            $mail->addAttachment($pathAttachment, $nameAttachment);
        }
        
        $mail->send();


    } 
    catch(Exception $e) {
        echo 'Email wurde nicht gesendet';
        echo 'Mailer Error: '.$mail->ErrorInfo;
    }
}
?>