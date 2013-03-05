<?php
/**
 * Example of SwissInpaymentSlip basic usage
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
	<title>SwissInpaymentSlip Example 02-01: SwissInpaymentSlip basic usage</title>
</head>
<body>
<h1>SwissInpaymentSlip Example 02-01: SwissInpaymentSlip basic usage</h1>
<?php
// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes
use Gridonic\ESR\SwissInpaymentSlipData;
use Gridonic\ESR\SwissInpaymentSlip;

// Create an inpayment slip data container (value object)
$inpaymentSlipData = new SwissInpaymentSlipData();

// Fill the data container with your data
$inpaymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
$inpaymentSlipData->setAccountNumber('01-145-6');
$inpaymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
$inpaymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach');
$inpaymentSlipData->setAmount(2830.50);
$inpaymentSlipData->setReferenceNumber('7520033455900012');
$inpaymentSlipData->setBankingCustomerId('215703');

// Create an inpayment slip object, pass in the prepared data container
$inpaymentSlip = new SwissInpaymentSlip($inpaymentSlipData);

// Get all elements (data fields with layout configuration)
$elements = $inpaymentSlip->getAllElements();

// Iterate through the elements (its lines and attributes)
foreach($elements as $elementName => $element) {
	echo "<h2>Element: " . $elementName . "</h2>";
	foreach ($element['lines'] as $lineNr => $line) {
		echo "-- Line " . $lineNr . ": " . $line . " <br>";
	}
	echo "<br>";
	foreach ($element['attributes'] as $lineNr => $line) {
		echo "-- Attribute " . $lineNr . ": " . $line . " <br>";
	}
}

echo "<br>";

// Dump object to screen
echo "This is how your slip object looks now: <br>";
var_dump($inpaymentSlip);
?>
</body>
</html>