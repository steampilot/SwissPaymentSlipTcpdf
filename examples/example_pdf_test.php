<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php
/**
 * Example for creating an orange Swiss inpayment slip
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

// TODO Explain
require __DIR__.'/../vendor/autoload.php';
define('FPDF_FONTPATH', __DIR__.'/../src/Gridonic/ESR/Resources/font');

use Gridonic\ESR\SwissInpaymentSlip;
use Gridonic\ESR\SwissInpaymentSlipData;
use Gridonic\ESR\SwissInpaymentSlipFpdf;
use fpdf\FPDF;

$fPdf = new FPDF('P','mm','A4');
$fPdf->AddFont('OCRB10');
$fPdf->AddPage();
$fPdf->SetAutoPageBreak(false);

$inpaymentSlip = new SwissInpaymentSlip(0, 0);

$inpaymentSlipData = $inpaymentSlip->getSlipData();

$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
$inpaymentSlipData->setAccountNumber('01-145-6');
$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlipData->setAmount(2830.50);
$inpaymentSlipData->setReferenceNumber('7520033455900012');
$inpaymentSlipData->setBankingCustomerId('215703');

//var_dump($inpaymentSlip);

$inpaymentSlip->setBankLeftAttr(null, null, null, null, null, 'Helvetica');

$inpaymentSlipFpdf = new SwissInpaymentSlipFpdf($fPdf, $inpaymentSlip);

$inpaymentSlipFpdf->createInpaymentSlip();

$inpaymentSlip->setSlipPosition(0, 191);

$inpaymentSlipFpdf->createInpaymentSlip();

/*
var_dump($inpaymentSlip);

$inpaymentSlip->setSlipPosition(0, 191);

var_dump($inpaymentSlip);

$inpaymentSlip->createInpaymentSlip(false);
*/
$fPdf->Output(__DIR__ . DIRECTORY_SEPARATOR . 'test.pdf', 'F');

//var_dump($inpaymentSlip);

echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024 . '<br>';
?>
</body>
</html>