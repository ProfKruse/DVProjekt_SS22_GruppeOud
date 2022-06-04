<?php
session_start();
include("../database/db_inc.php");
include("../functions/functions.php");
$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/styles/style_reservationSuccess.css">
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
                    <li><b> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                    <li><a href="../login/logout.php">Anmeldung</a></li>
                    
                </b>
            </ul>
        </nav>
    </header>
    <!--Reservierungseingaben-->
    <main>
        <center>
            <div class="frame">
                <h2>Danke!</h2>
                <p>Ihr Konto wurde aktiviert!.</p>
            </div>
            <a href="../index.php"><button>Startseite</button></a>
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
