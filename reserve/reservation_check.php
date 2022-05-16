<?php   
session_start();
    include("../login/db_inc.php");
    include("../login/functions.php");
    $user_data = check_login($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_checkReservation.css">
        <title>Reservierungsüberprüfung</title>
    </head>
    <body>
        <!--Header-->
        <header>
            <nav>
                <ul>
                    <b>
                        <li><a href="reservation.php">Reservieren</a></li>
                        <li><a href="">Reservierungen</a></li>
                        <li><a href="../invoice/invoice_list.php">Rechnungen</a></li>
                        <li><b> Hallo <?php echo $user_data['user_name'] ?><b></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
            <h1>Überprüfung</h1>
            <center>
            <div class="frame">
                <form action="" method="POST">
                <!-------------------------------------------------------------->
                    <div class="group">
                        <label for="textfield1"><b>*Text field 1</b></label>
                        <input type="text" name="textfield1" placeholder="xxx" required>

                        <label for="textfield3"><b>*Text field 3</b></label>
                        <select name="kfztyp">
                            <option value="">Typ 1</option>
                            <option value="">Typ 2</option>
                            <option value="">Typ 3</option>
                        </select>
                    </div>

                <!-------------------------------------------------------------->

                    <div class="group">
                        <label for="textfield2"><b>*Text field 2</b></label>
                        <input type="text" name="textfield2" placeholder="xxx" required>
                    
                        <label for="textfield4"><b>*Select Date</b></label>
                        <input type="date" name="textfield4" placeholder="xxx" required>
                    </div>

                <!-------------------------------------------------------------->

                    <br>
                    <div class="group">
                        <label for="message"><b>Message</b></label>
                        <textarea name="message"></textarea>
                    </div>
                    <br>
                
                    <br>
                    <label for="checkbox1" id="checkbox">
                        <input type="checkbox" name="checkbox1"><b>Checkbox Text</b>
                    </label>
                    <br>

                    <button type="submit">Send</button>
                </form>
            </div>
            </center>
            
        </main>
        <!--Sonstige Links-->

        <!--Footer-->
        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>