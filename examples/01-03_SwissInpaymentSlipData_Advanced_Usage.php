<?php
/**
 * Example of SwissInpaymentSlipData advanced usage
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
	<title>SwissInpaymentSlip Example 01-03: SwissInpaymentSlipData advanced usage</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 01-03: SwissInpaymentSlipData advanced usage</h1>
<?php
// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes 
use Gridonic\ESR\SwissInpaymentSlipData;

// Create an inpayment slip data container (value object)
$inpaymentSlipData = new SwissInpaymentSlipData('red');

// Fill some red slip data
$inpaymentSlipData->setIban('CH3808888123456789012');
$inpaymentSlipData->setPaymentReasonData('Rechnung', 'Nr.7496');

// Change type and (optionally) force data reset
$inpaymentSlipData->setType('orange');

// We don't want to use the banking customer ID as part of the reference number
$inpaymentSlipData->setWithBankingCustomerId(false);

// We use preprinted slips, we don't need bank and recipient
$inpaymentSlipData->setWithBank(false);
$inpaymentSlipData->setWithRecipient(false);

// If we don't want to contain the amount, e.g. a "not of inpayment" slip
$inpaymentSlipData->setWithAmount(false);

// Setup some more behaviours, normally optionally since they already default to appropriate setting
$inpaymentSlipData->setWithAccountNumber(true);
$inpaymentSlipData->setWithReferenceNumber(true);
$inpaymentSlipData->setWithPayer(true);
$inpaymentSlipData->setWithIban(true); // TODO Not fully implemented
$inpaymentSlipData->setWithPaymentReason(true); // Doesn't work for orange slips

// Fill the data container with your data
$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich'); // This won't work, because it's disabled
$inpaymentSlipData->setAccountNumber('01-145-6');
$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich'); // This won't work, because it's disabled
$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlipData->setAmount(2830.50); // This won't work, because it's disabled
$inpaymentSlipData->setReferenceNumber('7520033455900012');
$inpaymentSlipData->setBankingCustomerId('215703'); // This won't work, because it's disabled

// Output the data fields of the slip
echo "Bank name: " . $inpaymentSlipData->getBankName() . "<br>"; // Empty, because it's disabled
echo "Bank city: " . $inpaymentSlipData->getBankCity() . "<br>"; // Empty, because it's disabled
echo "<br>";
echo "Recipient line 1: " . $inpaymentSlipData->getRecipientLine1() . "<br>"; // Empty, because it's disabled
echo "Recipient line 2: " . $inpaymentSlipData->getRecipientLine2() . "<br>"; // Empty, because it's disabled
echo "Recipient line 3: " . $inpaymentSlipData->getRecipientLine3() . "<br>"; // Empty, because it's disabled
echo "Recipient line 4: " . $inpaymentSlipData->getRecipientLine4() . "<br>"; // Empty, because it's disabled
echo "<br>";
echo "Account number: " . $inpaymentSlipData->getAccountNumber() . "<br>";
echo "<br>";
echo "Amount: " . $inpaymentSlipData->getAmount() . "<br>"; // Empty, because it's disabled
echo "Amount in francs: " . $inpaymentSlipData->getAmountFrancs() . "<br>"; // Empty, because it's disabled
echo "Amount in cents: " . $inpaymentSlipData->getAmountCents() . "<br>"; // Empty, because it's disabled
echo "<br>";
echo "Payer line 1: " . $inpaymentSlipData->getPayerLine1() . "<br>";
echo "Payer line 2: " . $inpaymentSlipData->getPayerLine2() . "<br>";
echo "Payer line 3: " . $inpaymentSlipData->getPayerLine3() . "<br>";
echo "Payer line 4: " . $inpaymentSlipData->getPayerLine4() . "<br>";
echo "<br>";
echo "Banking customer ID: " . $inpaymentSlipData->getBankingCustomerId() . "<br>"; // Empty, because it's disabled
echo "<br>";
echo "Complete reference number (without banking customer ID): " . $inpaymentSlipData->getCompleteReferenceNumber() . "<br>";
echo "Complete reference number (ditto), unformatted : " . $inpaymentSlipData->getCompleteReferenceNumber(false) . "<br>";
echo "Complete reference number (ditto), not filled with zeroes : " . $inpaymentSlipData->getCompleteReferenceNumber(true, false) . "<br>";
echo "<br>";
echo "Code line (at the bottom): " . $inpaymentSlipData->getCodeLine() . "<br>";
echo "Code line (at the bottom), not filled with zeroes: " . $inpaymentSlipData->getCodeLine(false) . "<br>";
echo "<br>";
echo "IBAN: " . $inpaymentSlipData->getIban() . "<br>"; // Empty because reset
echo "Formatted IBAN: " . $inpaymentSlipData->getFormattedIban() . "<br>"; // Empty because reset
echo "<br>";
echo "Payment reason line 1: " . $inpaymentSlipData->getPaymentReasonLine1() . "<br>"; // Empty because reset
echo "Payment reason line 2: " . $inpaymentSlipData->getPaymentReasonLine2() . "<br>"; // Empty because reset
echo "Payment reason line 3: " . $inpaymentSlipData->getPaymentReasonLine3() . "<br>"; // Empty because reset
echo "Payment reason line 4: " . $inpaymentSlipData->getPaymentReasonLine4() . "<br>"; // Empty because reset
echo "<br>";

// Dump object to screen
echo "This is how your data container looks now: <br>";
var_dump($inpaymentSlipData);
?>
</body>
</html>