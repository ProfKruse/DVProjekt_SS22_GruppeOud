<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css">
        <title>KFZ Rücknahme</title>
    </head>
    <body style="background-image:url()">
        <?php
                include("db_inc.php");
                if (isset($_POST['mietvertagsid'])) {
                    $mietvertragsid = $_POST["mietvertagsid"];
                    $statement = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $mietvertragsid;
                    $db_erg = mysqli_query( $con, $statement );
                    if ( ! $db_erg )
                    {
                        die('Die eingegebene ID existiert nicht in der DB');
                    }
                    while ($zeile = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC))
                    {
                        echo"<tr>
                            <td>{$zeile['mietvertragID']}</td>
                            <td>{$zeile['status']}</td>
                            <td>{$zeile['mietdauerTage']}</td>
                            <td>{$zeile['mietgebuehr']}</td>    
                            <td>{$zeile['zahlart']}</td>
                            <td>{$zeile['tarif']}</td>
                            <td>{$zeile['abholstation']}</td>
                            <td>{$zeile['rueckgabestation']}</td>
                            <td>{$zeile['vertragID']}</td>
                        </tr>";
                    }
                    mysqli_free_result( $db_erg );
                    mysqli_close($con);
                }
            ?>
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
            <h1>KFZ Rücknahme</h1>
            <center>
            <div class="frame">
            <form action="return_dialog.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="textfield1"><b>*Mietvertragsnummer</b></label>
                    <input type="int" name="mietvertagsid" id="mietvertagsid" maxlength=11 required >
                </div>
                
                <div class="group">
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <center>
                <table>
                    <thead>
                        <tr>
                            <th>Mietvertragsnummer</th>
                            <th>Status</th>
                            <th>Mietdauer in Tagen</th>
                            <th>Mietgebuehr</th>
                            <th>Zahlart</th>
                            <th>Tarif</th>
                            <th>Abholstation</th>
                            <th>Rueckgabestation</th>
                            <th>Vertragsnummer</th>
                        </tr>
                    </thead>
                    <tbody>
                </tbody>
            </table>
            </center>
            <br>
            <br>
            <br>

            <form action="" method="POST">
                <div class="group">
                    <label for="ruecknahmedatum"><b>*Rücknahmedatum</b></label>
                    <input type="date" name="ruecknahmedatum" required>

                    <label for="tank"><b>*Tank</b></label>
                    <input type="number" name="tank" required>
                </div>

                <div class="group">
                    <label for="kilometerstand"><b>*Kilometerstand</b></label>
                    <input type="number" name="kilometerstand" required>

                    <label for="sauberkeit"><b>*Sauberkeit</b></label>
                    <input type="text" name="sauberkeit" required>
                </div>
                
                <br>
                <button type="submit">Protokoll erzeugen</button></div>
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