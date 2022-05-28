<!DOCTYPE html>
    <?php
        function verfuegbareKfzAnzeigen()
        {
            include("db_con.php");
            if (isset($_POST['mietstationID'])) 
            {
                $mietstationID = $_POST["mietstationID"];
                $tarifID = $_POST["tarifID"];

                //Statements müssen noch bearbeitet werden
                $statement = "SELECT vorname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $mietstationID;
                $mietstationID = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $tarifID;
                $mietstationName = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT tarifID FROM kfztypen WHERE tarifID =" . $tarifID;
                $tarifID = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                $statement = "SELECT marke FROM kfztypen JOIN kfzs ON kfzs.kfzTypID = kfztypen.kfzTypID WHERE tarifID =" . $tarifID;
                $marke = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                //$statement = "SELECT nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $tarifID;
                $modell = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                //$statement = "SELECT nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $tarifID;
                $kfzTyp = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

                //$statement = "SELECT nachname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID =" . $tarifID;
                $kennzeichen = mysqli_fetch_array( (mysqli_query( $con, $statement )), MYSQLI_ASSOC);

               
                    echo"<center>
                    <table class='mietdaten'>
                        <thead>
                            <tr>
                                <th>Mietstation ID</th>
                                <th>Mietstation Name</th>
                                <th>Tarif ID</th>
                                <th>Marke</th>
                                <th>Modell</th>
                                <th>Typ Bezeichnung</th>
                                <th>Kennzeichen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$mietstationID['vorname']}</td>
                                <td>{$mietstationName['nachname']}</td>
                                <td>{$tarifID['tarifID']}</td>
                                <td>{$marke['marke']}</td>
                                <td>{$modell['nachname']}</td>
                                <td>{$kfzTyp['nachname']}</td>
                                <td>{$kennzeichen['nachname']}</td>
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
            <form action="kfz_check.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="mietstationID"><b>*Mietstation ID</b></label>
                    <input type="number" name="mietstationID" id="mietstationID" maxlength=11 required >
                </div>
                <div class="group">
                    <label for="tarifID"><b>*Tarif ID</b></label>
                    <input type="number" name="tarifID" id="tarifID" maxlength=11 required >
                </div>
                <br><br><br><br><br>
                <div>
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <?php
                verfuegbareKfzAnzeigen();
            ?>  
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