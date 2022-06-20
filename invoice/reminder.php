<?php
require_once(realpath(dirname(__FILE__)."/../functions/functions.php"));
require_once(realpath(dirname(__FILE__)."/../Database/db_inc.php"));

if(isset($_GET["reminder_type"]) && isset($_GET["einzelrechnungnr"])) {
    $type = $_GET["reminder_type"];
    $rechnungnr = $_GET["einzelrechnungnr"];
    sendReminder($rechnungnr, $type);
}

function sendReminder($rechnungnr, $type) {
    $con = mysqli_connect("localhost","root","","autovermietung");
    $rechnung = mysqli_fetch_array($con->query("SELECT * FROM rechnungen WHERE rechnungNr=".$rechnungnr));

    $mahnungnr = ($rechnung["mahnstatus"] == "erste Mahnung") ? 1 : 2;
    if($rechnung["mahnstatus"] == "dritte Mahnung")
        $mahnungnr = 3;
    
    $verlaengerung = ($rechnung["mahnstatus"] == "erste Mahnung") ? 7 : 14;
    $zahlungsfrist = date("Y-m-d",strtotime($rechnung["zahlungslimit"])+($verlaengerung*86400));
    
    $mahnungsdaten = array("rechnungnr"=>$rechnungnr,"rechnungbetrag"=>$rechnung["rechnungBetrag"],"rechnungdatum"=>$rechnung["versanddatum"],"mahnungnr"=>$mahnungnr,
    "alte_zahlungsfrist"=>$rechnung["zahlungslimit"],"neue_zahlungsfrist"=>$zahlungsfrist);
    
    $kunde = mysqli_fetch_array($con->query("SELECT * FROM kunden WHERE kundeID=".$rechnung["kundeID"]));
    $kundendaten = array("kundennr"=>$kunde["kundeID"],"name"=>$kunde["vorname"]." ".$kunde["nachname"],"straße"=>$kunde["strasse"]." ".$kunde["hausNr"],"stadt"=>$kunde["plz"]." ".$kunde["ort"],"email"=>$kunde["emailAdresse"],"zahlungsziel"=>$kunde["zahlungszielTage"]);
    
    createMahnungPDF($kundendaten, $mahnungsdaten, $type);
}

?>