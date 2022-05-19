
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/* Klasse zur Behandlung von Ausnahmen und Fehlern */
require '/Applications/XAMPP/xamppfiles/php/PHPMailer/src/Exception.php';

/* PHPMailer-Klasse */
require '/Applications/XAMPP/xamppfiles/php/PHPMailer/src/PHPMailer.php';

/* SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen */
require '/Applications/XAMPP/xamppfiles/php/PHPMailer/src/SMTP.php';

$email = new PHPMailer(TRUE);

try {
    // Versuch, eine neue Instanz der Klasse PHPMailer zu erstellen
    $mail = new PHPMailer (true);
// (…)
} catch (Exception $e) {
        echo "Mailer Error: ".$mail->ErrorInfo;
}

$mail->isSMTP();
$mail->SMTPAuth = true;

// Persönliche Angaben
$mail->Host = "smtp.domain.de";
$mail->Port = "587";
$mail->Username = "name.nachname@domain.de";
$mail->Password = "probepasswort4321";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

// Absender
$mail->setFrom('info@example.com', 'name');
// Empfänger, optional kann der Name mit angegeben werden
$mail->addAddress('info@example.com', 'name');
// Kopie
$mail->addCC('info@example.com');
// Blindkopie
$mail->addBCC('info@example.com', 'name');


$mail->isHTML(true);
// Betreff
$mail->Subject = 'Der Betreff Ihrer Mail';
// HTML-Inhalt
$mail->Body = 'Der Text Ihrer Mail als HTML-Inhalt. Auch <b>fettgedruckte</b> Elemente sind beispielsweise erlaubt.';
$mail->AltBody = 'Der Text als simples Textelement';

// Anhang hinzufügen
$mail->addAttachment("/home/user/Desktop/beispielbild.png", "beispielbild.png");

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

$mail->send();

?>