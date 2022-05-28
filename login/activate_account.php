<?php
session_start();
include("../database/db_inc.php");
include("../functions/functions.php");
$user_data = check_login($con);
$token_toCheck = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pseudo = $user_data['pseudo'];
    $token_toCheck = $_POST['activationCode'];
    $token = $user_data['token'];

    if ($token_toCheck == $token) {
        $activate_account = "update kunden set validatedAccount = true where pseudo = '$pseudo' ";
        mysqli_query($con, $activate_account);
        header("Location: verify_email.php");
        die;
    } else {
        $error = "Der eingegebenen Code ist Falsch!";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/styles/register.css">
    <title>Reservierung erfolgreich</title>
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
                    <li><b> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                    <li><a href="../login/logout.php">Logout</a></li>
                </b>
            </ul>
        </nav>
    </header>
    <!--Reservierungseingaben-->
    <main>
        <center>
        <h2>Geben Sie Ihr Aktivierungscode ein</h2>
            <?php if (isset($error)) : ?>
                <span class="form_font_error"><?php echo $error; ?></span>
            <?php endif ?>
            <div class="frame">
                <div>
                    <form action="" method="post">
                        <input type="number" name="activationCode" placeholder="Activation Code" required value = <?php echo $token_toCheck ?> >
                        <button type="submit"> Code Verifizieren </button>
                    </form>
        </center>
    </main>
    <!--Sonstige Links-->
    <aside>
        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
</body>
</html>