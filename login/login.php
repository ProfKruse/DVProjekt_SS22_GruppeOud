<?php
session_start();
    include("db_inc.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if(!empty($user_name) && !empty($password) && !is_numeric($user_name)){
            
            $query = "select * from users where user_name = '$user_name' limit 1 ";
            $result = mysqli_query($con,$query);

            if($result){
                if($result && mysqli_num_rows($result) > 0){
                    $user_data = mysqli_fetch_assoc($result);
                    if(password_verify($password, $user_data['password'])) {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: ../reserve/reservation_check.php");
                        die;
                    }
                } 
            }
            echo "wrong username or password!";
            
        }else{
            echo "wrong username or password!";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Anmeldung</title>
    </head>
    <body>
        <main>
            <h1>Anmeldung</h1>
            <center>
                <div class="frame">
                    <form method="POST">
                        <label for="user_name">*Nutzer-ID</label>
                        <input type="text" name="user_name" placeholder="user_name" required>

                        <label for="password">*Passwort</label>
                        <input type="password" name="password" placeholder="Passwort" required>
                        <a href="restPassword.php">Passwort vergessen?</a>
                        <button type="submit">Anmelden</button>
                        <a href="register.php">Neues Konto erstellen</a>
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>