<?php
    require("../library/fpdf.php");
    $marke = ($_POST["marke"]);
    $standardRate = ($_POST["standardRate"]);
    $kilometerstand = ($_POST["kilometerstand"]);
    $ausstattung = ($_POST["ausstattung"]);
    $modell = ($_POST["modell"]);
    $zustand = ($_POST["zustand"]);
    $kennzeichen = ($_POST["kennzeichen"]);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10, $marke);
    $pdf->Cell(40,10, $modell);
    $pdf->Cell(40,10, $kilometerstand);
    $pdf->Cell(40,10, $kennzeichen);
    $pdf->Cell(40,10, $zustand);
    $pdf->Cell(40,10, $ausstattung);
    $pdf->Cell(40,10, $standardRate);
    $pdf->Output();
?>