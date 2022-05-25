<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/reservation.css">
        <title>Reservierungsdaten anzeigen</title>
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
            <h1>Reservierungsdaten anzeigen</h1>
            <center>
            <div class="frame">
                <form action="" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="vorname"><b>Vorname</b></label>
                    <input type="text" name="vorname" placeholder="Vorname" readonly>

                    <label for="kfz-typ"><b>Kfz-Typ</b></label>
                    <input type="text" name="kfz-typ" placeholder="Kfz-Typ" readonly>
                </div>

                <!-------------------------------------------------------------->

                <div class="group">
                    <label for="nachname"><b>Nachname</b></label>
                    <input type="text" name="nachname" placeholder="Nachname" readonly>

                    <label for="status"><b>Status</b></label>
                    <input type="text" name="status" placeholder="Status" readonly>
                </div>
                <br>

                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="abholstation"><b>Abholstation</b></label>
                    <input type="text" name="abholstation" placeholder="Abholstation" readonly>

                </div>

                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="datum"><b>Datum</b></label>
                    <input type="text" name="datum" placeholder="Datum" readonly>

                </div>

                <br>
                <div class="group">
                    <label for="reservierungsnummer"><b>Reservierungsnummer eingeben:</b></label>
                    <input type="text" name="reservierungsnummer" placeholder="Reservierungsnummer" readonly>

                </div>
                <br>

                <button type="submit">Anzeigen</button>
            </form>
        </div>
</center>
            
        </main>
        <!--Sonstige Links-->

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>