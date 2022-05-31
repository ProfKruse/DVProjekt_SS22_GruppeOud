<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_checkReservation.css">
        <title>KFZ spezifische Daten eintragen</title>
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
            <h1>KFZ spezifische Daten eintragen</h1>
            <center>
            <div class="frame">
                <form action="create_pdf.php" method="POST">
                <!-------------------------------------------------------------->
                    <div class="group">
                        <label for="marke"><b>Marke</b></label>
                        <input type="text" name="marke" id="marke" placeholder="xxx" required>

                        <label for="standardRate"><b>Standard Rate</b></label>
                        <input type="text" name="standardRate" id="standardRate" placeholder="xxx" required>

                        <label for="kilometerstand"><b>Kilometerstand</b></label>
                        <input type="text" name="kilometerstand" id="kilometerstand" placeholder="xxx" required>

                        <label for="ausstattung"><b>Ausstattung</b></label>
                        <input type="text" name="ausstattung" id="ausstattung" placeholder="xxx" required>
                    </div>

                <!-------------------------------------------------------------->

                    <div class="group">
                        <label for="modell"><b>Modell</b></label>
                        <input type="text" name="modell" id="modell" placeholder="xxx" required>
                    
                        <label for="zustand"><b>Zustand</b></label>
                        <input type="text" name="zustand" id="zustand" placeholder="xxx" required>

                        
                        <label for="kennzeichen"><b>Kennzeichen</b></label>
                        <input type="text" name="kennzeichen" id="kennzeichen" placeholder="xxx" required>
                    </div>

                <!-------------------------------------------------------------->
                <div>
                <button type="submit">PDF erstellen</button>
                </div>
            </form>
            </div>
            </center>
            <br>
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