<?php
// require_once('tcpdf_include.php');

// create new PDF document
ob_start();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('TPM Group');
$pdf->setTitle('TAG');
$pdf->setSubject('CHECKPOINT TAG');
// $pdf->setKeywords('TCPDF, PDF, example, test, guide');

// disable header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(0, 0, 0);

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
		<title>PRINT TAG</title>
	</head>
	<body>
    ';
$html .= '
<p style=" text-align:center;"> 
<img style="width: 220px; text-align:center;" src="' . base_url('assets/qrcode/') . $tag['qrcode'] . '.png" alt="">
<br>' . $tag['label'] . '
</p>
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
$pdf->Output($tag['label'] . '.pdf', 'I');
exit;

//============================================================+
// END OF FILE
//============================================================+
