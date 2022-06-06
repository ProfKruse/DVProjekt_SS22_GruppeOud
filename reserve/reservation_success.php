<?php   
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");
    $user_data = check_login($con);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Reservierung erfolgreich</title>
    </head>
    <body>
        <!--Header-->
        <header>
            <nav>
                <ul>
                    <b>
                    <li><a href="../index.php">Home</a></li>
                        <li><a href="reservation.php">Reservieren</a></li>
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
            <center>
                <div id="successFrame" class="frame" style="width: 500px">
                    <h1 id="erfolgsmeldung">Prüfung erfolgreich</h1>
                    <?php
                        echo "<h2>KFZ des Typs ".$_SESSION ['kfzTypBezeichnung'] ." <br> kann in der Abholstation ". $_SESSION ['abholstationBezeichnung']."<br>reserviert werden.</h2>";
                    ?>
                </div>

                <div class="buttons" style="width: 150px;">
                    <button type="button" onclick="history.back()">Zurück</button>
                    <button type="button" onclick="window.location='reservation_check.php'">Daten prüfen</button>
                </div>
            </center>
            
        </main>

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>