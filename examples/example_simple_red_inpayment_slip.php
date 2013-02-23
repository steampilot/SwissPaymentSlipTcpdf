<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php
/**
 * Example for creating a red Swiss inpayment slip
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

use Gridonic\ESR\SwissInpaymentSlip;
use Gridonic\ESR\SwissInpaymentSlipPdf;
use fpdf\FPDF;

$fpdf = new FPDF('P','mm','A4');

$inpaymentSlip = new SwissInpaymentSlip('red');

$inpaymentSlip->setBankData('Seldwyla Bank', '8001 Zürich');
$inpaymentSlip->setAccountNumber('01-145-6');
$inpaymentSlip->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$inpaymentSlip->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlip->setAmount(2830.50);
$inpaymentSlip->setIban('CH226465464646464654646');
$inpaymentSlip->setPaymentReason('Rechnung', '4646', 'Hr. Müller');

var_dump($inpaymentSlip);

?>
</body>
</html>