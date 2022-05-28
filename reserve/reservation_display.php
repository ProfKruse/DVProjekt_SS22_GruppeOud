<!DOCTYPE html>
    <?php
        function reservierungsdatenAnzeigen()
        {
            include("db_con.php");
            if (isset($_POST['reservierungID'])) 
            {
                $reservierungID = $_POST["reservierungID"];

                $statement = "SELECT vorname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $reservierungID;
                $vorname = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $reservierungID;
                $nachname = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT typBezeichnung FROM kfztypen JOIN reservierungen ON kfztypen.kfzTypID = reservierungen.kfzTypID WHERE reservierungID =" . $reservierungID;
                $kfztyp = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT status FROM reservierungen WHERE reservierungID =" . $reservierungID;
                $status = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT name FROM mietstationen JOIN reservierungen ON mietstationen.mietstationID = reservierungen.mietstationID WHERE reservierungID =" . $reservierungID;
                $abholstation = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT datum FROM reservierungen WHERE reservierungID =" . $reservierungID;
                $datum = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

               
                    echo"<center>
                    <table class='mietdaten'>
                        <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>Kfz-Typ</th>
                                <th>Status</th>
                                <th>Abholstation</th>
                                <th>Datum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$vorname['vorname']}</td>
                                <td>{$nachname['nachname']}</td>
                                <td>{$kfztyp['typBezeichnung']}</td>
                                <td>{$status['status']}</td>    
                                <td>{$abholstation['name']}</td>
                                <td>{$datum['datum']}</td>
                            </tr> 
                        </tbody>
                    </table>
                    </center>";
                    
                    mysqli_close($con);
                }
            }
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css">
        <title>Reservierungsdaten anzeigen</title>
    </head>
    <body style="background-image:url()">   
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
        <!--Reservierungseingaben-->
        <main>
            <h1>Reservierungsdaten anzeigen</h1>
            <center>
            <div class="frame">
            <form action="reservation_display.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="reservierungID"><b>*Reservierungsnummer</b></label>
                    <input type="number" name="reservierungID" id="reservierungID" maxlength=11 required >
                </div>
                
                <div class="group">
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <?php
                reservierungsdatenAnzeigen();
            ?>
            <br>  
            <br>
            <br>
            <br>
                
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