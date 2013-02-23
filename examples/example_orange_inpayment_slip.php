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

use Gridonic\ESR\SwissInpaymentSlip;
use Gridonic\ESR\SwissInpaymentSlipPdf;
use fpdf\FPDF;

$fpdf = new FPDF('P','mm','A4');

$inpaymentSlip = new SwissInpaymentSlip();

// normal tests

$inpaymentSlip->setBankData('Berner Kantonalbank', '3001 Bern');
print_r('getType ' . $inpaymentSlip->getType() . '<br>');
print_r('bankName ' . $inpaymentSlip->getbankName() . '<br>');
print_r('bankCity ' . $inpaymentSlip->getbankCity() . '<br>');
print_r('accountNumber ' . $inpaymentSlip->getAccountNumber() . '<br>');

$inpaymentSlip->setAccountNumber('01-2345-6');
print_r('accountNumber ' . $inpaymentSlip->getAccountNumber() . '<br>');

$inpaymentSlip->setRecipientData('ORCA Services AG', 'Bahnhofstrasse 11', '4133 Pratteln');
print_r('recipientLine1 ' . $inpaymentSlip->getRecipientLine1() . '<br>');
print_r('recipientLine2 ' . $inpaymentSlip->getRecipientLine2() . '<br>');
print_r('recipientLine3 ' . $inpaymentSlip->getRecipientLine3() . '<br>');
print_r('recipientLine4 ' . $inpaymentSlip->getRecipientLine4() . '<br>');

$inpaymentSlip->setPayerData('Marc Würth', 'Muttenzerstrasse 82', '4133 Pratteln');
print_r('payerLine1 ' . $inpaymentSlip->getPayerLine1() . '<br>');
print_r('payerLine2 ' . $inpaymentSlip->getPayerLine2() . '<br>');
print_r('payerLine3 ' . $inpaymentSlip->getPayerLine3() . '<br>');
print_r('payerLine4 ' . $inpaymentSlip->getPayerLine4() . '<br>');

$inpaymentSlip->setAmount(105.38);
print_r('amount ' . $inpaymentSlip->getAmount() . '<br>');
print_r('Francs ' . $inpaymentSlip->getAmountFrancs() . '<br>');
print_r('Cents ' . $inpaymentSlip->getAmountCents() . '<br>');

$inpaymentSlip->setReferenceNumber('1234567890');
$inpaymentSlip->setBankingCustomerId('99999');
print_r('referenceNumber  ' . $inpaymentSlip->getReferenceNumber() . '<br>');
print_r('bankingCustomerId  ' . $inpaymentSlip->getBankingCustomerId() . '<br>');
print_r('completeReferenceNumber  ' . $inpaymentSlip->getCompleteReferenceNumber() . '<br>');

$inpaymentSlip->setIban('1234567890123456789');
print_r('iban  ' . $inpaymentSlip->getIban() . '<br>');

$inpaymentSlip->setPaymentReason('This', 'Is', 'A', 'Reason');
print_r('paymentReasonLine1  ' . $inpaymentSlip->getPaymentReasonLine1() . '<br>');
print_r('paymentReasonLine2  ' . $inpaymentSlip->getPaymentReasonLine2() . '<br>');
print_r('paymentReasonLine3  ' . $inpaymentSlip->getPaymentReasonLine3() . '<br>');
print_r('paymentReasonLine4  ' . $inpaymentSlip->getPaymentReasonLine4() . '<br>');

print_r('codeLine  ' . $inpaymentSlip->getCodeLine() . '<br>');

var_dump($inpaymentSlip);

// disabling tests

$inpaymentSlip->setWithAccountNumber(false);
print_r('accountNumber ' . $inpaymentSlip->getAccountNumber() . '<br>');

$inpaymentSlip->setWithBank(false);
print_r('bankName ' . $inpaymentSlip->getbankName() . '<br>');
print_r('bankCity ' . $inpaymentSlip->getbankCity() . '<br>');

$inpaymentSlip->setWithRecipient(false);

print_r('recipientLine1 ' . $inpaymentSlip->getRecipientLine1() . '<br>');
print_r('recipientLine2 ' . $inpaymentSlip->getRecipientLine2() . '<br>');
print_r('recipientLine3 ' . $inpaymentSlip->getRecipientLine3() . '<br>');
print_r('recipientLine4 ' . $inpaymentSlip->getRecipientLine4() . '<br>');

$inpaymentSlip->setWithPayer(false);

print_r('payerLine1 ' . $inpaymentSlip->getPayerLine1() . '<br>');
print_r('payerLine2 ' . $inpaymentSlip->getPayerLine2() . '<br>');
print_r('payerLine3 ' . $inpaymentSlip->getPayerLine3() . '<br>');
print_r('payerLine4 ' . $inpaymentSlip->getPayerLine4() . '<br>');

$inpaymentSlip->setWithAmount(false);

print_r('amount ' . $inpaymentSlip->getAmount() . '<br>');

$inpaymentSlip->setWithReferenceNumber(false);
print_r('referenceNumber  ' . $inpaymentSlip->getReferenceNumber() . '<br>');

var_dump($inpaymentSlip);

/*
$inpaymentSlip = new SwissInpaymentSlip('green');

var_dump($inpaymentSlip);

print_r('getType ' . $inpaymentSlip->getType() . '<br>');
print_r('setType ' . $inpaymentSlip->setType('juhui') . '<br>');
print_r('getType ' . $inpaymentSlip->getType() . '<br>');
print_r('setType ' . $inpaymentSlip->setType('red') . '<br>');
print_r('getType ' . $inpaymentSlip->getType() . '<br>');

print_r('getWithAmount ' . $inpaymentSlip->getWithAmount() . '<br>');
print_r('setWithAmount ' . $inpaymentSlip->setWithAmount(false) . '<br>');
print_r('getWithAmount ' . $inpaymentSlip->getWithAmount() . '<br>');
print_r('setWithAmount ' . $inpaymentSlip->setWithAmount('yes') . '<br>');
print_r('getWithAmount ' . $inpaymentSlip->getWithAmount() . '<br>');

print_r('getWithBank ' . $inpaymentSlip->getWithBank() . '<br>');
print_r('setWithBank ' . $inpaymentSlip->setWithBank(false) . '<br>');
print_r('getWithBank ' . $inpaymentSlip->getWithBank() . '<br>');
print_r('setWithBank ' . $inpaymentSlip->setWithBank('yes') . '<br>');
print_r('getWithBank ' . $inpaymentSlip->getWithBank() . '<br>');

print_r('getWithRecipient ' . $inpaymentSlip->getWithRecipient() . '<br>');
print_r('setWithRecipient ' . $inpaymentSlip->setWithRecipient(false) . '<br>');
print_r('getWithRecipient ' . $inpaymentSlip->getWithRecipient() . '<br>');
print_r('setWithRecipient ' . $inpaymentSlip->setWithRecipient('yes') . '<br>');
print_r('getWithRecipient ' . $inpaymentSlip->getWithRecipient() . '<br>');

var_dump($inpaymentSlip);

$inpaymentSlipPdf = new SwissInpaymentSlipPdf($fpdf, $inpaymentSlip, 10, 10);

var_dump($inpaymentSlipPdf);
*/
?>
</body>
</html>