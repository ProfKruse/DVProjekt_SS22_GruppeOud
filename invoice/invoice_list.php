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
        <link rel="stylesheet" href="../src/styles/global.css">
        <title>Rechnungen</title>
    </head>
    <body style="background-image:url()">
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
                        <li><a href="../login/logout.php">Logout</a></li>
                    </b>
                </ul>
            </nav>
        </header>
        <!--Reservierungseingaben-->
        <main>
            <h1>Rechnungen</h1>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>            
                        <th>Erstellt am</th>          
                        <th>Zu bezahlen bis</th>          
                        <th>Bezahlt am</th>          
                        <th>Verspätung in Tagen</th>    
                        <th>Herunterladen</th>                     
                    </tr>
                </thead>
                <!-- Inhalt -->
                <tbody>
                    <tr>
                        <td>01_01_2022</td>              
                        <td>01.01.2022</td>          
                        <td>30.01.2022</td>          
                        <td>15.01.2022</td>          
                        <td>-</td>    
                        <td><button type="button">Download</button></td>                     
                    </tr>
                    <tr>
                        <td>12_04_2022</td>              
                        <td>01.04.2022</td>          
                        <td>30.04.2022</td>          
                        <td>Ausstehend</td>          
                        <td>5</td>    
                        <td><button type="button">Download</button></td>                     
                    </tr>
                    <tr>
                        <td>25_03_2022</td>              
                        <td>25.03.2022</td>          
                        <td>30.04.2022</td>          
                        <td>Ausstehend</td>          
                        <td>-</td>    
                        <td><button type="button">Download</button></td>                     
                    </tr>
                    <tr>
                        <td>30_03_2022</td>              
                        <td>30.03.2022</td>          
                        <td>30.04.2022</td>          
                        <td>Ausstehend</td>          
                        <td>-</td>    
                        <td><button type="button">Download</button></td>                     
                    </tr>
                </tbody>
            </table>

            <br>

		<h1>Mahnungen</h1>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsnummer</th>
                        <th>Mahnungssstatus</th>
                        <th>Betrag</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12_04_2022</td>
                        <td>1</td>
                        <td>500€</td>
                    </tr>
                </tbody>
            </table>

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