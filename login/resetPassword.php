<?php
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

    $email = "";
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_POST['emailAdresse'];

        $query_email = "select * from kunden where emailAdresse = '$email' limit 1 ";
        $result_email = mysqli_query($con,$query_email);

        if (mysqli_num_rows($result_email) == 0) {
            $error = " Die Email Adresse $email existiert nicht in unsere Datenbank!";
        } else{
            $recipient = $email ; 
            $subject = 'Passwort zuruecksetzen';
            $message = 'test';

            send_mail($recipient,$subject, $message);
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
                            <li><a href="">Reservieren</a></li>
                            <li><a href="">Reservierungen</a></li>
                            <li><a href="">Rechnungen</a></li>
                            <li><a href="login.php">Anmeldung</a></li>
                        </b>
                    </ul>
                </nav>
            </header>
        <body>
    <body>
        <main>
            <h1>Passwort vergessen ?</h1>
            <center>
                <?php if (isset($error)): ?>
                    <span class = "form_font_error"><?php echo $error; ?></span>
                <?php endif ?>
                <div class="frame">
                    <form method="POST">
                        <label for="email">*E-Mail</label>
                        <div <?php if (isset($error)): ?> class="form_frame_error" <?php endif ?> >
                            <input type="email" name="emailAdresse" placeholder="E-Mail" required value="<?php echo $email; ?>" >
                         </div>
                        <button type="submit">Weiter</button>
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>