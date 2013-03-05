<?php
/**
 * Example of SwissInpaymentSlipFpdf red slip
 *
 * PHP version >= 5.3.0
 *
 * @licence MIT
 * @copyright 2012-2013 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 * @version: 0.0.1
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SwissInpaymentSlip Example 03-02: SwissInpaymentSlipFpdf red slip</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 03-02: SwissInpaymentSlipFpdf red slip</h1>
<?php
// Measure script execution/generating time
$time_start = microtime(true);

// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes
use Gridonic\ESR\SwissInpaymentSlipData;
use Gridonic\ESR\SwissInpaymentSlip;
use Gridonic\ESR\SwissInpaymentSlipFpdf;
use fpdf\FPDF;

// Make sure FPDF has access to the additional fonts
define('FPDF_FONTPATH', __DIR__.'/../src/Gridonic/ESR/Resources/font');

// Create an instance of FPDF, setup default settings
$fPdf = new FPDF('P','mm','A4');

// Add OCRB font to FPDF
$fPdf->AddFont('OCRB10');

// Add page, don't break page automatically
$fPdf->AddPage();
$fPdf->SetAutoPageBreak(false);

// Insert a dummy invoice text, not part of the inpayment slip itself
$fPdf->SetFont('Helvetica','',9);
$fPdf->Cell(50, 4, "Just some dummy text.");

// Create an inpayment slip data container (value object)
$inpaymentSlipData = new SwissInpaymentSlipData('red');

// Fill the data container with your data
$inpaymentSlipData->setBankData('Seldwyla Bank', '8021 Zuerich');
$inpaymentSlipData->setAccountNumber('80-939-3');
$inpaymentSlipData->setRecipientData('Muster AG', 'Bahnhofstrasse 5', '8001 Zuerich');
$inpaymentSlipData->setIban('CH3808888123456789012');
$inpaymentSlipData->setPayerData('M. Beispieler', 'Bahnhofstrasse 356', '', '7000 Chur');
$inpaymentSlipData->setAmount(8479.25);
$inpaymentSlipData->setPaymentReason('Rechnung', 'Nr.7496');

// Create an inpayment slip object, pass in the prepared data container
$inpaymentSlip = new SwissInpaymentSlip($inpaymentSlipData, 0, 191);

// Create an instance of the FPDF implementation
$inpaymentSlipFpdf = new SwissInpaymentSlipFpdf($fPdf, $inpaymentSlip);

// "Print" the slip with its elements according to their attributes
$inpaymentSlipFpdf->createInpaymentSlip();

// Output PDF named example_03-02.pdf to examples folder
$fPdf->Output(__DIR__ . DIRECTORY_SEPARATOR . 'example_03-02.pdf', 'F');

echo "Inpayment slip created in " . __DIR__ . DIRECTORY_SEPARATOR . 'example_03-02.pdf <br>';

echo "<br>";

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>