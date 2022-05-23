<?php

session_start();

if(isset($_SESSION['KundenId'])){

    unset($_SESSION['KundenId']);

}

header("Location: login.php");
die;

?>