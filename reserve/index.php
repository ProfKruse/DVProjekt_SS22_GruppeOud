<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
            .container{
                width: 80%;
                margin:auto;
                background-color:#008080;
            }
            .textarea {
                background:url(textarea-background-image.png) top right no-repeat; 
                background-size: 80%;
                margin:auto;
                border-radius:6px; 
                border:2px solid silver;
                outline: none; 
            }
        
    </style>
</head>
<body>

<div class= "container"> 

    <h2><centre>Autovermietung - Reservierung</centre></h2>




   <form name="" action="index.php" method= "post" target="ausgabe"enctype="text/html">
        <fieldset>
            <legend>Daten</legend>
            <p>
            <label for= "vorname">Vorname:</label>
            <input type ="text" name ="vorname" id= "vorname"/>
            </p>
            <p>
            <label for= "nachname">Nachname:</label>
            <input type ="text" name ="nachname" id= "nachname"/>
            </p>
            <p>
            <label for= "straße">Straße:</label>  <input type ="text" name ="straße" id= "straße"/> <label for= "hausnummer">Hausnummer:</label>
           <input type ="number" name ="hausnummer" id= "hausnummer"/>
            </p>
            <p>
            <label for= "PLZ">PLZ:</label>
            <input type ="text" name ="PLZ" id= "PLZ"/>
            <label for= "wohnort">Wohnort:</label>
            <input type ="text" name ="wohnort" id= "wohnort"/>
            </p>
            <p>
            <label for= "geburtsdatum">Geburtsdatum:</label> 
            <input type="date" id="geburtsdatum">
            </p>
            <p>
            <label for= "ausweisnummer">Ausweisnummer:</label> 
            <input type="text"name ="ausweisnummer" id="ausweisnummer">
            </p>
            <label for= "mietbeginn">Mietbeginn:</label> 
            <input type="date" id="mietbeginn">
            <label for= "mietende">Mietende:</label> 
            <input type="date" id="mietende">
            <p>
            <label for= "automarke">Automarke:</label> 
            <select>
                
            <option>Alfa Romeo	</option>
            <option>Audi</option>
            <option>BMW	</option>
            <option>Chevrolet</option>
            <option>Chrysler	</option>
            <option>Citroën</option>
            <option>Dacia</option>
            <option>Fiat</option>
            <option>Ford</option>
            <option>Honda</option>
            <option>Hyundai	</option>
            <option>Jeep</option>
            <option>Kia	</option>
            <option>Land Rover</option>
            <option>Lexus</option>
            <option>Mazda</option>
            <option>Mercedes</option>
            <option>Mini</option>
            <option>Mitsubishi</option>
            <option>Nissan</option>
            <option>Opel</option>
            <option>Peugeot</option>
            <option>Porsche</option>
            <option>Renault</option>
            <option>Seat</option>
            <option>Skoda</option>
            <option>Smart</option>
            <option>Subaru</option>
            <option>Suzuki</option>
            <option>Toyota</option>
            <option>VW</option>
            <option>Volvo</option>
            
</select>
            </p>
            <div class= "textarea"> 
            <label for= "text">Ihre Nachricht an uns:</label> 
            <input type="textarea" id="text">
            </div class= "textarea"> 
            <p>
            <input type ="submit" name ="submit" id ="submit"> <input type= "reset"name ="reset">
            </p>
 <?php
         function ageCalculator( $gbdatum ) 
         {
              $geb_tag=substr($gbdatum,0,2);
              $geb_mon=substr($gbdatum,3,2);
              $geb_jahr=substr($gbdatum,6,4);
            

             if ( !checkdate($geb_mon, $geb_tag, $geb_jahr) )
                return false;
        
             $cur_day = date("d");
             $cur_month = date("m");
             $cur_year = date("Y");

             $calc_year = $cur_year - $geb_jahr;
    
             if( $geb_mon > $cur_month )
                return $calc_year - 1;
             elseif ( $month == $cur_month && $geb_tag > $cur_day )
                return $calc_year - 1;
            else
                 return $calc_year;

} 
?>
    <?PHP
// Ausführen wenn Formular gesendet
    if (isset($_POST["submit"]))
        {  if (isset($_POST["geburtsdatum"]) 
            or (!empty($_POST["geburtsdatum"])))

       {
        $datum = $_POST["geburtsdatum"];
        $age = ageCalculator($datum);
    if ( $age == false )
        echo "Geben Sie ein gültiges Alter ein!";
        
        elseif($age <18)
        echo "Sie müssen mind. 18 Jahre alt sein, um ein Auto mieten zu können!";
        else
        echo "Dein Alter ist: " . ageCalculator($datum); 
        }}
?>
<?php
// Formulareingaben überprüfen und Fehlermeldungen ausgeben
         $errors = array();
       
        if (!isset($_POST["vorname"])
        or ($_POST["vorname"] == ""))
        {
        $errors[] = "Der Vorname fehlt."; 
        }
        if (!isset($_POST["nachname"])
        or($_POST["nachname"] == "")) 
        {
        $errors[] = "Der Nachname fehlt."; 
        }
        if (!isset($_POST["straße"]) 
        or($_POST["straße"] == "")) 
        {
        $errors[] = "Die Straße fehlt."; 
        }
        if (!isset($_POST["hausnummer"]) 
        or ($_POST["hausnummer"] == ""))
        {
        $errors[] = "Die Hausnummer fehlt."; 
        }
        if (!isset($_POST["PLZ"]) 
        or ($_POST["PLZ"] == ""))
        {
        $errors[] = "Die PLZ fehlt."; 
        }
        if (!isset($_POST["wohnort"]) 
        or ($_POST["wohnort"] == ""))
        {
        $errors[] = "Der Wohnort fehlt."; 
        }
        if (isset($_POST["geburtsdatum"]) 
        or (!empty($_POST["geburtsdatum"])))
        {
        $errors[] = "Das Geburtsdatum fehlt."; 
        }
        if (!isset($_POST["ausweisnummer"]) 
        or ($_POST["ausweisnummer"] == ""))
        {
        $errors[] = "Die Ausweisnummer fehlt."; 
        }

        if (isset($_POST["mietbeginn"]) 
        or (!empty($_POST["mietbeginn"])))
       
        {
        $errors[] = "Bitte wählen Sie ein Datum für den Mietbeginn aus."; 
        }
        if (isset($_POST["mietende"]) 
        or (!empty($_POST["mietende"])))
        
        {
        $errors[] = " Bitte wählen Sie ein Datum für das Mietende aus."; 
        }

        if (count($errors)) 
        {
        echo "Ihre Daten konnten nicht gespeichert werden, bitte prüfen Sie die Eingabe." .
        implode("<br>", $errors);
        }
        else{
            echo "Vielen Dank, Ihre Daten wurden gepeichert";
        }
?>

         
        
        </fieldset>
   </form>
        <div id="ausgabe">
            </div class= "container"> 
        </div>
        </div>
</body>
</html>


