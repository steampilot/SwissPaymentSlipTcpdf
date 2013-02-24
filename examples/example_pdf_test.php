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
use Gridonic\ESR\SwissInpaymentSlipPdf;
use fpdf\FPDF;

$fPdf = new FPDF('P','mm','A4');
$fPdf->AddFont('OCRB10');
$fPdf->AddPage();
$fPdf->SetAutoPageBreak(false);

$inpaymentSlip = new SwissInpaymentSlip();

$inpaymentSlip->setBankData('Seldwyla Bank', '8001 Zürich');
$inpaymentSlip->setAccountNumber('01-145-6');
$inpaymentSlip->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$inpaymentSlip->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlip->setAmount(2830.50);
$inpaymentSlip->setReferenceNumber('7520033455900012');
$inpaymentSlip->setBankingCustomerId('215703');

$inpaymentSlipPdf = new SwissInpaymentSlipPdf($fPdf, $inpaymentSlip, 0, 0);

//$inpaymentSlipPdf->setBankLeftAttr(10, 20, 100, 50, null, 'Helvetica', 11, '#123', 4, 'left');

$inpaymentSlipPdf->setBankLeftAttr(null, null, null, null, null, 'Helvetica');

$inpaymentSlipPdf->createInpaymentSlip();

$inpaymentSlipPdf->setSlipPosition(0, 191);

$inpaymentSlipPdf->createInpaymentSlip();

$fPdf->Output('d:\test.pdf', 'F');

var_dump($inpaymentSlipPdf);
?>
</body>
</html>