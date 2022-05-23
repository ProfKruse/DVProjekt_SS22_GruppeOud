<?php
session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        if(!empty($pseudo) && !empty($password)){
            
            $query = "select * from kunden where pseudo = '$pseudo' limit 1 ";
            $result = mysqli_query($con,$query);
            if($result){
                if($result && mysqli_num_rows($result) > 0){
                    $user_data = mysqli_fetch_assoc($result);
                    if(password_verify($password, $user_data['password'])) {
                        $_SESSION['pseudo'] = $user_data['pseudo'];
                        header("Location: ../reserve/reservation_check.php");
                        die;
                    }
                } 
            }
            echo "falsche pseudo oder password!";
        }else{
            echo "falsche pseudo oder password!";
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
            <h1>Anmeldung</h1>
            <center>
                <div class="frame">
                    <form method="POST">
                        <label for="pseudo">*Nutzer-ID</label>
                        <input type="text" name="pseudo" placeholder="pseudo" required>

                        <label for="password">*Passwort</label>
                        <input type="password" name="password" placeholder="Passwort" required>
                        <a href="resetPassword.php">Passwort vergessen?</a>
                        <button type="submit">Anmelden</button>
                        <a href="register.php">Neues Konto erstellen</a>
                    
                        <?php if (isset($_SESSION['error'])){?>
                            <p style = "color:red;"><?= $_SESSION["error"];?></p>
                            
                            <?php unset($_SESSION['error'] );}?>

                        
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>