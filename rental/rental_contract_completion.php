<?php
    require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
    require (realpath(dirname(__FILE__) . '/../functions/functions.php'));

    echo $_GET['reservierungID'];
    mietvertragErstellen();
    
    function mietvertragErstellen() {
        //Datenbankeintrag anlegen
        //rechnung anlegen
        //set status für Reservierung = aktiv
        //Mietvertrag PDF
    }
?>