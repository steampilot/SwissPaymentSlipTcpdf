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

// TODO Explain
require __DIR__.'/../vendor/autoload.php';

use Gridonic\ESR\SwissInpaymentSlip;

for ($slipNr = 1; $slipNr <= 1000; $slipNr++) {
	$inpaymentSlip[$slipNr] = new SwissInpaymentSlip();

	$inpaymentSlip[$slipNr]->setBankData('Seldwyla Bank', '8001 Zürich');
	$inpaymentSlip[$slipNr]->setAccountNumber('01-145-6');
	$inpaymentSlip[$slipNr]->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
	$inpaymentSlip[$slipNr]->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
	$inpaymentSlip[$slipNr]->setAmount(2830.50);
	$inpaymentSlip[$slipNr]->setReferenceNumber('7520033455900012');
	$inpaymentSlip[$slipNr]->setBankingCustomerId('215703');
}

echo memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>