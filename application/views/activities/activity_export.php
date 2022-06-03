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
                    <td style="text-align:center;font-weight:bold;font-size:18px">LAPORAN KEGIATAN HARIAN SECURITY</td>
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
        <table border="0" cellspacing="0" cellpadding="3">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-weight:bold">1.	Laporan Kegiatan / Kejadian Harian</td>
                </tr>
            </tbody>
		</table>
        ';

$html .= '
        <table border="1" cellspacing="0" cellpadding="3" width="100%">
            <thead>
                <tr>
                    <th style="width:30px;text-align:center;font-weight:bold">NO</th>
                    <th style="width:60px;text-align:center;font-weight:bold">JAM</th>
                    <th style="width:350px;text-align:center;font-weight:bold">URAIAN KEGIATAN / KEJADIAN HARIAN</th>
                    <th style="width:200px;text-align:center;font-weight:bold">DOKUMENTASI</th>
                </tr>
            </thead>
        ';
$n = 1;
foreach ($activities as $activity) {
    $html .= '
        <tbody>
            <tr>
                <td style="width:30px;text-align:center;">' .  $n++ . '</td>
                <td  style="width:60px;text-align:center;">' . indo_time($activity['jam']) . '</td> 
                <td  style="width:350px;">Petugas: ' . $activity['nama'] . '<br><br>' . $activity['activity'] . '</td>
                <td  style="width:200px;"><img src="https://hris.tpm-facility.com/assets/imagesofgms/activities/' . $activity['images'] . '" ></td>
            </tr>
        <tbody>
    ';
}

$html .=    '
        </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="3">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-weight:bold">2.	Laporan Abesensi </td>
                </tr>
            </tbody>
		</table>
        <table border="1" cellspacing="0" cellpadding="3" width="100%">
            <thead>
                <tr>
                    <th style="width:30px;text-align:center;font-weight:bold">NO</th>
                    <th style="width:200px;text-align:center;font-weight:bold">PETUGAS</th>
                    <th style="width:130px;text-align:center;font-weight:bold">POSISI</th>
                    <th style="width:130px;text-align:center;font-weight:bold">KEHADIRAN</th>
                    <th style="width:150px;text-align:center;font-weight:bold">WAKTU</th>
                </tr>
            </thead>';
$n = 1;
foreach ($attendance as $att) {
    $html .= '
            <tbody>
            <tr>
                <td style="width:30px;text-align:center;">' .  $n++ . '</td>
                <td  style="width:200px;">' . $att['nama'] . '</td> 
                <td  style="width:130px;">' . $att['position'] . '</td>
                <td  style="width:130px;">' . $att['keterangan'] . '</td>
                <td  style="width:150px;text-align:center;">' . indo_time($att['datetime_in']) . ' - ' . indo_time($att['datetime_out']) . '</td>';

    // if ($att['hours'] != 0) {
    //     $html .= '<td  style="width:100px;">' . $att['hours'] . ' Jam' . '</td>';
    // } else {
    //     $html .= '<td  style="width:100px;"></td>';
    // }

    $html .= '
           </tr>
        <tbody>';
}


$html .=    '
        </table>
        <br>
        <table border="0" cellspacing="0" cellpadding="3">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-weight:bold">3.	Laporan Tamu </td>
                </tr>
            </tbody>
		</table>
        <table border="0" cellspacing="0" cellpadding="3">
            <tbody>
                <tr>
                    <td>Jumlah tamu yang datang: <b>' . $visitor['counts'] . ' orang</b></td>
                </tr>
            </tbody>
		</table>
        ';

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
$pdf->Output('ActivityReport_' . $date . '_' . $site['site'] . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
