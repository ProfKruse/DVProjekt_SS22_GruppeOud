<label for="vorname"><b>Vorname</b></label>
                    <input type="text" name="vorname" placeholder="Vorname" value= 

                    <?php 
                    $server = "localhost";
                    $user = "root";
                    $pass = "";
                    $database = "test";
                    // Suchparameter
                    $eingabe = "1"; //$_GET["reservierungsnummer"]

                    // Verbindungsaufnahme mit dem MySQL-Server
                    $verbindung = mysqli_connect($server, $user, $pass);
                    
                    // Auswahl der gewünschten Datenbank
                    mysqli_select_db($verbindung, $database);
                    
                    // Fetch Array mit gewünschtem Suchparameter
                    $sql = "SELECT vorname FROM kunden JOIN reservierungen ON kunden.kundeID = reservierungen.kundeID WHERE reservierungID = $eingabe";
                    $abfrage = mysqli_query($verbindung, $sql);
                    $zeile = mysqli_fetch_array($abfrage);
                    echo $zeile["vorname"];
                    
                    // Verbindung wird beendet
                    $return = mysqli_close($verbindung);
                    ?> 
                    readonly>