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
                <form action="reservation_processing.php" method="POST">
                <div class="group">
                    <?php
                        if(!isset($_SESSION)) { session_start(); } 
                        require_once("../Database/db_inc.php");
                        
                        $options = "";
                        $arr = databaseSelectQuery("kfzTypID","kfztypen", "");

                        foreach($arr as $id) {
                            $bezeichnung = databaseSelectQuery("typBezeichnung","kfztypen","WHERE kfzTypID=".$id);
                            $options .= "<option value='".$id."'>".$bezeichnung[0]."</option>";    
                        }   

                        $stationen = "<label for='kfztyp'><b>*Kfz-Typ</b></label>"."<select name='kfztyp'>".$options."</select>";
                        echo $stationen;
                    ?>

                    <label for="message"><b>Message</b></label>
                    <input type="text" name="message" placeholder="Message">

                </div>

                <div class="group">
                    <?php
                        require_once("../Database/db_inc.php");

                        $options_abholen = "";
                        $options_abgabe = "";
                        $abholstation = databaseSelectQuery("mietstationID","mietstationen", "WHERE mietstationTyp='Abholstation'");
                        $abgabestation = databaseSelectQuery("mietstationID","mietstationen", "WHERE mietstationTyp='Abgabestation'");

                        foreach($abholstation as $id) {
                            $bezeichnung = databaseSelectQuery("beschreibung","mietstationen","WHERE mietstationID=".$id);
                            $options_abholen .= "<option value='".$id."'>".$bezeichnung[0]."</option>";
                        }

                        foreach($abgabestation as $id) {
                            $bezeichnung = databaseSelectQuery("beschreibung","mietstationen","WHERE mietstationID=".$id);
                            $options_abgabe .= "<option value='".$id."'>".$bezeichnung[0]."</option>";
                        }

                        $stationen = "<label for='abholstation'><b>*Abholstation</b></label>"."<select name='abholstation'>".$options_abholen."</select>".
                        "<label for='abgabestation'><b>*Abgabestation</b></label>"."<select name='abgabestation'>".$options_abgabe."</select>";
                        echo $stationen;
                    ?>
                </div>
                <br><br>
                <div class="buttons" style="width: 50px">
                    <button type="button" onclick="window.location='..\\index.php'">Reservierung abbrechen</button>
                    <button type="submit">Eingaben prüfen</button>
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