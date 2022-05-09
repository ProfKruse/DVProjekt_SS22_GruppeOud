<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/reservation.css">
        <title>Reservierung</title>
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
            <h1>Reservierung</h1>
            <center>
            <div class="frame">
                <form action="" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="kfztyp"><b>*Kfz-Typ</b></label>
                    <select name="kfztyp">
                        <option value="">Typ 1</option>
                        <option value="">Typ 2</option>
                        <option value="">Typ 3</option>
                    </select>

                    <label for="abgabestation"><b>*Abgabestation</b></label>
                    <input type="text" name="abgabestation" placeholder="Abgabestation" required>
                </div>

                <!-------------------------------------------------------------->

                <div class="group">
                    <label for="abholstation"><b>*Abholstation</b></label>
                    <input type="text" name="abholstation" placeholder="Abholstation" required>

                    <label for="message"><b>Message</b></label>
                    <input type="text" name="message" placeholder="Message">
                </div>
                <br>
                
                <br>
                <label for="checkbox1" id="checkbox">
                    <input type="checkbox" name="checkbox1"><b>Checkbox Text</b>
                </label>
                <br>

                <button type="submit">Send</button>
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