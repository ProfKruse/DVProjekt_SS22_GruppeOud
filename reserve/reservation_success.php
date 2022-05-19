<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_reservationProcessing.css">
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
            <h1>Reservierung erfolgreich</h1>
            <center>
                <div id="successFrame" class="frame">
                    <h1>Reservierung erfolgreich</h1>
                    <?php
                        session_start();
                        echo "<h1>KFZ des Typs ". $_SESSION['kfztyp'] ." kann in der Abholstation ". $_SESSION['abholstation']. "</h1>".
                                "<h2>erfolgreich reserviert werden.</h2>";
                    ?>
                </div>

                <button type="button" onclick="window.location='reservation_check.php'">Daten prüfen</button>
            </center>
            
        </main>
        <!--Sonstige Links-->
        <aside>

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>