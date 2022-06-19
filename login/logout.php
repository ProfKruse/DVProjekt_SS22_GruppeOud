<?php
    session_start();
        if(isset($_SESSION['pseudo'])){
            unset($_SESSION['pseudo']);
            unset($_SESSION['table']);
        }
    header("Location: ../login/login.php");
    die;
?>
