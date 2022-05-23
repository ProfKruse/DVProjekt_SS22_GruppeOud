<?php
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_POST['emailAdresse'];

        if(!empty($email)){

            $recipient = 'sihem.ouldmohand@yahoo.com'; 
            $subject = 'Hallo';
            $message = '<b>Pascaaaaal, ich habe doch gesagt, dass E-Mail aus xampp senden, easy war ;) </b>';
            $pathAttachment = '../src/images/background.png';
            $nameAttachment = 'image.png';

            send_mail($recipient,$subject, $message,$pathAttachment,$nameAttachment);

        }else{
            echo "Email wurde nicht gesendet!";
        }
    }



?>

<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Password vergessen</title>
    </head>

    <body>
        <main>
            <h1>Passwort vergessen ?</h1>
            <center>
                <div class="frame">
                    <form method="POST">
                        <label for="email">*E-Mail</label>
                        <input type="text" name="emailAdresse" placeholder="E-Mail" required>

                        <button>Weiter</button>
       
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>