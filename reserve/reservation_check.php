<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_checkReservation.css">
        <title>Reservierungsüberprüfung</title>
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
            <h1>Überprüfung</h1>
            <center>
            <div class="frame">
                <?php session_start() ?>
                <form action="reservation_confirmation.php" method="POST">
                <!-------------------------------------------------------------->
                    <div class="group">
                        <label for="vorname"><b>*Vorname</b></label>
                        <input type="text" name="vorname" value="<?php echo $_SESSION['vorname'] ?>" required>

                        <label for="nachname"><b>*Nachname</b></label>
                        <input type="text" name="nachname" value="<?php echo $_SESSION['nachname'] ?>" required>

                        <label for="telefonnr"><b>*Telefonnr.</b></label>
                        <input type="text" name="telefonnr" value="<?php echo $_SESSION['telefonnr'] ?>" required>
                    </div>

                <!-------------------------------------------------------------->

                    <div class="group">
                        <label for="kfztyp"><b>*KFZ-Typ</b></label>
                        <input type="text" name="kfztyp" value="<?php echo $_SESSION['kfztyp'] ?>" readonly required>
                    
                        <label for="abholstation"><b>*Abholstation</b></label>
                        <input type="text" name="abholstation" value="<?php echo $_SESSION['abholstation'] ?>" readonly required>     
                        
                        <label for="email"><b>*Email-Adresse</b></label>
                        <input type="text" name="email" value="<?php echo $_SESSION['email'] ?>" required>
                    </div>
                    
                <!-------------------------------------------------------------->

                    <br>
                    <div class="group">
                        <label for="message"><b>Message</b></label>
                        <textarea name="message"><?php echo $_SESSION['message'] ?></textarea>
                    </div>
                    <br>
                
                    <br>
                    <label for="bedingung" id="checkbox">
                        <input type="checkbox" name="bedingung"><b>Die Daten sind korrekt</b>
                    </label>
                    <br>

                    <b class="invisible" id="fehlermeldung">Bitte bestätigen sie die Korrektheit der Daten</b><br><br>
                    <div class="buttons" style="width: 50px">
                        <button type="button" onclick="if(window.confirm('Möchten sie die Reservierung wirklich abbrechen?')){window.location='..\\index.php'}">Abbrechen</button>
                        <button type="button" onclick="if(form.bedingung.checked){form.submit()}else{document.getElementById('fehlermeldung').classList.remove('invisible');}"">Reservieren</button>
                    </div>
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