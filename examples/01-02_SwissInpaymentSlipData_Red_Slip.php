<?php
/**
 * Example of SwissInpaymentSlipData red slip
 *
 * PHP version >= 5.3.0
 *
 * @licence MIT
 * @copyright 2012-2013 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 * @version: 0.2.0
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SwissInpaymentSlip Example 01-02: SwissInpaymentSlipData red slip</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 01-02: SwissInpaymentSlipData red slip</h1>
<?php
// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes 
use Gridonic\ESR\SwissInpaymentSlipData;

// Create an inpayment slip data container (value object)
$inpaymentSlipData = new SwissInpaymentSlipData('red');

// Fill the data container with your data
$inpaymentSlipData->setBankData('Seldwyla Bank', '8021 Zuerich');
$inpaymentSlipData->setAccountNumber('80-939-3');
$inpaymentSlipData->setRecipientData('Muster AG', 'Bahnhofstrasse 5', '8001 Zuerich');
$inpaymentSlipData->setIban('CH3808888123456789012');
$inpaymentSlipData->setPayerData('M. Beispieler', 'Bahnhofstrasse 356', '', '7000 Chur');
$inpaymentSlipData->setAmount(8479.25);
$inpaymentSlipData->setPaymentReasonData('Rechnung', 'Nr.7496');

// Output the data fields of the slip
echo "Bank name: " . $inpaymentSlipData->getBankName() . "<br>";
echo "Bank city: " . $inpaymentSlipData->getBankCity() . "<br>";
echo "<br>";
echo "Recipient line 1: " . $inpaymentSlipData->getRecipientLine1() . "<br>";
echo "Recipient line 2: " . $inpaymentSlipData->getRecipientLine2() . "<br>";
echo "Recipient line 3: " . $inpaymentSlipData->getRecipientLine3() . "<br>";
echo "Recipient line 4: " . $inpaymentSlipData->getRecipientLine4() . "<br>";
echo "<br>";
echo "IBAN: " . $inpaymentSlipData->getIban() . "<br>";
echo "Formatted IBAN: " . $inpaymentSlipData->getFormattedIban() . "<br>";
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
echo "Payment reason line 1: " . $inpaymentSlipData->getPaymentReasonLine1() . "<br>";
echo "Payment reason line 2: " . $inpaymentSlipData->getPaymentReasonLine2() . "<br>";
echo "Payment reason line 3: " . $inpaymentSlipData->getPaymentReasonLine3() . "<br>";
echo "Payment reason line 4: " . $inpaymentSlipData->getPaymentReasonLine4() . "<br>";
echo "<br>";
echo "Code line (at the bottom): " . $inpaymentSlipData->getCodeLine() . "<br>";
echo "Second code line (at the bottom): " . $inpaymentSlipData->getCodeLine() . "<br>"; // TODO To be implemented method
echo "<br>";

// Dump object to screen
echo "This is how your data container looks now: <br>";
var_dump($inpaymentSlipData);
?>
</body>
</html>