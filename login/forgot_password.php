<?php
session_start();
include("../database/db_inc.php");
include("../functions/functions.php");



$email = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Check if employee or custumer
    if(isset($_POST['bedingung'])){
        $_SESSION['table'] = 'mitarbeiter';
    }
    else{
        $_SESSION['table'] = 'kunden';
    }
    $email = $_POST['emailAdresse'];

    $query_email = "select * from ".$_SESSION['table']  ." where emailAdresse = '$email' limit 1 ";
    $result_email = mysqli_query($con, $query_email);
 
    if (mysqli_num_rows($result_email) == 0) {
        $error = " Die Email Adresse $email existiert nicht in unsere Datenbank!";
    } else {
        $user_data = mysqli_fetch_assoc($result_email);
        $recipient = $email;
        $subject = 'Passwort zuruecksetzen';
        $password_token = $user_data['token'];
        $message = '<!DOCTYPE html>
        <html>
        <body>
        <a href="localhost/rentalCar/login/reset_password.php?password_token='.$password_token.'&emailAdresse='.$email.'&table='.$_SESSION['table'].'" > Reset Your Password!</a> 
        
        </body>
        </html>';
    
        send_mail($recipient, $subject, $message);
        header("Location: ../Mailer/email_success_reset_password.php");
        die;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/styles/register.css">
    <title>Password vergessen</title>
</head>
<!--Header-->
<header>

    <nav>
        <ul>
            <b>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../reserve/reservation.php">Reservieren</a></li>
                <li><a href="">Reservierungen</a></li>
                <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                <li><a href="../login/login.php">Anmeldung</a></li>
            </b>
        </ul>
    </nav>
</header>

<body>

    <body>
        <main>
            <h1>Passwort vergessen ?</h1>
            <center>
                <?php if (isset($error)) : ?>
                    <span class="form_font_error"><?php echo $error; ?></span>
                <?php endif ?>
                <div class="frame">
                    <form method="POST">
                        <label for="bedingung" id="checkbox">
                            <input type="checkbox" name="bedingung"><b>Mitarbeier</b>
                        </label>
                        <br>
                        <label for="email">*E-Mail</label>
                        <div <?php if (isset($error)) : ?> class="form_frame_error" <?php endif ?>>
                            <input type="email" name="emailAdresse" placeholder="E-Mail" required value="<?php echo $email; ?>">
                        </div>
                        <button type="submit">Weiter</button>
                    </form>
                </div>
            </center>
        </main>
    </body>

</html>