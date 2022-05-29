<!DOCTYPE html> 
    <?php
        session_start();
        function mietvertragsAnzeige(){ 
            include("Database/db_inc.php"); 
            if (isset($_POST['mietvertagid'])) { 
                $_SESSION['mietvertragID'] = $_POST["mietvertagid"]; 
                $statement = "SELECT * FROM mietvertraege WHERE mietvertragID =" . $_SESSION['mietvertragID']; 
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
                                <th>Status</th> 
                                <th>Mietdauer in Tagen</th> 
                                <th>Mietgebuehr</th> 
                                <th>Zahlart</th> 
                                <th>Abholstation</th> 
                                <th>Rueckgabestation</th> 
                                <th>Vertragsnummer</th> 
                                <th>Kundennummer</th>
                            </tr> 
                        </thead> 
                        <tbody> 
                            <tr> 
                                <td>{$zeile['mietvertragID']}</td> 
                                <td>{$zeile['status']}</td> 
                                <td>{$zeile['mietdauerTage']}</td> 
                                <td>{$zeile['mietgebuehr']}</td>     
                                <td>{$zeile['zahlart']}</td> 
                                <td>{$zeile['abholstation']}</td> 
                                <td>{$zeile['rueckgabestation']}</td> 
                                <td>{$zeile['vertragID']}</td> 
                                <td>{$zeile['kundeID']}</td> 
                            </tr>  
                        </tbody> 
                    </table> 
                    </center>"; 
                    } 
                    if($count ==  0) 
                    { 
                        echo "<p>Die eingegebene ID existiert nicht in der DB</p>";
                        $_SESSION['mietvertragID'] = null;
                    } 
                    mysqli_free_result( $db_erg ); 
                    mysqli_close($con); 
                } 
            }

        function sendeRuecknahmeprotokoll()
        {  
            include("Database/db_inc.php");
            include("functions/function.php");
            require('pdfcreator/fpdf.php');
            $email = "";
            if (isset($_POST['tank'])) 
            {
                $tank = trim($_POST['tank']);
                if (isset($_POST['kilometerstand'])) 
            {
                $kilometerstand = trim($_POST['kilometerstand']);
                if (isset($_POST['sauberkeit'])) 
                {
                    $sauberkeit = trim($_POST['sauberkeit']);
                    if (isset($_POST['mechanik'])) 
                    {
                        $mechanik = trim($_POST['mechanik']);
                        if (isset($_SESSION['mietvertragID'])) 
                        {
                            $statement = "INSERT INTO ruecknahmeprotokolle (ersteller,tank,sauberkeit, mechanik, kilometerstand, mietvertragID) VALUES (1,'$tank','$sauberkeit','$mechanik','$kilometerstand',". $_SESSION['mietvertragID'].")"; 
                            $ergebnis = $con->query($statement);
                            //$statement = "UPDATE kfzs SET kilometerStand = " . $kilometerstand "WHERE ;"; 
                            //$ergebnis = $con->query($statement);
                            $email = "tm.middeke@gmx.de";#$con->query("SELECT emailAdresse FROM kunden WHERE kundeID=" . $_SESSION['mietvertragID']);                          
                            mysqli_close($con);
                            
                                $subject = 'Ruecknahmeprotokoll';
                                $message = '<!DOCTYPE html>
                                <html>
                                <body>
                                <p>Sehr geehrter Kunde,</p>
                                <p>anbei erhaelst du dein Ruecknahmeprotokoll. ;)</p>
                                <br>
                                <p>Mit lieben Gruessen</p>
                                <p>Dein Pascal</p>
                                </body>
                                </html>'; 
                                $pdf = new FPDF();
                                $pdf->AddPage();
                                $pdf->SetFont('Arial','B',16);
                                $pdf->Cell(40,10,'Ruecknahmeprotokoll:',1,1);
                                $pdf->SetFont('Arial','B',12);
                                $pdf->Cell(40,10,'Der Tank war noch zu:' . $tank . 'gefuellt.',1,1);
                                $pdf->Cell(40,10,'Das Auto war ' . $sauberkeit . '.',1,1);
                                $pdf->Cell(40,10,'Die Mechanik war ' . $mechanik . '.',1,1);
                                $pdf->Cell(40,10,'Du bist ' . $kilometerstand . 'km gefahren.',1,1);
                                $pdf->Cell(40,10,'Deine Mietvertragsnummer ist: ' . $_SESSION['mietvertragID'] . '.',1,1);
                                $doc = $pdf->Output('S');
                                send_mail($email, $subject, $message,$doc,"Ruecknahmeprotokoll.pdf");
                                die;
                             
                        }
                        else
                        {
                            echo "<p>Die eingegebene ID existiert nicht in der DB, bitte geben Sie eine korrekte ein und geben Sie dann erneut die nutzungsrelevanten Daten ein.</p>";
                        }
                    }
                }                       
            }
            session_destroy();                
        }

    }
    ?> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <link rel="stylesheet" href="../src/styles/style_returnDialog.css"> 
        <title>KFZ Rücknahme</title> 
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
            <h1>KFZ Rücknahme</h1> 
            <center> 
            <div class="frame"> 
            <form action="return_dialog.php" method="POST"> 
                <!--------------------------------------------------------------> 
                <div class="group"> 
                    <label for="mietvertragsnummer"><b>*Mietvertragsnummer</b></label> 
                    <input type="number" name="mietvertagid" id="mietvertagid" max="99999999999" min="1"  required > 
                </div> 
                 
                <div class="group"> 
                    <label for="abfragen"><b>Daten abfragen</b></label>  
                    <button type="submit" >Abfragen</button> 
                </div> 
            </form> 
            <?php 
                mietvertragsAnzeige(); 
            ?> 
            <form action="return_dialog.php" method="POST"> 
                <div class="group">                   
                    <label for="tank"><b>*Tank</b></label> 
                    <input type="number" name="tank" min="0" max="100" required> 

                    <label for="kilometerstand"><b>*Kilometerstand</b></label> 
                    <input type="number" name="kilometerstand" min="0" required> 

                    <label for="sauberkeit"><b>*Sauberkeit</b></label> 
                    <select name="sauberkeit" id="sauberkeit" required> 
                        <option value="sehr Sauber">Sehr Sauber</option> 
                        <option value="sauber">Sauber</option> 
                        <option value="neutral">Neutral</option> 
                        <option value="leicht schmutzig">Leicht schmutzig</option> 
                        <option value="sehr schmutzig">Sehr schmutzig</option> 
                    </select> 

                    <label for="mechanik"><b>*Mechanikstatus</b></label> 
                    <input type="text" name="mechanik" maxlength="1000" required> 
                </div> 
                <br>
                <button type="submit">Protokoll erzeugen</button></div>
                <?php 
                    sendeRuecknahmeprotokoll(); 
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