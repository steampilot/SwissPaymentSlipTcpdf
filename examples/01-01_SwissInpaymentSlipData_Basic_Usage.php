<?php
/**
 * Example of SwissInpaymentSlipData basic usage
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
	<title>SwissInpaymentSlip Example 01-01: SwissInpaymentSlipData basic usage</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 01-01: SwissInpaymentSlipData basic usage</h1>
<?php
// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes 
use Gridonic\ESR\SwissInpaymentSlipData;

// Create an inpayment slip data container (value object)
$inpaymentSlipData = new SwissInpaymentSlipData('orange'); // Parameter is optional for orange

// Fill the data container with your data
$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
$inpaymentSlipData->setAccountNumber('01-145-6');
$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlipData->setAmount(2830.50);
$inpaymentSlipData->setReferenceNumber('7520033455900012');
$inpaymentSlipData->setBankingCustomerId('215703');

// Output the data fields of the slip
echo "Bank name: " . $inpaymentSlipData->getBankName() . "<br>";
echo "Bank city: " . $inpaymentSlipData->getBankCity() . "<br>";
echo "<br>";
echo "Recipient line 1: " . $inpaymentSlipData->getRecipientLine1() . "<br>";
echo "Recipient line 2: " . $inpaymentSlipData->getRecipientLine2() . "<br>";
echo "Recipient line 3: " . $inpaymentSlipData->getRecipientLine3() . "<br>";
echo "Recipient line 4: " . $inpaymentSlipData->getRecipientLine4() . "<br>";
echo "<br>";
echo "Account number: " . $inpaymentSlipData->getAccountNumber() . "<br>";
echo "<br>";
echo "Amount: " . $inpaymentSlipData->getAmount() . "<br>";
echo "Amount in francs: " . $inpaymentSlipData->getAmountFrancs() . "<br>";
echo "Amount in cents: " . $inpaymentSlipData->getAmountCents() . "<br>";
echo "<br>";
echo "Payer line 1: " . $inpaymentSlipData->getPayerLine1() . "<br>";
echo "Payer line 2: " . $inpaymentSlipData->getPayerLine2() . "<br>";
echo "Payer line 3: " . $inpaymentSlipData->getPayerLine3() . "<br>";
echo "Payer line 4: " . $inpaymentSlipData->getPayerLine4() . "<br>";
echo "<br>";
echo "Banking customer ID: " . $inpaymentSlipData->getBankingCustomerId() . "<br>";
echo "<br>";
echo "Complete reference number (with banking customer ID): " . $inpaymentSlipData->getCompleteReferenceNumber() . "<br>";
echo "<br>";
echo "Code line (at the bottom): " . $inpaymentSlipData->getCodeLine() . "<br>";
echo "<br>";

// Dump object to screen
echo "This is how your data container looks now: <br>";
var_dump($inpaymentSlipData);
?>
</body>
</html>