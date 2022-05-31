<!DOCTYPE html> 
    <?php
        require("../Database/db_inc.php");
        require("../functions/functions.php");
        session_start();        
    ?> 
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
            <form action="return_dialog.php" method="POST"> 
                <!--------------------------------------------------------------> 
                <div class="group"> 
                    <label for="mietvertragsnummer"><b>*Mietvertragsnummer</b></label> 
                    <input type="number" name="mietvertragid" id="mietvertragid" max="99999999999" min="1"  required > 
                </div> 
                 
                <div class="group"> 
                    <label for="abfragen"><b>Daten abfragen</b></label>  
                    <button type="submit" >Abfragen</button> 
                </div> 
            </form> 
            <?php 
                mietvertragsAnzeige($_POST,$con);
                if(isset($_POST['mietvertragid']))
                    $_SESSION['mietvertragid'] = $_POST['mietvertragid'];
            ?> 
            <form action="return_dialog.php" method="POST"> 
                <div class="group">                   
                    <label for="tank"><b>*Tank</b></label> 
                    <input type="number" name="tank" min="0" max="100" required> 

                    <label for="kilometerstand"><b>*Kilometerstand</b></label> 
                    <input type="number" name="kilometerstand" min="0" required> 

                    <label for="sauberkeit"><b>*Sauberkeit</b></label> 
                    <select name="sauberkeit" id="sauberkeit" required> 
                        <option value="sehr sauber">Sehr Sauber</option> 
                        <option value="sauber">Sauber</option> 
                        <option value="neutral">Neutral</option> 
                        <option value="leicht schmutzig">Leicht schmutzig</option> 
                        <option value="sehr schmutzig">Sehr schmutzig</option> 
                    </select> 

                    <label for="mechanik"><b>*Mechanikstatus</b></label> 
                    <input type="text" name="mechanik" maxlength="1000" required> 
                </div> 
                <br>
                <button type="submit">Protokoll erzeugen</button></div>
                <?php
                    sendeRuecknahmeprotokoll($_POST,$con,$_SESSION['mietvertragid']);
                    #session_destroy(); 
                ?>  
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