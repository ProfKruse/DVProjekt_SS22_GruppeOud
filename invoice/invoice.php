<?php
require_once('../functions/functions.php');
require_once('../database/db_inc.php');
if(!isset($_SESSION)) session_start();

/*
    Erzeugt, falls Kundendaten und Rechnungsdaten gesetzt wurden, aus diesen eine Sammelrechnung aus mehreren Rechnungen oder eine Einzelrechnung
    Variablen: $_SESSION['invoice_kundendaten']: Die Daten des Kunden, an die Rechnung gestellt wird
               $_SESSION['invoice_rechnungsdaten']: Die Daten aller Rechnungen (Oder einer einzelnen), welche in die PDF-Datei übernommen werden 
*/
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

    createRechnungPDF($daten_kunde,$daten_rechnungen,$_GET['invoice_type']);   
}
?>