<?php
    session_start();
        if(isset($_SESSION['pseudo'])){
            unset($_SESSION['pseudo']);
        }
    header("Location: ../login/login.php");
    die;
?>
