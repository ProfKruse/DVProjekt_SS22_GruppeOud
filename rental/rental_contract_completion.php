<?php
    require (realpath(dirname(__FILE__) . '/../Database/db_inc.php'));
    require (realpath(dirname(__FILE__) . '/../functions/functions.php'));

    if(isset($_GET['reservierungID']) && isset($_GET['kfzid']))
        mietvertragErstellen($_GET['reservierungID'], $_GET['kfzid']);

    function mietvertragErstellen($reservierungID, $kfzid) {
        global $con;

        //Neue Einträge in den Tabellen "vertraege" und "mietvertraege" anlegen 
        $reservierung = mysqli_fetch_array($con->query("SELECT * FROM reservierungen WHERE reservierungID=".$_GET["reservierungID"]));
        $kfz = mysqli_fetch_array($con->query("SELECT * FROM kfzs WHERE kfzID=$kfzid"));

        $vertragID = mysqli_fetch_array($con->query("SELECT vertragID FROM vertraege ORDER BY vertragID DESC"))[0]+1;
        $vertragInsertStatement = "INSERT INTO vertraege (vertragID, datum, kundeID, kfzID) VALUES ( $vertragID,'".date("Y-m-d")."',".$reservierung['kundeID'].",$kfzid)";

        $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$reservierung["kundeID"]));
        $kundendaten = array("kundennr"=>$kunde["kundeID"],"name"=>$kunde["vorname"]." ".$kunde["nachname"],"straße"=>$kunde["strasse"]." ".$kunde["hausNr"],"stadt"=>$kunde["plz"]." ".$kunde["ort"],"email"=>$kunde["emailAdresse"],"sammelrechnungen"=>$kunde["sammelrechnungen"]);        
        $mietdauer = intval((strtotime($reservierung["Mietende"])-strtotime($reservierung["Mietbeginn"]))/86400);
        $tarif = mysqli_fetch_array($con->query("SELECT tarifPreis FROM tarife WHERE tarifID = (SELECT tarifID FROM kfztypen WHERE kfzTypID = ".$kfz["kfzTypID"].")"))[0];
        $abholstation = mysqli_fetch_array($con->query("SELECT beschreibung FROM mietstationen WHERE mietstationID = ".$reservierung["mietstationID"]))[0];

        $mietvertragID = mysqli_fetch_array($con->query("SELECT mietvertragID FROM mietvertraege ORDER BY mietvertragID DESC"))[0]+1;
        $mietvertragInsertStatement = "INSERT INTO mietvertraege (mietvertragID, status, mietdauerTage, mietgebuehr, abholstation, rueckgabestation, vertragID, kundeID, reservierungID)
                        VALUES ($mietvertragID, 'bestätigt', $mietdauer, $mietdauer*$tarif, ".$reservierung["mietstationID"].",".$reservierung["mietstationID"].",$vertragID,".$reservierung["kundeID"].",$reservierungID)";

        $con->query($vertragInsertStatement);
        $con->query($mietvertragInsertStatement);
        
        //Anlegen einer neuen Rechnung in der Datenbank
        $rechnungnr = rechnungAnlegen($mietvertragID);

        $reservierungUpdateStatement = $con->query("UPDATE reservierungen SET status='aktiv' WHERE reservierungID=$reservierungID");
        
        $mietvertragsdaten = array("mietvertragnr"=>$mietvertragID,"marke"=>$kfz["marke"],"modell"=>$kfz["modell"],"datum"=>date("Y-m-d"),"mietdauer"=>$mietdauer,"mietgebuehr"=>($mietdauer*$tarif),"abholstation"=>$abholstation);

        if ($kunde["sammelrechnungen"] == "keine") {
            $rechnung = mysqli_fetch_array($con->query("SELECT * FROM rechnungen WHERE rechnungNr=".$rechnungnr));
            $rechnungsdaten = array(array("rechnungsnr"=>$rechnungnr,"marke"=>$kfz["marke"],"modell"=>$kfz["modell"],"kennzeichen"=>$kfz["kennzeichen"],"mietdauer"=>$mietdauer,"gesamtpreis"=>$rechnung["rechnungBetrag"],"zahlungslimit"=>$rechnung["zahlungslimit"]));
            createRechnungPDF($kundendaten,$rechnungsdaten,'mail');
        }

        //Mietvertrag Mail
        createMietvertragPDF($kundendaten,$mietvertragsdaten,'mail');
        //Mietvertrag PDF
        createMietvertragPDF($kundendaten,$mietvertragsdaten,'file');

    }
?>