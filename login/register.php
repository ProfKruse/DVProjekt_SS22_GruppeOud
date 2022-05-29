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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $bic = $_POST['bic'];
    $telefonNr = $_POST['telefonNr'];

    $query_pseudo = "select * from kunden where pseudo = '$pseudo' limit 1 ";
    $query_email = "select * from kunden where emailAdresse = '$emailAdresse' limit 1 ";

    $result_pseudo = mysqli_query($con, $query_pseudo);
    $result_email = mysqli_query($con, $query_email);

    if ((mysqli_num_rows($result_pseudo) > 0) && (mysqli_num_rows($result_email) > 0)) {
        $error = " Die Email Adresse $emailAdresse und das Pseudo $pseudo existieren schon!";
    } else if (mysqli_num_rows($result_pseudo) > 0) {
        $name_error = " Das Pseudo $pseudo existiert schon!";
    } else if (mysqli_num_rows($result_email) > 0) {
        $email_error = " Die Email Adresse $emailAdresse existiert schon!";
    } else {
        $token = rand(10000, 99999);
        $stmt = "insert into kunden (vorname, nachname, pseudo, password, strasse, hausNr, plz,ort, land, iban, bic, telefonNr, emailAdresse,token) 
values ('$vorname','$nachname', '$pseudo','$hash','$strasse','$hausNr',$plz,'$ort','$land','$iban','$bic','$telefonNr','$emailAdresse','$token')";
        mysqli_query($con, $stmt);

        $recipient = $emailAdresse;
        $subject = 'E-Mail validieren';
        $message = "<!DOCTYPE html>

            <html>
            <head>
            <title></title>
            <meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
            <style>
                :root {
                --formInputHeight: 40px;
                --formInputWidth: 375px;
                }
            
                @font-face {
                    font-family: custom;
                    src: url(\"../fonts/Calibri Regular.ttf\");
                }
            
                * {
                    font-family: custom; 
                    color: #212568;
                }
            
                body {
                    background-repeat: no-repeat;
                    background-size: cover;
                }
            
                /* Footer */
            
                footer {
                    position: fixed;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    box-shadow: rgba(149, 157, 165, 0.2) 0px -8px 24px;
                    background-color: white;
                }
            
                footer b {
                    margin: 5px 250px 5px 250px;
                }
            
                /* Navigation Bar */
            
            
            
                /* Main Bereich */
            
                main h1,h2 {
                    text-align: center;
                }
                button {
                    height: var(--formInputHeight);
                    background-color: #567bf6;
                    color: white;
                    border: none;
                    border-radius: 45px;
                    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease 0s;
                    cursor: pointer;
                    outline: none;
                    width: 150px;
                    margin: 15px 2px;
                    font-weight: bold;
                }
            
                button:hover {
                    box-shadow: 0px 15px 20px rgba(147, 161, 231, 0.4);
                    transform: translateY(-7px);
                    background-color: #2a60c3;
                }
            
                /* Fenster */
                div.frame {
                    border-radius: 15px;
                    padding: 25px;
                    margin: 25px;
                    width: fit-content;
                    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                    background-color: white;
                }
            </style>
            </head>
            
            <body>
                <main>
                    <center>
                <div>
                    <p style= \"font-size: 20px\">Danke f&uumlr die Registrierung! <br> Sind Sie bereit f&uumlr Ihren ersten Trip?
                    <br> Ihr Aktivierungscode: $token </b></p>
                </div>
                <div>
            <img alt=\"Image\" src=\"https://media0.giphy.com/media/00Tkw1cnIsl2gdZHZ7/giphy.gif?cid=20eb4e9dikte6pkvfjiu7nht9hol0uy1j6voplctwx19xiq0&rid=giphy.gif&ct=s\" style=\"height: auto; width: 230px; max-width: 80%;\" title=\"Image\"/></div>
            <div><img alt=\"Image\" src=\"https://ideagensite-ideagensiteprodstore.azureedge.net/corp-prodcache/1/b/c/8/3/7/1bc83723ef56d62965e79d96692601e36557914d.png\" style=\"height: auto; width: 230px; max-width: 80%;\" title=\"Image\"/>
            <br>  <b>Ihr Gamma Team</b>
            
            </div>
            
            </center>
            </main>
            </body>
            </html>";

        send_mail($recipient, $subject, $message);

        header("Location: ../Mailer/email_success.php");
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
            <?php if (isset($error)) : ?>
                <span class="form_font_error"><?php echo $error; ?></span>
            <?php endif ?>
            <?php if (isset($email_error)) : ?>
                <span class="form_font_error"><?php echo $email_error; ?></span>
            <?php endif ?>
            <?php if (isset($name_error)) : ?>
                <span class="form_font_error"><?php echo $name_error; ?></span>
            <?php endif ?>

            <div class="frame">
                <form method="POST" action="register.php" id="register_form">
                    <div class="group">
                        <label for="vorname">*Vorname</label>
                        <input type="text" name="vorname" placeholder="Vorname" required value="<?php echo $vorname; ?>">

                        <label for="nachname">*Nachname</label>
                        <input type="text" name="nachname" placeholder="Nachname" required value="<?php echo $nachname; ?>">

                        <label for="pseudo">*Pseudo</label>
                        <div <?php if (isset($error) or isset($name_error)) : ?> class="form_frame_error" <?php endif ?>>
                            <input type="text" name="pseudo" placeholder="pseudo" required value="<?php echo $pseudo; ?>">

                        </div>

                        <label for="email">*E-Mail</label>
                        <div <?php if (isset($error) or isset($email_error)) : ?> class="form_frame_error" <?php endif ?>>
                            <input type="email" name="emailAdresse" placeholder="E-Mail" required value="<?php echo $emailAdresse; ?>">

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