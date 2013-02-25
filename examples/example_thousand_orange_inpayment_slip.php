<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php
/**
 * Example for creating thousand orange Swiss inpayment slips
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
$time_start = microtime(true);

// TODO Explain
require __DIR__.'/../vendor/autoload.php';

define('FPDF_FONTPATH', __DIR__.'/../src/Gridonic/ESR/Resources/font');

use Gridonic\ESR\SwissInpaymentSlip;
use Gridonic\ESR\SwissInpaymentSlipData;
use Gridonic\ESR\SwissInpaymentSlipFpdf;
use fpdf\FPDF;

// setup FPDF, add OCRB
$fPdf = new FPDF('P','mm','A4');
$fPdf->AddFont('OCRB10');

// setup objects
$inpaymentSlip = new SwissInpaymentSlip();
$inpaymentSlipData = $inpaymentSlip->getSlipData();
$inpaymentSlipFpdf = new SwissInpaymentSlipFpdf($fPdf, $inpaymentSlip);

// create 1000 fake inpayment slips on 500 pages
for ($slipNr = 1; $slipNr <= 1000; $slipNr++) {
	// create new page
	$fPdf->AddPage();
	$fPdf->SetAutoPageBreak(false);

	// set position of top inpayment slip
	$inpaymentSlip->setSlipPosition(0, 0);

	// pretend to fill top inpayment slip's data
	$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
	$inpaymentSlipData->setAccountNumber('01-145-6');
	$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
	$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach', 'EZ: ' . $slipNr);
	$inpaymentSlipData->setAmount(2830.50);
	$inpaymentSlipData->setReferenceNumber('7520033455900012');
	$inpaymentSlipData->setBankingCustomerId('215703');

	// create bottom inpayment slip
	$inpaymentSlipFpdf->createInpaymentSlip();

	// pretend to fill bottom inpayment slip's data
	$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
	$inpaymentSlipData->setAccountNumber('01-145-6');
	$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
	$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach', 'EZ: ' . $slipNr);
	$inpaymentSlipData->setAmount(2830.50);
	$inpaymentSlipData->setReferenceNumber('7520033455900012');
	$inpaymentSlipData->setBankingCustomerId('215703');

	// set position of bottom inpayment slip
	$inpaymentSlip->setSlipPosition(0, 191);

	// create bottom inpayment slip
	$inpaymentSlipFpdf->createInpaymentSlip();
}

$fPdf->Output('d:\test.pdf', 'F');

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>