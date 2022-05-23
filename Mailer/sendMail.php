<?php
/* Klasse zur Behandlung von Ausnahmen und Fehlern */
require '../../../php/PHPMailer/src/Exception.php';

/* PHPMailer-Klasse */
require '../../../php/PHPMailer/src/PHPMailer.php';

/* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
require '../../../php/PHPMailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$mail=new PHPMailer(); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug  = SMTP::DEBUG_OFF;
    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host='smtp.mail.yahoo.com';
    
    $mail->Username='sihem.ouldmohand@yahoo.com'; // SMTP username
    $mail->Password='fytbevyafkbqzien'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = 'ssl';
    $mail->Port=465;

    $mail->SMTPAuth = true;

    $mail->setFrom('sihem.ouldmohand@yahoo.com', 'Sihem yahoo');

    //recipient
    $mail->addAddress('sihem.ouldmohand@yahoo.com', 'Sihem yahoo');     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Unser erste E-Mail senden Gamma test';
    $mail->Body='<b>Pascaaaaal, ich habe doch gesagt, dass E-Mail aus xampp senden, easy war ;) </b>';
    $mail->AltBody='Das ist nur um den OldBody zu testen';
    $mail->addAttachment("../src/images/background.png", "background.png");
    //$mail->send();
    header("Location: email_success.php");
    die;
} 
catch(Exception $e) {
    echo 'Email wurde nicht gesendet';
    echo 'Mailer Error: '.$mail->ErrorInfo;
}