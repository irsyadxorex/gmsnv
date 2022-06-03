<?php
// require_once('tcpdf_include.php');

// create new PDF document
ob_start();


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('TPM Group');
$pdf->setTitle('GMS | Checkpoint Report');
$pdf->setSubject('PT. Trimitra Putra Mandiri');
$pdf->setKeywords('TCPDF, PDF, tpm, ism');

// set default header data
$pdf->SetHeaderData(false, false, "GMS - Guard Management System", "PT TRIMITRA PUTRA MANDIRI");
// $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, false, false);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// $pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
// $pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
// $pdf->setFillColor(255, 255, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
// create some HTML content
$html = '
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Laporan Patroli</title>
	</head>
	<body>
    ';
$html .= '
        <table border="0" cellspacing="0" cellpadding="1">
            <tbody>
                <tr>
                    <td style="text-align:center;font-weight:bold;font-size:18px">LAPORAN PATROLI HARIAN SECURITY</td>
                </tr>
                <tr>
                    <td style="text-align:center;font-size:16px">' . strtoupper($site['site']) . '</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
';

$html .= '
        <table border="0" cellspacing="0" cellpadding="1">
            <tbody>
                <tr>
                    <td width="15%">HARI / TGL </td>
                    <td width="85%">: ' . indo_longdate($date) . '</td>
                </tr>

                <tr>
                    <td>SITE</td>
                    <td>: ' . $site['site'] . '</td>
                </tr>
                <tr>
                    <td>DANRU</td>
                    <td>: ';
foreach ($danru as $d) {
    $html .= $d['nama'] . ', ';
}
$html .= '
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        ';

$html .= '
        <table border="1" cellspacing="0" cellpadding="3" width="100%">
            <thead>
                <tr>
                    <th style="width:30px;text-align:center;font-weight:bold">NO</th>
                    <th style="width:150px;text-align:center;font-weight:bold">PETUGAS</th>
                    <th style="width:60px;text-align:center;font-weight:bold">JAM</th>
                    <th style="width:200px;text-align:center;font-weight:bold">LOKASI</th>
                    <th style="width:200px;text-align:center;font-weight:bold">STATUS</th>
                </tr>
            </thead>
        ';
$n = 1;
foreach ($checkpoints as $checkpoint) {
    $html .= '
        <tbody>
            <tr>
                <td style="width:30px;text-align:center;">' .  $n++ . '</td>
                <td  style="width:150px;">' . $checkpoint['nama'] . '</td>
                <td  style="width:60px;text-align:center;">' . indo_time($checkpoint['currentdatetime']) . '</td> 
                <td  style="width:200px;">' . $checkpoint['lokasi'] . '</td>';
    if ($checkpoint['isclear'] == 1) {
        $html .= '<td  style="width:200px;">Kondusif</td>';
    } elseif ($checkpoint['isclear'] == 2) {
        $html .= '<td  style="width:200px;">Tidak Kondusif - ' . $checkpoint['note'] . '</td>';
    }
    $html .= '
            </tr>
        <tbody>
    ';
}

// $no = 1;
// foreach ($assets as $asset) {
//     $html .= '
//             <tbody>
//                 <tr>
//                     <td style="width:30px;text-align:center;">' . $no++ . '</td>
//                     <td  style="width:360px;">' . strtoupper($asset["kategori"]) . ' ' . strtoupper($asset["brand"]) . ' ' . strtoupper($asset["type"]) . ' - ' . '
//                         <i>' . strtoupper($asset["processor"]) . ' ' . ($asset["ram"] == !null ? ' RAM ' . strtoupper($asset["ram"]) . 'GB' : ' ') . ' ' . ($asset["storage"] == !null ? 'SSD ' . strtoupper($asset["storage"]) . 'GB' : ' ')  . ' 
//                         </i><br><small style="color:grey">KODE ASET : ' . $asset["kode_asset"] . ' | SN : ' . $asset["sn"] . ' </small>
//                     </td>
//                     <td  style="width:240px;">' . $asset['inven_note'] . '</td> 
//                     </tr>
//             <tbody>
//         ';
// }
$html .=    '
        </table>
    <br><br><br><br><br>';

$html .= '
    </body>
</html>
    ';

$pdf->writeHTML($html, true, false, true, false, '');


// move pointer to last page
// $pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
$pdf->Output('CheckpointReport_' . $date . '_' . $site['site'] . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
