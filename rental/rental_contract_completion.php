<?php
    require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
    require (realpath(dirname(__FILE__) . '/../functions/functions.php'));

    mietvertragErstellen($_GET['reservierungID'],$_GET['kfz']);
    
    function mietvertragErstellen($reservierungID, $kfzid) {
        global $con;

        //Neue Einträge in den Tabellen "vertraege" und "mietvertraege" anlegen 
        $reservierung = mysqli_fetch_array($con->query("SELECT * FROM reservierungen WHERE reservierungID=".$_GET["reservierungID"]));
        $kfz;

        $vertragID = mysqli_fetch_array($con->query("SELECT vertragID FROM vertraege ORDER BY vertragID DESC"))[0]+1;
        $vertragInsertStatement = "INSERT INTO vertraege (vertragID, datum, kundeID, kfzID) VALUES ( $vertragID,'".date("Y-m-d")."',".$reservierung['kundeID'].",$kfzid)";

        $mietvertragID = mysqli_fetch_array($con->query("SELECT mietvertragID FROM mietvertraege ORDER BY mietvertragID DESC"))[0]+1;
        $mietvertragInsertStatement = "INSERT INTO mietvertraege (status, mietdauerTage, mietgebuehr, abholstation, rueckgabestation, vertragID, kundeID)
                        VALUES ('bestätigt', 0, 0, ".$reservierung["mietstationID"].",".$reservierung["mietstationID"].",$vertragID,".$reservierung["kundeID"].")";
        //$con->query($vertragInsertStatement);
        //$con->query($mietvertragInsertStatement);
        
        //Anlegen einer neuen Rechnung in der Datenbank
        //rechnungAnlegen($mietvertragID);

        $reservierungUpdateStatement = $con->query("UPDATE reservierungen SET status='aktiv' WHERE reservierungID=$reservierungID");
        //Mietvertrag PDF
    }
?>