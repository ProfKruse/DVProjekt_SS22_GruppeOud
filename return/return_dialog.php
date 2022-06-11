<!DOCTYPE html> 
    <?php
        //require fuer die Datenbankverbindung
        require("../database/db_inc.php");
        //require fuer die Funkionsaufrufe
        require("../functions/functions.php");
        //Session start, zum setzen von Objekten
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
                //mietvertragsAnzeige soll nur aufgerufen werden, wenn die Mietvertragsnummer eingegeben wurde
                if(isset($_POST['mietvertragid']))
                {
                    //speichern der Mietvertragsnummer
                    $_SESSION['mietvertragid'] = $_POST['mietvertragid'];
                    //Warnung, dass es bereits ein Ruecknahmeprotokoll für die Mietvertragsnummer gibt
                    if(checkIfIdProtocoleExist()){
                        echo "<p>Es wurde bereits ein Ruecknahmeprotokoll fuer die Mietvertragsnummer ". $_SESSION['mietvertragid'] ." erstellt.</p>"; 
                    }
                    //Funktionsaufruf der mietvertragsAnzeige mit den Formulardaten und der Datenbankverbindung
                    mietvertragsAnzeige($_POST,$con);
                }
            ?>
            <!--Formular zur Abfrage KFZ-relevanter Nutzungsdaten-->
            <form action="return_dialog.php" method="POST"> 
                <div class="group">                   
                    <label for="tank"><b>*Tank in Prozent</b></label> 
                    <input type="number" name="tank" min="0" max="100" required> 

                    <label for="kilometerstand"><b>*Kilometerstand</b></label> 
                    <input type="number" name="kilometerstand" min="0" max="100000000"required> 

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
                <?php
                    //sendeRuecknahmeprotokoll soll nur aufgerufen werden, wenn $_SESSION['mietvertragid'] gesetzt ist und noch kein Mietvertrag erzeugt wurde.
                    if(isset($_SESSION['mietvertragid']) and !checkIfIdProtocoleExist())
                    {
                            sendeRuecknahmeprotokoll($_POST,$con,$_SESSION['mietvertragid']);
                            echo "<button type='submit'>Protokoll erzeugen</button></div>";
                    }
                    else{
                         echo "<div><span>Bitte fragen Sie eine Mietvertragsnummer ab</span></div>"; 
                    }
                ?>  
                <!-- Erklaerung zur Verwendung der Seite und Hinweis wenn nur das untere Formular ausgefuellt und abgesendet werden soll, ohne vorherige Abfrage der Mietvertragsnummer-->
            
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