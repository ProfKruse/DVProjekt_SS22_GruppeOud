<?php
session_start();
include("../database/db_inc.php");
include("../functions/functions.php");


// Dieser Teil wird nur aktiviert wenn der Benutzen sich schon versucht anzumelden, und einen falschen Password eingetragen.
// Hier wird gecjeckt, ob $_SESSION["locked"] schon vorher mit einem Zeitstemple initialisiert wurde, 
//wenn ja d.h. wir müssen dann 30 sekenden warten bis die Anmeldung wieder möglich ist.
if (isset($_SESSION["locked"])) {
    $diff = time() - $_SESSION["locked"];
    if ($diff > 30) {
        unset($_SESSION["locked"]);
        unset($_SESSION["login_attempts"]);
        $insert_attempt = "update kunden set AnzVersuche = 0";  // Die Versuche in der Datenbank reinitzialisieren
        mysqli_query($con, $insert_attempt);
    }
}

$pseudo = ""; // Das brauchen wir, um den Input wieder anzuzeigen, falls die Seite ein Fehler wirft

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Daten der Benutzer abfrgen, nachdem den Button "Anmelden" gedrückt wird.
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $query = "select * from kunden where pseudo = '$pseudo' limit 1 ";
    $result = mysqli_query($con, $query);

    //Falls der Benutzer vorhanden ist
    if (mysqli_num_rows($result) > 0) {

        // Daten in $user_data speichern
        $user_data = mysqli_fetch_assoc($result);

        // Ist das Konto aktiviert?

        //hier prüfen wir seinen Passwort, falls alles oki ist, wird die Anmeldung abgeschlossen
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['pseudo'] = $user_data['pseudo'];
            if ($user_data['validatedAccount'] == Null) {
                header("Location: activate_account.php");
                die;
            }
            else{
                header("Location: ../index.php");
                die;
            }

        }
        //falls das Passwort falsch ist starten wir den prozess der Abzhälung von den Versuchen
        else {
            $_SESSION['login_attempts'] = $user_data['AnzVersuche'];
            $_SESSION['login_attempts'] += 1;
            $insert_attempt = "update kunden set AnzVersuche = {$_SESSION['login_attempts']}"; // Die Versuche in der Datenbankspeichern
            mysqli_query($con, $insert_attempt);

            //Checken ob der Anzahl der Versuche unter der erlaubte Grenze ist. In diesem fall 3 Versuche
            //Es wird, je nach Anzahl der falschen Versuchen, einen entsprechende Nachricht angezeigt 
            if (($_SESSION['login_attempts']) < 3 and $_SESSION['login_attempts'] > 0) {
                $error = "Falsches Password!";
            } else {
                $error_attempt = "Sie müssen 30 sekunden warten, wegen zu viele Versuche!";
            }
        }
        
    } //Falls der Benutzer nicht vorhanden ist
    else {
        $error = " Das Pseudo $pseudo existiert nicht!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/styles/login.css">
    <title>Anmeldung</title>
</head>
<!--Header-->
<header>
    <nav>
        <ul>
            <b>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../reserve/reservation.php">Reservieren</a></li>
                <li><a href="">Reservierungen</a></li>
                <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                <li><a href="../login/register.php">Registrieren</a></li>
            </b>
        </ul>
    </nav>
</header>

<body>
    <main>
        <h1> Möchten Sie ein Auto reservieren?<br> Melden Sie sich ein!</h1>
        <center>
            <!--Hier werden ggf. die Nachrichten angezeigt-->
            <!--Nachricht falls es ein Fehlversuch war-->
            <?php if (isset($error)) : ?>
                <span class="form_font_error"><?php echo $error; ?></span>
            <?php endif ?>
            <!--Nachricht falls die Anzahl der Fehlversuche ist gleich 3-->
            <?php if (isset($error_attempt)) : ?>
                <span class="form_font_error"><?php echo $error_attempt; ?></span>
            <?php endif ?>

            <div class="frame">
                <form method="POST">
                    <label for="pseudo">*Username</label>
                    <div <?php if (isset($error)) : ?> class="form_frame_error" <?php endif ?>>
                        <input type="text" name="pseudo" placeholder="Username" required value=<?php echo $pseudo ?>>
                    </div>
                    <label for="password">*Passwort</label>
                    <input type="password" name="password" placeholder="Passwort" required>
                    <div><a href="forgot_password.php">Passwort vergessen?</a></div>

                    <!--Button verstecken wenn die Anzahl der Fehlversuche ist gleich 3 
                        und die $_SESSION["locked"] mit einem Zeitstemple inizialisieren-->
                    <?php
                    if (isset($_SESSION["login_attempts"])) {
                        // hier muss der Benutzen leider warten und die Seite nicht refreshen bis 30 sek gelfauft sind, 
                        //sonst nimmt er immer einen start erneut. Es bleibt als To do
                        if ($_SESSION["login_attempts"] > 2) {
                            $_SESSION["locked"] = time();
                    ?>
                            <div><span class="form_font_error"><?php echo "Sie können sich leider nicht anmelden, bitte warten sich noch!"; ?></span></div>
                        <?php
                        } else {
                        ?>
                            <button type="submit">Anmelden</button>
                        <?php
                        }
                    } else {
                        ?>
                        <button type="submit">Anmelden</button>
                    <?php
                    }
                    ?>

                    <div><a href="register.php">Neues Konto erstellen</a></div>
                </form>
            </div>
        </center>
    </main>
</body>
</html>