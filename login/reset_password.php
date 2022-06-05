<?php   
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");




if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $_SESSION["password_token"]= $_GET['password_token'];
    $_SESSION["email"]= $_GET['emailAdresse'];
    $query = "select * from kunden where token = '{$_SESSION["password_token"]}' limit 1 ";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);
    $_SESSION["email"] = $user_data['emailAdresse'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $new_password = $_POST['new_password'];
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "update kunden set password = '$hash' where emailAdresse = '{$_SESSION["email"]}' ";
    $result = mysqli_query($con, $query);
    header("Location: login.php");
    die;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/styles/login.css">
    <title>Passwort ändern</title>
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
                <li><a href="../login/login.php">Anmeldung</a></li>
            </b>
        </ul>
    </nav>
</header>
<body>
    <main>
        <h1>Passwort &Auml;ndern</h1>
        <center>
            <div class="frame">
                <form action = "reset_password.php" method="POST">
                    <label for="email">*Email</label>
                    <input type="email" name="email" readonly value = <?php echo $_SESSION["email"]?>>
                    <label for="new_password">*Neues Passwort</label>
                    <input type="password" name="new_password" placeholder="Neues Passwort" required>
                    </br>
                    <button type="submit">&Auml;ndern</button>
                </form>
            </div>
        </center>
    </main>
</body>
</html>