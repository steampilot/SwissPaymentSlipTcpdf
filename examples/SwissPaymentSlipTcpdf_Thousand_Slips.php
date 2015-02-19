<?php
/**
 * Swiss Payment Slip TCPDF
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Marc Würth ravage@bluewin.ch
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @link https://github.com/ravage84/SwissPaymentSlipTcpdf/
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SwissPaymentSlipTcpdf Example 03: Create one thousand orange payment slips</title>
</head>
<body>
<h1>SwissPaymentSlipTcpdf Example 03: Create one thousand orange payment slips</h1>
<?php
// Measure script execution/generating time
$time_start = microtime(true);

// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Import necessary classes
use SwissPaymentSlip\SwissPaymentSlip\PaymentSlipData;
use SwissPaymentSlip\SwissPaymentSlip\PaymentSlip;
use SwissPaymentSlip\SwissPaymentSlipTcpdf\PaymentSlipTcpdf;

// Make sure TCPDF has access to the additional fonts
define('TCPDF_FONTPATH', __DIR__.'/../src/SwissPaymentSlip/SwissPaymentSlipPdf/Resources/font');

// Create an instance of TCPDF, setup default settings
$tcPdf = new TCPDF('P', 'mm', 'A4', true, 'ISO-8859-1');

// Since we currently don't have a OCRB font for TCPDF, we disable this
//$tcPdf->AddFont('OCRB10');

// Disable TCPDF's default behaviour of print header and footer
$tcPdf->setPrintHeader(false);
$tcPdf->setPrintFooter(false);

// create 1000 payment slips
for ($slipNr = 1; $slipNr <= 1000; $slipNr++) {
    // Add page, don't break page automatically
    $tcPdf->AddPage();
    $tcPdf->SetAutoPageBreak(false);

    // Insert a dummy invoice text, not part of the payment slip itself
    $tcPdf->SetFont('Helvetica', '', 9);
    $tcPdf->Cell(50, 4, "Just some dummy text.");

    // Create an payment slip data container (value object)
    $paymentSlipData = new PaymentSlipData(); // for better performance, take outside of the loop

    // Fill the data container with your data
    $paymentSlipData->setBankData('Seldwyla Bank', '8001 Zürich');
    $paymentSlipData->setAccountNumber('01-145-6');
    $paymentSlipData->setRecipientData('H. Muster AG', 'Versandhaus', 'Industriestrasse 88', '8000 Zürich');
    $paymentSlipData->setPayerData('Rutschmann Pia', 'Marktgasse 28', '9400 Rorschach', 'Slip # ' . $slipNr);
    $paymentSlipData->setAmount(2830.50);
    $paymentSlipData->setReferenceNumber('7520033455900012');
    $paymentSlipData->setBankingCustomerId('215703');

    // Create an payment slip object, pass in the prepared data container
    $paymentSlip = new PaymentSlip($paymentSlipData, 0, 191); // for better performance, take outside of the loop

    // Since we currently don't have a OCRB font for TCPDF, we set it to one we certainly have
    $paymentSlip->setCodeLineAttr(null, null, null, null, null, 'Helvetica');

    // Create an instance of the TCPDF implementation, can be used for TCPDF, too
    $paymentSlipTcpdf = new PaymentSlipTcpdf($tcPdf, $paymentSlip); // for better performance, take outside of the loop

    // "Print" the slip with its elements according to their attributes
    $paymentSlipTcpdf->createPaymentSlip();
}

// Output PDF named example_tcpdf_thousand_slips.pdf to examples folder
$pdfName = 'example_tcpdf_thousand_slips.pdf';
$pdfPath = __DIR__ . DIRECTORY_SEPARATOR . $pdfName;
$tcPdf->Output($pdfPath, 'F');

echo sprintf('Payment slips created in <a href="%s">%s</a><br>', $pdfName, $pdfPath);

echo "<br>";

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>
