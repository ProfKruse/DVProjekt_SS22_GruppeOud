<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_checkReservation.css">
        <title>Fahrzeug Verfügbarkeit prüfen</title>
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
            <h1>Fahrzeug Verfügbarkeit prüfen</h1>
            <center>
            <div class="frame">
                <form action="" method="POST">
                <!-------------------------------------------------------------->
                    <div class="group">
                        <label for="Marke"><b>Welche Marke suchen sie?</b></label>
                        <input type="text" name="Marke" placeholder="xxx" required>

                        <label for="Modell"><b>Welches Modell suchen sie?</b></label>
                        <input type="text" name="Modell" placeholder="xxx" required>

                        <button type="submit">Anfrage senden</button>

                        <label for="message"><b>Verfügbarkeit</b></label>
                    <input type="text" name="message" placeholder="Message" readonly>

                    </div>

                

                  

                <!-------------------------------------------------------------->
 
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