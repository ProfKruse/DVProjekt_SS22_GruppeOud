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
                        <li><a href="">Reservieren</a></li>
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="">Rechnungen</a></li>
                        <li><a href="">Konto</a></li>
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
                        if(!isset($_SESSION)) { session_start(); } 
                        echo "<h2>KFZ des Typs ". $_SESSION['kfztyp'] ." <br> kann in der Abholstation ". $_SESSION['abholstation'].
                                "<br>reserviert werden.</h2>";
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