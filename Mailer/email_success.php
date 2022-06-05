<?php   
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

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
                <li><a href="../index.php">Home</a></li>
                <li><a href="../reserve/reservation.php">Reservieren</a></li>
                <li><a href="">Reservierungen</a></li>
                <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                <li><a href="../login/login.php">Login</a></li>
                </b>
            </ul>
        </nav>
    </header>
    <!--Reservierungseingaben-->
    <main>
        <center>
            <div class="frame">
                <div>
                    <img src="https://beefree.io/wp-content/themes/bee2017/img/beepro/signup/bee-plane.gif" width="20%">
                    <h3>Ihr Code wurde gesendet<br> <br> Melden Sie sich an und geben Sie ihr Code ein, <br> um Ihr Konto zu aktivieren.</h3>
                    <div>
                        <p>
                            Wenn Sie die E-Mail nicht finden, <br> checken Sie bitte Ihren SPAM Ordner 🙂. <br>
                        </p>
                    </div>
                </div>
                <a href="../login/login.php"><button>Anmelden</button></a>
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