<?php
require_once('tcpdf/tcpdf.php');
require_once('functions.php');

$kundendaten = array("kundennr"=>3,"name"=>"Max Mustermann","straße"=>"BStraße 5","stadt"=>"46487 Wesel");
$rechnungsdaten = array(array("rechnungsnr"=>2,"marke"=>"Porsche","modell"=>"Carrera GT","kennzeichen"=>"WES-DE-82","mietdauer"=>30,"gesamtpreis"=>2500));
create_pdf($kundendaten,$rechnungsdaten);

function create_pdf($kundendaten, $rechnungsdaten) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
    $pdf->setCreator(PDF_CREATOR);
    $pdf->setAuthor('Rentalcar GmbH');
    $pdf->setTitle('Rechnung');
    $pdf->setSubject('Rechnungen');

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    $pdf->AddPage();

    $style = <<<EOF
        <style>
            * {
                line-height: 100%;
                font-family: Monospace;
            }
        </style>
        EOF;

    $sender_receiver_information = 
        $style.'
        <h1 style="font-family: Arial;">Rentalcar</h1>
        <table>
            <tr>
                <td>'.$kundendaten["name"].'</td>
                <td style="text-align:right;">Rechnungsdatum: '.date("d.m.Y").'</td>
            </tr>
            <tr>
                <td>'.$kundendaten["straße"].'</td>
                <td style="text-align:right;">Kundennr.:'.$kundendaten["kundennr"].'</td>
            </tr>
            <tr>
                <td>'.$kundendaten["stadt"].'</td>
                <td style="text-align:right;">Zahlbar bis: 30.05.2022</td>
            </tr>
        <table>
        <br>';

    $invoices_data = 
        $style.'
        <b>Rechnung</b>
        <pre>
Sehr geehrter Herr/Frau '.$kundendaten["name"].'
Vielen Dank für ihre Aufträge.
Wir erlauben uns folgende Rechnungsstellung:
        </pre>

        <table>
            <tr style="background-color: rgb(228, 228, 228);">
                <th>Nr.</th>
                <th>Marke</th>
                <th>Modell</th>
                <th>Kennzeichen</th>
                <th>Mietdauer</th>
                <th>Gesamtpreis</th>
            </tr>';
            
            foreach($rechnungsdaten as $rechnung) {
                $invoices_data.='<tr>';
                foreach($rechnung as $key => $value) {
                    $invoices_data.="<td>$value</td>";
                }
                $invoices_data.='</tr>';
            }

    $invoices_data.='
        </table>
        <br>
        <hr>';

    $total_amount =
        $style.'
        <hr>
        <pre style="text-align: right;">
        Nettobetrag: ';

        $nettobetrag = 0;
        foreach($rechnungsdaten as $rechnung) {
            $nettobetrag += $rechnung["gesamtpreis"];
        }
    
        $total_amount .=  $nettobetrag.'€
        zzgl. 19% MwSt: '.($nettobetrag*0.19).'€
        <b>Gesamtbetrag:'.($nettobetrag+($nettobetrag*0.19)).'€</b>
        </pre>
        <hr>
        <br>';

    $contact_information = <<<EOF
        $style
        <table>
            <tr>
                <td>Rentalcar GmbH</td>
                <td>Telefon: +49 1234 5678</td>
            </tr>
            <tr>
                <td>Straße 1</td>
                <td>E-Mail: contact@rentalcar.com</td>
            </tr>
            <tr>
                <td>12345 Ort</td>
                <td>Web: www.rentalcar.com</td>
            </tr>
        </table>
        EOF;

    $pdf->writeHTML($sender_receiver_information, true, false, true, false, '');

        pdf_area_separation($pdf, 5);

    $pdf->writeHTML($invoices_data, true, false, true, false, '');

        pdf_area_separation($pdf, 15);

    $pdf->writeHTML($total_amount, true, false, true, false, '');

        pdf_area_separation($pdf, 7);

    $pdf->writeHTML($contact_information, true, false, true, false, '');
    ob_end_clean();
    $pdfString = $pdf->Output('rechnung'.$kundendaten["kundennr"]."_".date('Y-m-d').'.pdf', 'S');

    send_mail('pascal_ewald@web.de','Rechnung zum '.date('d.m.Y'),
    'Sehr geehrte/r Frau/Herr,<br><br>Dem Anhang koennen sie ihre Rechnung entnehmen.<br><br>Vielen Dank fuer ihren Auftrag.',
    $pdfString, 'rechnung_'.date('Y-m-d').'.pdf');
}

function pdf_area_separation($pdf_file, $separation_lines) {
    for ($i=0; $i<$separation_lines; $i++) {
        $pdf_file->Ln();
    }
}

?>