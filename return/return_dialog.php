<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css">
        <title>KFZ Rücknahme</title>
    </head>
    <body style="background-image:url()">
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
            <h1>KFZ Rücknahme</h1>
            <center>
            <div class="frame">
            <form action="mietvertragIdentifizieren.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="textfield1"><b>*Mietvertragsnummer</b></label>
                    <input type="text" name="textfield1" placeholder="12345" maxlength=11 required >
                </div>
                
                <div class="group">
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="button">Abfragen</button>
                </div>
            </form>

            <br>
            <br>
            <br>
            <center>
                <table>
                    <thead>
                        <tr>
                            <th>Mietvertragsnummer</th>
                            <th>Miete-Anfang</th>
                            <th>Miete-Ende</th>
                            <th>Zahlart</th>
                            <th>Kosten</th>
                            <th>Ausgangszustand</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12345</td>
                            <td>01.01.2022</td>
                            <td>05.05.2022</td>
                            <td>...</td>
                            <td>500€</td>
                            <td>...</td>
                        </tr>
                    </tbody>
                </table>
            </center>

            <form action="" method="POST">
                <div class="group">
                    <label for="ruecknahmedatum"><b>*Rücknahmedatum</b></label>
                    <input type="date" name="ruecknahmedatum" required>

                    <label for="tank"><b>*Tank</b></label>
                    <input type="number" name="tank" required>
                </div>

                <div class="group">
                    <label for="kilometerstand"><b>*Kilometerstand</b></label>
                    <input type="number" name="kilometerstand" required>

                    <label for="sauberkeit"><b>*Sauberkeit</b></label>
                    <input type="text" name="sauberkeit" required>
                </div>
                
                <br>
                <button type="submit">Protokoll erzeugen</button></div>
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