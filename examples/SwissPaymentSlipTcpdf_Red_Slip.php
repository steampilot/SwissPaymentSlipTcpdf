<?php
/**
 * Swiss Payment Slip TCPDF
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Marc Würth <ravage@bluewin.ch>
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @link https://github.com/ravage84/SwissPaymentSlipTcpdf/
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SwissPaymentSlipTcpdf Example 02: Create a red payment slip</title>
</head>
<body>
<h1>SwissPaymentSlipTcpdf Example 02: Create a red payment slip</h1>
<?php
// Measure script execution/generating time
$time_start = microtime(true);

// Make sure the classes get auto-loaded
require __DIR__ . '/../vendor/autoload.php';

// Import necessary classes
use SwissPaymentSlip\SwissPaymentSlip\RedPaymentSlipData;
use SwissPaymentSlip\SwissPaymentSlip\RedPaymentSlip;
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

// Add page, don't break page automatically
$tcPdf->AddPage();
$tcPdf->SetAutoPageBreak(false);

// Insert a dummy invoice text, not part of the payment slip itself
$tcPdf->SetFont('Helvetica', '', 9);
$tcPdf->Cell(50, 4, "Just some dummy text.");

// Create an payment slip data container (value object)
$paymentSlipData = new RedPaymentSlipData();

// Fill the data container with your data
$paymentSlipData->setBankData('Seldwyla Bank', '8021 Zürich');
$paymentSlipData->setAccountNumber('80-939-3');
$paymentSlipData->setRecipientData('Muster AG', 'Bahnhofstrasse 5', '8001 Zürich');
$paymentSlipData->setIban('CH3808888123456789012');
$paymentSlipData->setPayerData('M. Beispieler', 'Bahnhofstrasse 356', '', '7000 Chur');
$paymentSlipData->setAmount(8479.25);
$paymentSlipData->setPaymentReasonData('Rechnung', 'Nr.7496');

// Create a payment slip object, pass in the prepared data container
$paymentSlip = new RedPaymentSlip($paymentSlipData, 0, 191);

// Create an instance of the TCPDF implementation
$paymentSlipTcpdf = new PaymentSlipTcpdf($tcPdf);

// "Print" the slip with its elements according to their attributes
$paymentSlipTcpdf->createPaymentSlip($paymentSlip);

// Output PDF named example_tcpdf_red_slip.pdf to examples folder
$pdfName = 'example_tcpdf_red_slip.pdf';
$pdfPath = __DIR__ . DIRECTORY_SEPARATOR . $pdfName;
$tcPdf->Output($pdfPath, 'F');

echo sprintf('Payment slip created in <a href="%s">%s</a><br>', $pdfName, $pdfPath);

echo "<br>";

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Generation took $time seconds <br>";
echo 'Peak memory usage: ' . memory_get_peak_usage() / 1024 / 1024;
?>
</body>
</html>
