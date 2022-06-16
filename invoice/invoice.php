<?php
require_once('../functions/functions.php');
require_once('../database/db_inc.php');
if(!isset($_SESSION)) session_start();

if(isset($_SESSION['invoice_kundendaten']) && isset($_SESSION['invoice_rechnungsdaten'])) {
    global $con;
    $daten_kunde = $_SESSION['invoice_kundendaten'];
    $daten_rechnungen = $_SESSION['invoice_rechnungsdaten'];

    if(isset($_GET["einzelrechnungnr"])) {
        foreach($_SESSION['invoice_rechnungsdaten'] as $rechnung) {
            if($rechnung['rechnungsnr'] == $_GET["einzelrechnungnr"]) {
                $daten_rechnungen = array($rechnung);
                break;
            }
        }
    }

    $pdf = createRechnungPDF($daten_kunde,$daten_rechnungen,$_GET['invoice_type'],$con);   
}
?>