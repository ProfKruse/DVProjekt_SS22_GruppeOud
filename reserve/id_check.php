<!DOCTYPE html>
    <?php
        function mietvertragsAnzeige(){
            include("db_inc.php");
            if (isset($_POST['mietvertagsid'])) {
                $mietvertragsid = $_POST["mietvertagsid"];
                $statement = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $mietvertragsid;
                $db_erg = mysqli_query( $con, $statement );
                if (!$db_erg )
                {
                    die('Fehler in der SQL Anfrage');
                }
                $count =  0;                
                while ($zeile = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC))
                {
                    $count = $count+1;
                    echo"<center>
                    <table class='mietdaten'>
                        <thead>
                            <tr>
                                <th>Mietvertragsnummer</th>
                                <th>Vertragsnummer</th>
                                <th>Name</th>
                                <th>Vorname</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$zeile['mietvertragID']}</td>
                                <td>{$zeile['vertragID']}</td>
                                <td>{$zeile['name']}</td>
                                <td>{$zeile['vorname']}</td>
                            </tr> 
                        </tbody>
                    </table>
                    </center>";
                    }
                    if($count ==  0)
                    {
                        echo "<br><br><br><br><br>  <p>Die eingegebene ID existiert nicht in der DB</p>";    
                    }
                    mysqli_free_result( $db_erg );
                    mysqli_close($con);
                }
            }
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css">
        <title>Identität prüfen</title>
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
            <h1>Identität prüfen</h1>
            <center>
            <div class="frame">
            <form action="id_check.php" method="POST">
                <!-------------------------------------------------------------->
                <div class="group">
                    <label for="textfield1"><b>*Mietvertragsnummer</b></label>
                    <input type="number" name="mietvertagsid" id="mietvertagsid" maxlength=11 required >
                </div>
                
                <div class="group">
                    <label for="abfragen"><b>Daten abfragen</b></label> 
                    <button type="submit" name='submit'>Abfragen</button>
                </div>
            </form>
            <?php
                mietvertragsAnzeige();
            ?>
        
            
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