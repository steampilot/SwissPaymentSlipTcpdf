<?php
/**
 * SwissPaymentSlipTcpdf Example 01: SwissPaymentSlipTcpdf Creating an orange payment slip
 *
 * PHP version >= 5.3.0
 *
 * @licence MIT
 * @copyright 2012-2013 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 * @version: 0.5.0
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SwissPaymentSlipTcpdf Example 01: SwissPaymentSlipTcpdf Creating an orange payment slip</title>
</head>
<body>
<h1>SwissPaymentSlipTcpdf Example 01: Creating an orange payment slip</h1>
<?php
// Measure script execution/generating time
$time_start = microtime(true);

// Make sure the classes get auto-loaded
$loader = require __DIR__. '/../vendor/autoload.php';

// Import necessary classes
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlipData;
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip;
use SwissPaymentSlip\SwissPaymentSlipTcpdf\SwissPaymentSlipTcpdf;

// Make sure TCPDF has access to the additional fonts
define('TCPDF_FONTPATH', __DIR__.'/../src/SwissPaymentSlip/SwissPaymentSlipPdf/Resources/font');

// Create an instance of TCPDF, setup default settings
$tcPdf = new TCPDF('P', 'mm','A4', false, 'ISO-8859-1');

// Since we currently don't have a OCRB font for TCPDF, we disable this
//$tcPdf->AddFont('OCRB10');

// Disable TCPDF's default behaviour of print header and footer
$tcPdf->setPrintHeader(false);
$tcPdf->setPrintFooter(false);

// Add page, don't break page automatically
$tcPdf->AddPage();
$tcPdf->SetAutoPageBreak(false);

// Insert a dummy invoice text, not part of the payment slip itself
$tcPdf->SetFont('Arial','',9);
$tcPdf->Cell(50, 4, "Just some dummy text.");

// Create a payment slip data container (value object)
$paymentSlipData = new SwissPaymentSlipData();

// Fill the data container with your data
$paymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
$paymentSlipData->setAccountNumber('01-145-6');
$paymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$paymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$paymentSlipData->setAmount(2830.50);
$paymentSlipData->setReferenceNumber('7520033455900012');
$paymentSlipData->setBankingCustomerId('215703');

// Create a payment slip object, pass in the prepared data container
$paymentSlip = new SwissPaymentSlip($paymentSlipData, 0, 191);

// Since we currently don't have a OCRB font for TCPDF, we set it to one we certainly have
$paymentSlip->setCodeLineAttr(null, null, null, null, null, 'Helvetica');

// Create an instance of the TCPDF implementation, can be used for TCPDF, too
$paymentSlipTcpdf = new SwissPaymentSlipTcpdf($tcPdf, $paymentSlip);

// "Print" the slip with its elements according to their attributes
$paymentSlipTcpdf->createPaymentSlip();

// Output PDF named example_tcpdf_orange_slip.pdf to examples folder
$tcPdf->Output(__DIR__ . DIRECTORY_SEPARATOR . 'example_tcpdf_orange_slip.pdf', 'F');

echo "Payment slip created in " . __DIR__ . DIRECTORY_SEPARATOR . 'example_tcpdf_orange_slip.pdf <br>';

echo "<br>";

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>