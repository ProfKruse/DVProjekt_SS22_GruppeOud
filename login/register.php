<?php
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $vorname = $_POST['vorname']; 
        $nachname = $_POST['nachname']; 
        $pseudo = $_POST['pseudo'];
        $emailAdresse = $_POST['emailAdresse']; 
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $strasse = $_POST['strasse'];  
        $hausNr = $_POST['hausNr']; 
        $plz = $_POST['plz']; 
        $ort = $_POST['ort']; 
        $land = $_POST['land'];
        $iban = $_POST['iban'];
        $bic = $_POST['bic'] ; 
        $telefonNr = $_POST['telefonNr']; 

        if(!empty($pseudo) && !empty($password)){
            
            $stmt = "insert into kunden (vorname, nachname, pseudo, password, strasse, hausNr, plz,ort, land, iban, bic, telefonNr, emailAdresse) 
            values ('$vorname','$nachname', '$pseudo','$hash','$strasse','$hausNr',$plz,'$ort','$land','$iban','$bic','$telefonNr','$emailAdresse')";

            mysqli_query($con,$stmt);
            header("Location: login.php");
            die;
        }else{
            echo "please enter some valide information!";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/register.css">
        <title>Registrierung</title>
    </head>
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
    <body>
        <main>
            <h1>Registrierung</h1>
            <center>
                <div class="frame">
                    <form method="POST">
                        <div class="group">
                            <label for="vorname">*Vorname</label>
                            <input type="text" name="vorname" placeholder="Vorname" required>
                           
                            <label for="nachname">*Nachname</label>
                            <input type="text" name="nachname" placeholder="Nachname" required>

                            <label for="pseudo">*Pseudo</label>
                            <input type="text" name="pseudo" placeholder="pseudo" required>

                            <label for="email">*E-Mail</label>
                            <input type="text" name="emailAdresse" placeholder="E-Mail" required>

                            <label for="password">*Password</label>
                            <input type="text" name="password" placeholder="Password" required>
                            
                            <label for="strasse">*Straße</label>
                            <input type="text" name="strasse" placeholder="Straße" required>

                            <label for="hausnr">*Haus-Nr</label>
                            <input type="number" name="hausNr" placeholder="Haus Nr." required>

                            </div>
                       
                            <div class="group">

                            <label for="plz">*PLZ</label>
                            <input type="number" name="plz" placeholder="Postleitzahl" required>

                            <label for="ort">*Ort</label>
                            <input type="text" name="ort" placeholder="ort" required>

                            <label for="land">*Land</label>
                            <input type="text" name="land" placeholder="Land" required>

                            <label for="iban">*IBAN</label>
                            <input type="text" name="iban" placeholder="IBAN" required>

                            <label for="bic">*BIC</label>
                            <input type="text" name="bic" placeholder="BIC" required>
  
                            <label for="telefonnr">*Telefonnummer</label>
                            <input type="text" name="telefonNr" placeholder="Telefonnummer" required>

                        </div>

                        <br>
                        <button type="submit">Regestrieren</button>
                        <a href="login.php">Ich habe schon einen Konto</a>
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>