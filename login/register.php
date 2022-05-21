<?php
session_start();
    include("db_inc.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if(!empty($user_name) && !empty($password) && !is_numeric($user_name)){
            $user_id = random_num(20); 
            $query = "insert into users (user_id,user_name, password) values ('$user_id', '$user_name', '$hash')";
            mysqli_query($con,$query);

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
    <body>
        <main>
            <h1>Registrierung</h1>
            <center>
                <div class="frame">
                    <form method="POST">
                        <div class="group">
                            <label for="user_name">*User_name</label>
                            <input type="text" name="user_name" placeholder="user_name" required>

                            <label for="password">*Password</label>
                            <input type="text" name="password" placeholder="password" required>
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