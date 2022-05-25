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
                <form action="" method="POST">
                <!-------------------------------------------------------------->
                    <div class="group">
                        <label for="Marke"><b>Marke</b></label>
                        <input type="text" name="Marke" placeholder="xxx" required>

                        <label for="StandardRate"><b>Standard Rate</b></label>
                        <input type="text" name="StandardRate" placeholder="xxx" required>

                        <label for="Kilometerstand"><b>Kilometerstand</b></label>
                        <input type="text" name="Kilometerstand" placeholder="xxx" required>

                        <label for="Ausstattung"><b>Ausstattung</b></label>
                        <input type="text" name="Ausstattung" placeholder="xxx" required>
                    </div>

                <!-------------------------------------------------------------->

                    <div class="group">
                        <label for="Modell"><b>Modell</b></label>
                        <input type="text" name="Modell" placeholder="xxx" required>
                    
                        <label for="Zustand"><b>Zustand</b></label>
                        <input type="text" name="Zustand" placeholder="xxx" required>

                        
                        <label for="Kennzeichen"><b>Kennzeichen</b></label>
                        <input type="text" name="Kennzeichen" placeholder="xxx" required>
                    </div>

                <!-------------------------------------------------------------->

                
                
                  

                    
                </form>
                <button type="submit">Send</button>
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