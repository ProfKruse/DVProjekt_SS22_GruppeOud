<?php
    session_start();
    include("../database/db_inc.php");
    include("../functions/functions.php");
    $user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $_SESSION["reservierungID"]= $_GET['reservierungID'];
        $heute = date_create(date('y-m-d'));
        $mietbeginn_reservierung = databaseSelectQuery("Mietbeginn","reservierungen","WHERE reservierungID = ". $_SESSION["reservierungID"]."");
        $diffInDays = date_create($mietbeginn_reservierung[0])->diff($heute);
        $iffInDays = $diffInDays->d;
        $checkifToCancel =  $iffInDays > 1 ?  true: false;

        if($checkifToCancel){
            $stmt = "delete from reservierungen where reservierungID = ".$_SESSION["reservierungID"].";";
            $result = $con->query($stmt);
        }
        
    }
    //header("Location: ../index.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Reservierung erfolgreich</title>
    </head>
    <body>
        <!--Header-->
        <header>
            <nav>
                <ul>
                    <b>
                    <li><a href="../index.php">Home</a></li>
                        <li><a href="reservation.php">Reservieren</a></li>
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b> Hallo <?php echo $user_data['pseudo'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
            <center>
                
                    <?php
                        
                        if($checkifToCancel){
                    ?>
                            <div id="successFrame" class="frame" style="width: 500px">
                    <?php
                            echo "<h1>Reservierung erfolgreich storniert</h1>";
                    ?>
                            </div>
                    <?php
                        }
                        else {
                    ?>
                            <div id="failureFrame" class="frame" style="width: 500px">
                    <?php
                            echo "<h1>Sie können leider nicht mehr stornieren</h1>";
                    ?>
                            </div>
                    <?php
                        }
                    ?>
                

                <div class="buttons" style="width: 150px;">
                    <button type="button" onclick="window.location='..\\index.php'">Start Seite</button>
                </div>
            </center>
        </main>
        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>