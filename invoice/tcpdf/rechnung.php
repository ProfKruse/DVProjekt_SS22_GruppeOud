<?php
require_once(__DIR__ . '.\global.php');
//============================================================+
// License: GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2016 Nils Reimers - PHP-Einfach.de
// This is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// Nachfolgend erhaltet ihr basierend auf der open-source Library TCPDF (https://tcpdf.org/)
// ein einfaches Script zur Erstellung von PDF-Dokumenten, hier am Beispiel einer Rechnung.
// Das Aussehen der Rechnung ist mittels HTML definiert und wird per TCPDF in ein PDF-Dokument übersetzt. 
// Die meisten HTML Befehle funktionieren sowie einige inline-CSS Befehle. Die Unterstützung für CSS ist 
// aber noch stark eingeschränkt. TCPDF läuft ohne zusätzliche Software auf den meisten PHP-Installationen.
// Gerne könnt ihr das Script frei anpassen und auch als Basis für andere dynamisch erzeugte PDF-Dokumente nutzen.
// Im Ordner tcpdf/ befindet sich die Version 6.2.3 der Bibliothek. Unter https://tcpdf.org/ könnt ihr erfahren, ob 
// eine aktuellere Variante existiert und diese ggf. einbinden.
//
// Weitere Infos: http://www.php-einfach.de/experte/php-codebeispiele/pdf-per-php-erstellen-pdf-rechnung/ | https://github.com/PHP-Einfach/pdf-rechnung/

$nr = databaseSelectQuery("rechnungNr","rechnungen","");
$marke = databaseSelectQuery("rechnungNr","rechnungen","");
$modell = databaseSelectQuery("rechnungNr","rechnungen","");
$kennzeichen = databaseSelectQuery("rechnungNr","rechnungen","");
$mietdauer = databaseSelectQuery("rechnungNr","rechnungen","");
$preis = databaseSelectQuery("rechnungNr","rechnungen","");

$rechnungs_nummer = "743";
$rechnungs_datum = date("d.m.Y");
$lieferdatum = date("d.m.Y");
$pdfAuthor = "PHP-Einfach.de";

$rechnungs_header = '
<h1>Rentalcar</h1>
Max Mustermann
Musterstraße 1
12345 Stadt';

$rechnungs_footer = "Wir bitten um eine Begleichung der Rechnung innerhalb der Zahlungsfrist. Bitte Überweisen Sie den vollständigen Betrag an:

<b>Empfänger:</b> Meine Firma
<b>IBAN</b>: DE85 745165 45214 12364
<b>BIC</b>: C46X453AD";


//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnuns, Menge, Einzelpreis]
$rechnungs_posten = array(
	array("1", "Ford", "Mustang", "WES-DE-27", 20, 500),
	array("2", "Ford", "Mustang", "WES-DE-27", 20, 500));

//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
$umsatzsteuer = 0.0; 

$pdfName = "Rechnung_".$rechnungs_nummer.".pdf";


//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.

$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
	<tr>
		<td>'.nl2br(trim($rechnungs_header)).'</td>
	   <td style="text-align: right">
Rechnung Nr.: '.$rechnungs_nummer.'<br>
Rechnungsdatum: '.$rechnungs_datum.'<br>
Kundennr: '.$lieferdatum.'<br>
Zahlungsfrist: 24.05.2022
		</td>
	</tr>

	<tr>
		 <td>
<br><br>
<b style="font-size:1.3em;">Rechnung</b><br>
<p>Sehr geehrter Herr/Frau Mustermann,
<br><br>
Wir bedanken uns für ihren Auftrag.
<br>Wir erlauben uns folgende Rechnungsstellung:</p>
<br>
</td>
	</tr>
</table>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
	<tr style="background-color: #cccccc; padding:5px;">
		<td style="padding:5px;"><b>Nr.</b></td>
		<td style="text-align: center;"><b>Marke</b></td>
		<td style="text-align: center;"><b>Modell</b></td>
		<td style="text-align: center;"><b>Kennzeichen</b></td>
		<td style="text-align: center;"><b>Mietdauer</b></td>
		<td style="text-align: center;"><b>Gesamtpreis</b></td>
	</tr>';
			
	
$gesamtpreis = 0;

foreach($rechnungs_posten as $posten) {
	$preis = $posten[5];
	$gesamtpreis += $posten[5];
	$html .= '<tr>
                <td>'.$posten[0].'</td>
				<td style="text-align: center;">'.$posten[1].'</td>		
				<td style="text-align: center;">'.$posten[2].'</td>	
                <td style="text-align: center;">'.$posten[3].'</td>
				<td style="text-align: center;">'.$posten[4].'</td>
				<td style="text-align: center;">'.number_format($posten[5] , 2, ',', '').'€</td>
              </tr>';
}
$html .="</table>";



$html .= '
<hr>
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
$umsatzsteuer_betrag = $gesamtpreis*0.19;
	
	$html .= '
			<tr>
				<td colspan="3">Zwischensumme (Netto)</td>
				<td style="text-align: center;">'.number_format($gesamtpreis , 2, ',', '').' Euro</td>
			</tr>
			<tr>
				<td colspan="3">Umsatzsteuer (19%)</td>
				<td style="text-align: center;">'.number_format($umsatzsteuer_betrag, 2, ',', '').' Euro</td>
			</tr>';

$html .='
            <tr>
                <td colspan="3"><b>Gesamtsumme: </b></td>
                <td style="text-align: center;"><b>'.number_format($gesamtpreis+$umsatzsteuer_betrag, 2, ',', '').' Euro</b></td>
            </tr>			
        </table>
<br><br><br>';

$html .= nl2br($rechnungs_footer);



//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// TCPDF Library laden
require_once('tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle('Rechnung '.$rechnungs_nummer);
$pdf->SetSubject('Rechnung '.$rechnungs_nummer);


// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output($pdfName, 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';

?>
