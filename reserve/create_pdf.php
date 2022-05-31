<?php
require("../library/fpdf.php");
$marke = ($_POST["marke"]);
$standardRate = ($_POST["standardRate"]);
$kilometerstand = ($_POST["kilometerstand"]);
$ausstattung = ($_POST["ausstattung"]);
$modell = ($_POST["modell"]);
$zustand = ($_POST["zustand"]);
$kennzeichen = ($_POST["kennzeichen"]);
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../src/images/logo.png',10,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Mietvertrag',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,"Marke: ".$marke,0,1);
$pdf->Cell(0,10,"Modell: ".$modell,0,1);
$pdf->Cell(0,10,"Kilometerstand: ".$kilometerstand,0,1);
$pdf->Cell(0,10,"Kennzeichen: ".$kennzeichen,0,1);
$pdf->Cell(0,10,"Standart Rate: ".$standardRate,0,1);
$pdf->Cell(0,10,"Ausstattung: ".$ausstattung,0,1);
$pdf->Cell(0,10,"Zustand: ".$zustand,0,1);
$pdf->Output();
?>