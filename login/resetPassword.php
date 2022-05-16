<?php
session_start();
    include("db_inc.php");
    include("functions.php");
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
                        <input type="text" name="email" placeholder="E-Mail" required>

                        <button type="submit">Weiter</button>
       
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>