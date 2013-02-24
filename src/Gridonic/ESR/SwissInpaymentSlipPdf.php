<?php
/**
 * Swiss Inpayment Slip as PDF
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

namespace Gridonic\ESR;

// TODO include CHF boxed slip image (609, ESR+)
// TODO include EUR framed slip image (701) --> back side!
// TODO include EUR boxed slip image (701) --> back side!
// TODO implement notForInpaying (XXXX.XX)
// TODO implement cash on delivery (Nachnahme)
// TODO include cash on delivery (Nachnahme) slip image
// TODO create constants for the attribute keys
// TODO create constants for left, right and center text alignment (L, R, C)
// TODO create central cell placement and formatting code (lines as array, attributes)...
// TODO code cleanup
// TODO create tests, what's possible (getter and setter, setter without getters testable?
// TODO docblocks
// TODO class docblock
// TODO test docs generated

class SwissInpaymentSlipPdf
{

	/**
	 * The FPDF engine object to generate the PDF output
	 *
	 * @var object The FPDF engine object
	 */
	private $fPdf = null;

	/**
	 * The inpayment slip object, which contains the inpayment slip data
	 *
	 * @var object The inpayment slip object
	 */
	private $inpaymentSlip = null;

	/**
	 * Starting X position of the slip
	 *
	 * @var int Starting X position of the slip in mm
	 */
	private $slipPosX = 0;

	/**
	 * Starting Y position of the slip
	 *
	 * @var int Starting Y position of the slip in mm
	 */
	private $slipPosY = 0;

	private $slipHeight = 0; // TODO how much?

	private $slipWidth = 0; // TODO how much, A4 width?

	/**
	 * Background of the slip
	 *
	 * Can be either transparent, a color or image
	 *
	 * @var null
	 */
	private $slipBackground = null;

	private $defaultFontFamily = 'Arial';

	private $defaultFontSize = '10';

	private $defaultFontColor = '#000';

	private $defaultLineHeight = 4;

	private $defaultTextAlign = 'L';

	/**
	 * Determines if the bank details should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayBank = true;

	/**
	 * Determines if the recipient details should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayRecipient = true;

	/**
	 * Determines if the account should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayAccount = true;

	/**
	 * Determines if the amount should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayAmount = true;

	/**
	 * Determines if the reference number should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayReferenceNr = true;

	/**
	 * Determines if the payer details should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayPayer = true;

	/**
	 * Determines if the IBAN should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayIban = false;

	/**
	 * Determines if the payment reason should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayPaymentReason = false;

	private $bankLeftAttr = array();
	private $bankRightAttr = array();
	private $recipientLeftAttr = array();
	private $recipientRightAttr = array();
	private $accountLeftAttr = array();
	private $accountRightAttr = array();
	private $amountFrancsLeftAttr = array();
	private $amountFrancsRightAttr = array();
	private $amountCentsLeftAttr = array();
	private $amountCentsRightAttr = array();
	private $referenceNumberLeftAttr = array();
	private $referenceNumberRightAttr = array();
	private $payerLeftAttr = array();
	private $payerRightAttr = array();
	private $codeLineAttr = array();

	public function __construct($fPdf, $inpaymentSlip, $slipPosX = 0, $slipPosY = 0)
	{
		if (is_object($fPdf)) {
			$this->fPdf = $fPdf;
		} else {
			// throw error
		}
		if (is_object($inpaymentSlip)) {
			$this->inpaymentSlip = $inpaymentSlip;
		} else {
			// throw error
		}
		if (!$this->setSlipPosX($slipPosX)) {
			// throw error
		}
		if (!$this->setSlipPosY($slipPosY)) {
			// throw error
		}

		$this->setBankLeftAttr(3, 8, 50, 4);
		$this->setBankRightAttr(66, 8, 50, 4);
		$this->setRecipientLeftAttr(3, 23, 50, 4);
		$this->setRecipientRightAttr(66, 23, 50, 4);
		$this->setAccountLeftAttr(27, 43, 30, 4);
		$this->setAccountRightAttr(90, 43, 30, 4);
		$this->setAmountFrancsLeftAttr(5, 50.5, 35, 4);
		$this->setAmountFrancsRightAttr(66, 50.5, 35, 4);
		$this->setAmountCentsLeftAttr(50, 50.5, 6, 4);
		$this->setAmountCentsRightAttr(111, 50.5, 6, 4);
		$this->setReferenceNumberLeftAttr(3, 60, 50, 4, null, null, 8);
		$this->setReferenceNumberRightAttr(125, 33.5, 80, 4);
		$this->setPayerLeftAttr(3, 65, 50, 4);
		$this->setPayerRightAttr(125, 48, 50, 4);
		$this->setCodeLineAttr(64, 85, 140, 4, null, 'OCRB10');
	}

	/**
	 * Set slip X & > position
	 *
	 * @param $slipPosX
	 * @param $slipPosY
	 * @return bool True if successful, else false
	 */
	public function setSlipPosition($slipPosX, $slipPosY)
	{
		if ($this->setSlipPosX($slipPosX) &&
			$this->setSlipPosY($slipPosY)) {
			return true;
		}
		return false;
	}

	private function setSlipPosX($slipPosX)
	{
		if (is_int($slipPosX)) {
			$this->slipPosX = $slipPosX;
			return true;
		}
		return false;
	}

	private function setSlipPosY($slipPosY)
	{
		if (is_int($slipPosY)) {
			$this->slipPosY = $slipPosY;
			return true;
		}
		return false;
	}

	private function setAttributes(&$attributes, $posX = null, $posY = null, $height = null, $width = null, $background = null,
								   $fontFamily = null, $fontSize = null, $fontColor = null,
								   $lineHeight = null, $textAlign = null) {
		if ($posX) {
			$attributes['PosX'] = $posX;
		} elseif (!isset($attributes['PosX'])) {
			$attributes['PosX'] = 0;
		}
		if ($posY) {
			$attributes['PosY'] = $posY;
		} elseif (!isset($attributes['PosY'])) {
			$attributes['PosY'] = 0;
		}
		if ($height) {
			$attributes['Height'] = $height;
		} elseif (!isset($attributes['Height'])) {
			$attributes['Height'] = 0;
		}
		if ($width) {
			$attributes['Width'] = $width;
		} elseif (!isset($attributes['Width'])) {
			$attributes['Width'] = 0;
		}
		if ($background) {
			$attributes['Background'] = $background;
		} elseif (!isset($attributes['Background'])) {
			$attributes['Background'] = 'transparent';
		}
		if ($fontFamily) {
			$attributes['FontFamily'] = $fontFamily;
		} elseif (!isset($attributes['FontFamily'])) {
			$attributes['FontFamily'] = $this->defaultFontFamily;
		}
		if ($fontSize) {
			$attributes['FontSize'] = $fontSize;
		} elseif (!isset($attributes['FontSize'])) {
			$attributes['FontSize'] = $this->defaultFontSize;
		}
		if ($fontColor) {
			$attributes['FontColor'] = $fontColor;
		} elseif (!isset($attributes['FontColor'])) {
			$attributes['FontColor'] = $this->defaultFontColor;
		}
		if ($lineHeight) {
			$attributes['LineHeight'] = $lineHeight;
		} elseif (!isset($attributes['LineHeight'])) {
			$attributes['LineHeight'] = $this->defaultLineHeight;
		}
		if ($textAlign) {
			$attributes['TextAlign'] = $textAlign;
		} elseif (!isset($attributes['TextAlign'])) {
			$attributes['TextAlign'] = $this->defaultTextAlign;
		}
		return true;

	}

	public function setBankLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->bankLeftAttr, $posX, $posY, $height, $width, $background, $fontFamily,
									$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setBankRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->bankRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setRecipientLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->recipientLeftAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setRecipientRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->recipientRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAccountLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->accountLeftAttr, $posX, $posY, $height, $width, $background,	$fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAccountRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->accountRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAmountFrancsLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		if (!$textAlign) {
			$textAlign = 'R';
		}

		return $this->setAttributes($this->amountFrancsLeftAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAmountFrancsRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		if (!$textAlign) {
			$textAlign = 'R';
		}

		return $this->setAttributes($this->amountFrancsRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAmountCentsLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->amountCentsLeftAttr, $posX, $posY, $height, $width, $background,	$fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setAmountCentsRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->amountCentsRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setReferenceNumberLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->referenceNumberLeftAttr, $posX, $posY, $height, $width, $background,	$fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setReferenceNumberRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		if (!$textAlign) {
			$textAlign = 'R';
		}

		return $this->setAttributes($this->referenceNumberRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setPayerLeftAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->payerLeftAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setPayerRightAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		return $this->setAttributes($this->payerRightAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	public function setCodeLineAttr($posX = null, $posY = null, $height = null, $width = null,
		$background = null,	$fontFamily = null, $fontSize = null, $fontColor = null,
		$lineHeight = null, $textAlign = null) {
		if (!$textAlign) {
			$textAlign = 'R';
		}

		return $this->setAttributes($this->codeLineAttr, $posX, $posY, $height, $width, $background, $fontFamily,
			$fontSize, $fontColor, $lineHeight, $textAlign);
	}

	/**
	 * Set whether or not to display the account
	 *
	 * @param bool $displayAccount True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayAccount($displayAccount = true)
	{
		if (is_bool($displayAccount)) {
			$this->displayAccount = $displayAccount;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the account
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayAccount()
	{
		return $this->displayAccount;
	}

	/**
	 * Set whether or not to display the amount
	 *
	 * @param bool $displayAmount True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayAmount($displayAmount = true)
	{
		if (is_bool($displayAmount)) {
			$this->displayAmount = $displayAmount;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the amount
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayAmount()
	{
		return $this->displayAmount;
	}

	/**
	 * Set whether or not to display the bank
	 *
	 * @param bool $displayBank True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayBank($displayBank = true)
	{
		if (is_bool($displayBank)) {
			$this->displayBank = $displayBank;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the bank
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayBank()
	{
		return $this->displayBank;
	}

	/**
	 * Set whether or not to display the payer
	 *
	 * @param bool $displayPayer True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayPayer($displayPayer = true)
	{
		if (is_bool($displayPayer)) {
			$this->displayPayer = $displayPayer;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the payer
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayPayer()
	{
		return $this->displayPayer;
	}

	/**
	 * Set whether or not to display the recipient
	 *
	 * @param bool $displayRecipient True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayRecipient($displayRecipient = true)
	{
		if (is_bool($displayRecipient)) {
			$this->displayRecipient = $displayRecipient;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the recipient
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayRecipient()
	{
		return $this->displayRecipient;
	}

	/**
	 * Set whether or not to display the reference number
	 *
	 * @param bool $displayReferenceNr True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayReferenceNr($displayReferenceNr = true)
	{
		if (is_bool($displayReferenceNr)) {
			$this->displayReferenceNr = $displayReferenceNr;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the reference number
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayReferenceNr()
	{
		return $this->displayReferenceNr;
	}

	public function createInpaymentSlip() {

		$fPdf = $this->fPdf;
		$inpaymentSlip = $this->inpaymentSlip;

		// Place background
		if (true) { // TODO implement switch, either as parameter or as property
			$fPdf->Image(__DIR__.'/Resources/img/ezs_orange.gif', $this->slipPosX, $this->slipPosY, 210, 106, "GIF");
		}

		//$fPdf->SetFillColor(255, 0 , 0); // TODO replace with conditional coloring (check for transparent) color conversion?

		// Place left bank lines
		if ($this->getDisplayBank()) {
			$posX = $this->bankLeftAttr['PosX'];
			$posY = $this->bankLeftAttr['PosY'];
			$height = $this->bankLeftAttr['Height'];
			$width = $this->bankLeftAttr['Width'];
			$fontFamily = $this->bankLeftAttr['FontFamily'];
			$background = $this->bankLeftAttr['Background'];
			$fontSize = $this->bankLeftAttr['FontSize'];
			$fontColor = $this->bankLeftAttr['FontColor'];
			$lineHeight = $this->bankLeftAttr['LineHeight'];
			$textAlign = $this->bankLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getBankName()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getBankCity()), 0, 0, $textAlign, false);
		}

		// Place right bank lines
		if ($this->getDisplayBank()) {
			$posX = $this->bankRightAttr['PosX'];
			$posY = $this->bankRightAttr['PosY'];
			$height = $this->bankRightAttr['Height'];
			$width = $this->bankRightAttr['Width'];
			$fontFamily = $this->bankRightAttr['FontFamily'];
			$background = $this->bankRightAttr['Background'];
			$fontSize = $this->bankRightAttr['FontSize'];
			$fontColor = $this->bankRightAttr['FontColor'];
			$lineHeight = $this->bankRightAttr['LineHeight'];
			$textAlign = $this->bankRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getBankName()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getBankCity()), 0, 0, $textAlign, false);
		}

		// Place left recipient lines
		if ($this->getDisplayRecipient()) {
			$posX = $this->recipientLeftAttr['PosX'];
			$posY = $this->recipientLeftAttr['PosY'];
			$height = $this->recipientLeftAttr['Height'];
			$width = $this->recipientLeftAttr['Width'];
			$fontFamily = $this->recipientLeftAttr['FontFamily'];
			$background = $this->recipientLeftAttr['Background'];
			$fontSize = $this->recipientLeftAttr['FontSize'];
			$fontColor = $this->recipientLeftAttr['FontColor'];
			$lineHeight = $this->recipientLeftAttr['LineHeight'];
			$textAlign = $this->recipientLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine1()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine2()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine3()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine4()), 0, 0, $textAlign, false);
		}

		// Place right recipient lines
		if ($this->getDisplayRecipient()) {
			$posX = $this->recipientRightAttr['PosX'];
			$posY = $this->recipientRightAttr['PosY'];
			$height = $this->recipientRightAttr['Height'];
			$width = $this->recipientRightAttr['Width'];
			$fontFamily = $this->recipientRightAttr['FontFamily'];
			$background = $this->recipientRightAttr['Background'];
			$fontSize = $this->recipientRightAttr['FontSize'];
			$fontColor = $this->recipientRightAttr['FontColor'];
			$lineHeight = $this->recipientRightAttr['LineHeight'];
			$textAlign = $this->recipientRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine1()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine2()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine3()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getRecipientLine4()), 0, 0, $textAlign, false);
		}

		// Place left account number
		if ($this->getDisplayAccount()) {
			$posX = $this->accountLeftAttr['PosX'];
			$posY = $this->accountLeftAttr['PosY'];
			$height = $this->accountLeftAttr['Height'];
			$width = $this->accountLeftAttr['Width'];
			$fontFamily = $this->accountLeftAttr['FontFamily'];
			$background = $this->accountLeftAttr['Background'];
			$fontSize = $this->accountLeftAttr['FontSize'];
			$fontColor = $this->accountLeftAttr['FontColor'];
			$lineHeight = $this->accountLeftAttr['LineHeight'];
			$textAlign = $this->accountLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAccountNumber()), 0, 0, $textAlign, false);
		}

		// Place right account number
		if ($this->getDisplayAccount()) {
			$posX = $this->accountRightAttr['PosX'];
			$posY = $this->accountRightAttr['PosY'];
			$height = $this->accountRightAttr['Height'];
			$width = $this->accountRightAttr['Width'];
			$fontFamily = $this->accountRightAttr['FontFamily'];
			$background = $this->accountRightAttr['Background'];
			$fontSize = $this->accountRightAttr['FontSize'];
			$fontColor = $this->accountRightAttr['FontColor'];
			$lineHeight = $this->accountRightAttr['LineHeight'];
			$textAlign = $this->accountRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAccountNumber()), 0, 0, $textAlign, false);
		}

		// Place left amount in francs
		if ($this->getDisplayAmount()) {
			$posX = $this->amountFrancsLeftAttr['PosX'];
			$posY = $this->amountFrancsLeftAttr['PosY'];
			$height = $this->amountFrancsLeftAttr['Height'];
			$width = $this->amountFrancsLeftAttr['Width'];
			$fontFamily = $this->amountFrancsLeftAttr['FontFamily'];
			$background = $this->amountFrancsLeftAttr['Background'];
			$fontSize = $this->amountFrancsLeftAttr['FontSize'];
			$fontColor = $this->amountFrancsLeftAttr['FontColor'];
			$lineHeight = $this->amountFrancsLeftAttr['LineHeight'];
			$textAlign = $this->amountFrancsLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAmountFrancs()), 0, 0, $textAlign, false);
		}

		// Place right amount in francs
		if ($this->getDisplayAmount()) {
			$posX = $this->amountFrancsRightAttr['PosX'];
			$posY = $this->amountFrancsRightAttr['PosY'];
			$height = $this->amountFrancsRightAttr['Height'];
			$width = $this->amountFrancsRightAttr['Width'];
			$fontFamily = $this->amountFrancsRightAttr['FontFamily'];
			$background = $this->amountFrancsRightAttr['Background'];
			$fontSize = $this->amountFrancsRightAttr['FontSize'];
			$fontColor = $this->amountFrancsRightAttr['FontColor'];
			$lineHeight = $this->amountFrancsRightAttr['LineHeight'];
			$textAlign = $this->amountFrancsRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAmountFrancs()), 0, 0, $textAlign, false);
		}

		// Place left amount in cents
		if ($this->getDisplayAmount()) {
			$posX = $this->amountCentsLeftAttr['PosX'];
			$posY = $this->amountCentsLeftAttr['PosY'];
			$height = $this->amountCentsLeftAttr['Height'];
			$width = $this->amountCentsLeftAttr['Width'];
			$fontFamily = $this->amountCentsLeftAttr['FontFamily'];
			$background = $this->amountCentsLeftAttr['Background'];
			$fontSize = $this->amountCentsLeftAttr['FontSize'];
			$fontColor = $this->amountCentsLeftAttr['FontColor'];
			$lineHeight = $this->amountCentsLeftAttr['LineHeight'];
			$textAlign = $this->amountCentsLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAmountCents()), 0, 0, $textAlign, false);
		}

		// Place right amount in cents
		if ($this->getDisplayAmount()) {
			$posX = $this->amountCentsRightAttr['PosX'];
			$posY = $this->amountCentsRightAttr['PosY'];
			$height = $this->amountCentsRightAttr['Height'];
			$width = $this->amountCentsRightAttr['Width'];
			$fontFamily = $this->amountCentsRightAttr['FontFamily'];
			$background = $this->amountCentsRightAttr['Background'];
			$fontSize = $this->amountCentsRightAttr['FontSize'];
			$fontColor = $this->amountCentsRightAttr['FontColor'];
			$lineHeight = $this->amountCentsRightAttr['LineHeight'];
			$textAlign = $this->amountCentsRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getAmountCents()), 0, 0, $textAlign, false);
		}

		// Place left reference number
		if ($this->getDisplayReferenceNr()) {
			$posX = $this->referenceNumberLeftAttr['PosX'];
			$posY = $this->referenceNumberLeftAttr['PosY'];
			$height = $this->referenceNumberLeftAttr['Height'];
			$width = $this->referenceNumberLeftAttr['Width'];
			$fontFamily = $this->referenceNumberLeftAttr['FontFamily'];
			$background = $this->referenceNumberLeftAttr['Background'];
			$fontSize = $this->referenceNumberLeftAttr['FontSize'];
			$fontColor = $this->referenceNumberLeftAttr['FontColor'];
			$lineHeight = $this->referenceNumberLeftAttr['LineHeight'];
			$textAlign = $this->referenceNumberLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getCompleteReferenceNumber()), 0, 0, $textAlign, false);
		}

		// Place right reference number
		if ($this->getDisplayReferenceNr()) {
			$posX = $this->referenceNumberRightAttr['PosX'];
			$posY = $this->referenceNumberRightAttr['PosY'];
			$height = $this->referenceNumberRightAttr['Height'];
			$width = $this->referenceNumberRightAttr['Width'];
			$fontFamily = $this->referenceNumberRightAttr['FontFamily'];
			$background = $this->referenceNumberRightAttr['Background'];
			$fontSize = $this->referenceNumberRightAttr['FontSize'];
			$fontColor = $this->referenceNumberRightAttr['FontColor'];
			$lineHeight = $this->referenceNumberRightAttr['LineHeight'];
			$textAlign = $this->referenceNumberRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getCompleteReferenceNumber()), 0, 0, $textAlign, false);
		}

		// Place left payer lines
		if ($this->getDisplayPayer()) {
			$posX = $this->payerLeftAttr['PosX'];
			$posY = $this->payerLeftAttr['PosY'];
			$height = $this->payerLeftAttr['Height'];
			$width = $this->payerLeftAttr['Width'];
			$fontFamily = $this->payerLeftAttr['FontFamily'];
			$background = $this->payerLeftAttr['Background'];
			$fontSize = $this->payerLeftAttr['FontSize'];
			$fontColor = $this->payerLeftAttr['FontColor'];
			$lineHeight = $this->payerLeftAttr['LineHeight'];
			$textAlign = $this->payerLeftAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine1()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine2()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine3()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine4()), 0, 0, $textAlign, false);
		}

		// Place right payer lines
		if ($this->getDisplayPayer()) {
			$posX = $this->payerRightAttr['PosX'];
			$posY = $this->payerRightAttr['PosY'];
			$height = $this->payerRightAttr['Height'];
			$width = $this->payerRightAttr['Width'];
			$fontFamily = $this->payerRightAttr['FontFamily'];
			$background = $this->payerRightAttr['Background'];
			$fontSize = $this->payerRightAttr['FontSize'];
			$fontColor = $this->payerRightAttr['FontColor'];
			$lineHeight = $this->payerRightAttr['LineHeight'];
			$textAlign = $this->payerRightAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine1()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine2()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine3()), 0, 0, $textAlign, false);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + $lineHeight + $lineHeight + $lineHeight);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getPayerLine4()), 0, 0, $textAlign, false);
		}

		// Place code line
		if (true) { // TODO implement getDisplayCodeLine
			$posX = $this->codeLineAttr['PosX'];
			$posY = $this->codeLineAttr['PosY'];
			$height = $this->codeLineAttr['Height'];
			$width = $this->codeLineAttr['Width'];
			$fontFamily = $this->codeLineAttr['FontFamily'];
			$background = $this->codeLineAttr['Background'];
			$fontSize = $this->codeLineAttr['FontSize'];
			$fontColor = $this->codeLineAttr['FontColor'];
			$lineHeight = $this->codeLineAttr['LineHeight'];
			$textAlign = $this->codeLineAttr['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);

			$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY);
			$fPdf->Cell($height, $width, utf8_decode($inpaymentSlip->getCodeLine()), 0, 0, $textAlign, false);
		}
	}
}
