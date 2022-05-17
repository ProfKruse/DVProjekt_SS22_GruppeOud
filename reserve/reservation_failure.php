<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_reservationFailure.css">
        <title>Reservierung fehlgeschlagen</title>
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
            <h1>Reservierung fehlgeschlagen</h1>
            <center>
                <div class="frame">
                    <?php
                        echo "<h1>Es steht leider kein KFZ des Typs". $_POST['kfztyp'] ." in der Abholstation ". $_POST['abholstation']. "</h1>";
                    ?>
                    <h2>zur Verfügung. Stattdessen Kfz 789 reservieren?</h2>
                    <br>
                </div>

                <div id="buttons">
                    <button type="button">Ja</button>
                    <button type="button">Nein</button>
                </div>
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