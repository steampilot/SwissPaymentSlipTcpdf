<?php
/**
 * Example of SwissInpaymentSlipFpdf Creating one thousand inpayment slips
 *
 * PHP version >= 5.3.0
 *
 * @licence MIT
 * @copyright 2012-2013 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 * @version: 0.4.0
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SwissInpaymentSlip Example 03-01: SwissInpaymentSlipFpdf Creating one thousand inpayment slips</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 03-01: SwissInpaymentSlipFpdf Creating one thousand inpayment slips</h1>
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

// create 1000 inpayment slips
for ($slipNr = 1; $slipNr <= 1000; $slipNr++) {
	// Add page, don't break page automatically
	$fPdf->AddPage();
	$fPdf->SetAutoPageBreak(false);

	// Insert a dummy invoice text, not part of the inpayment slip itself
	$fPdf->SetFont('Helvetica','',9);
	$fPdf->Cell(50, 4, "Just some dummy text.");

	// Create an inpayment slip data container (value object)
	$inpaymentSlipData = new SwissInpaymentSlipData(); // for better performance, take outside of the loop

	// Fill the data container with your data
	$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
	$inpaymentSlipData->setAccountNumber('01-145-6');
	$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
	$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach', 'Slip # ' . $slipNr);
	$inpaymentSlipData->setAmount(2830.50);
	$inpaymentSlipData->setReferenceNumber('7520033455900012');
	$inpaymentSlipData->setBankingCustomerId('215703');

	// Create an inpayment slip object, pass in the prepared data container
	$inpaymentSlip = new SwissInpaymentSlip($inpaymentSlipData, 0, 191); // for better performance, take outside of the loop

	// Create an instance of the FPDF implementation
	$inpaymentSlipFpdf = new SwissInpaymentSlipFpdf($fPdf, $inpaymentSlip); // for better performance, take outside of the loop

	// "Print" the slip with its elements according to their attributes
	$inpaymentSlipFpdf->createInpaymentSlip();
}

// Output PDF named example_03-03.pdf to examples folder
$fPdf->Output(__DIR__ . DIRECTORY_SEPARATOR . 'example_03-03.pdf', 'F');

echo "Inpayment slip created in " . __DIR__ . DIRECTORY_SEPARATOR . 'example_03-03.pdf <br>';

echo "<br>";

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>