<?php
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

    $vorname = ""; 
    $nachname = ""; 
    $pseudo = "";
    $emailAdresse = ""; 
    $strasse = ""; 
    $hausNr = ""; 
    $plz = ""; 
    $ort = ""; 
    $land = ""; 
    $iban = ""; 
    $bic = ""; 
    $telefonNr = ""; 

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
    
        $query_pseudo = "select * from kunden where pseudo = '$pseudo' limit 1 ";
        $query_email = "select * from kunden where emailAdresse = '$emailAdresse' limit 1 ";

        $result_pseudo = mysqli_query($con,$query_pseudo);
        $result_email = mysqli_query($con,$query_email);

        if ( (mysqli_num_rows($result_pseudo) > 0) && (mysqli_num_rows($result_email) > 0)) {
            $error = " Die Email Adresse $emailAdresse und das Pseudo $pseudo  existieren schon!";
        } 
        else if(mysqli_num_rows($result_pseudo) > 0){
            $name_error = " Das Pseudo $pseudo existiert schon!";
        } 
        else if (mysqli_num_rows($result_email) > 0) {
            $email_error = " Die Email Adresse $emailAdresse existiert schon!";
        } 

        else {
            $stmt = "insert into kunden (vorname, nachname, pseudo, password, strasse, hausNr, plz,ort, land, iban, bic, telefonNr, emailAdresse) 
            values ('$vorname','$nachname', '$pseudo','$hash','$strasse','$hausNr',$plz,'$ort','$land','$iban','$bic','$telefonNr','$emailAdresse')";
    
            mysqli_query($con,$stmt);
            header("Location: login.php");
            die;
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
                        <li><a href="login.php">Anmeldung</a></li>
                    </b>
                </ul>
            </nav>
        </header>
    <body>
        <main>
            <h1>Registrierung</h1>

            <center>
                <?php if (isset($error)): ?>
                    <span class = "form_font_error"><?php echo $error; ?></span>
                <?php endif ?>
                <?php if (isset($email_error)): ?>
                    <span class = "form_font_error"><?php echo $email_error; ?></span>
                <?php endif ?>
                <?php if (isset($name_error)): ?>
                    <span class = "form_font_error"><?php echo $name_error; ?></span>
                <?php endif ?>

                <div class="frame">
                    <form method="POST" action="register.php" id="register_form">
                        <div class="group">
                            <label for="vorname">*Vorname</label>
                            <input type="text" name="vorname" placeholder="Vorname" required value="<?php echo $vorname; ?>">
                           
                            <label for="nachname">*Nachname</label>
                            <input type="text" name="nachname" placeholder="Nachname" required value="<?php echo $nachname; ?>">

                            <label for="pseudo">*Pseudo</label>
                            <div <?php if (isset($error) or isset($name_error)): ?> class="form_frame_error" <?php endif ?> >
                                <input type="text" name="pseudo" placeholder="pseudo" required value="<?php echo $pseudo; ?>" >

                            </div>

                            <label for="email">*E-Mail</label>
                            <div <?php if (isset($error) or isset($email_error)): ?> class="form_frame_error" <?php endif ?> >
                                <input type="email" name="emailAdresse" placeholder="E-Mail" required  value="<?php echo $emailAdresse; ?>" >

                            </div>

                            <label for="password">*Password</label>
                            <input type="password" name="password" placeholder="Password" required>
                            
                            <label for="strasse">*Straße</label>
                            <input type="text" name="strasse" placeholder="Straße" required value="<?php echo $strasse; ?>">

                            <label for="hausnr">*Haus-Nr</label>
                            <input type="text" name="hausNr" placeholder="Haus Nr." required value="<?php echo $hausNr; ?>">

                            </div>
                       
                            <div class="group">

                            <label for="plz">*PLZ</label>
                            <input type="number" name="plz" placeholder="Postleitzahl" required value="<?php echo $plz; ?>">

                            <label for="ort">*Ort</label>
                            <input type="text" name="ort" placeholder="ort" required value="<?php echo $ort; ?>">

                            <label for="land">*Land</label>
                            <input type="text" name="land" placeholder="Land" required value="<?php echo $land; ?>">

                            <label for="iban">*IBAN</label>
                            <input type="text" name="iban" placeholder="IBAN" required value="<?php echo $iban; ?>">

                            <label for="bic">*BIC</label>
                            <input type="text" name="bic" placeholder="BIC" required value="<?php echo $bic; ?>">
  
                            <label for="telefonnr">*Telefonnummer</label>
                            <input type="text" name="telefonNr" placeholder="Telefonnummer" required value="<?php echo $telefonNr; ?>">

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