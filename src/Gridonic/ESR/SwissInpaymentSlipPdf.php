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

/**
 * The whole class could even be completely decoupled from FPDF by moving creating getters for all needed data
 * and moving the function createInpaymentSlip() and its helper function writeInpaymentSlipLines into a new class.
 * Like this you could also achieve that this class (in combination with the already general SwissInpaymentSlip class)
 * would become a general purpose class for swiss inpayment slips but not specifically for creating PDFs from it.
 */
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
	private $slipPosY = 191;

	private $slipHeight = 106; // default height of an orange slip

	private $slipWidth = 210; // default width of an orange slip

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

	/**
	 * Determines if the code line at the bottom should be displayed
	 *
	 * @var bool True if yes, false if no
	 */
	private $displayCodeLine = true;

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

	public function __construct($fPdf, $inpaymentSlip, $slipPosX = null, $slipPosY = null)
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
		if (!is_null($slipPosX)) {
			if (!$this->setSlipPosX($slipPosX)) {
				// throw error
			}
		}
		if (!is_null($slipPosY)) {
			if (!$this->setSlipPosY($slipPosY)) {
				// throw error
			}
		}

		// TODO distinguish between red and orange type (get from SwissInpaymentSlip class)

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

		$this->setSlipBackground(__DIR__.'/Resources/img/ezs_orange.gif');
	}

	/**
	 * Set slip X & Y position
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
		if (is_int($slipPosX) || is_float($slipPosX)) {
			$this->slipPosX = $slipPosX;
			return true;
		}
		return false;
	}

	private function setSlipPosY($slipPosY)
	{
		if (is_int($slipPosY) || is_float($slipPosY)) {
			$this->slipPosY = $slipPosY;
			return true;
		}
		return false;
	}

	/**
	 * Set slip height & width
	 *
	 * @param $slipHeight
	 * @param $slipWidth
	 * @return bool True if successful, else false
	 */
	public function setSlipSize($slipHeight, $slipWidth)
	{
		if ($this->setSlipHeight($slipHeight) &&
			$this->setSlipWidth($slipWidth)) {
			return true;
		}
		return false;
	}

	private function setSlipHeight($slipHeight)
	{
		if (is_int($slipHeight) || is_float($slipHeight)) {
			$this->slipPosX = $slipHeight;
			return true;
		}
		return false;
	}

	private function setSlipWidth($slipWidth)
	{
		if (is_int($slipWidth) || is_float($slipWidth)) {
			$this->slipPosY = $slipWidth;
			return true;
		}
		return false;
	}

	/**
	 * @param null $slipBackground
	 */
	public function setSlipBackground($slipBackground)
	{
		// TODO check if it's a color or a path to a file
		$this->slipBackground = $slipBackground;
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

	/**
	 * Set whether or not to display the IBAN
	 *
	 * @param bool $displayIban True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayIban($displayIban = true)
	{
		if (is_bool($displayIban)) {
			$this->displayIban = $displayIban;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the IBAN
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayIban()
	{
		return $this->displayIban;
	}

	/**
	 * Set whether or not to display the payment reason lines
	 *
	 * @param bool $displayPaymentReason True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayPaymentReason($displayPaymentReason = true)
	{
		if (is_bool($displayPaymentReason)) {
			$this->displayPaymentReason = $displayPaymentReason;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the payment reason lines
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayPaymentReason()
	{
		return $this->displayPaymentReason;
	}

	/**
	 * Set whether or not to display the code line at the bottom
	 *
	 * @param bool $displayCodeLine True if yes, false if no
	 * @return bool True if successful, else false
	 */
	public function setDisplayCodeLine($displayCodeLine = true)
	{
		if (is_bool($displayCodeLine)) {
			$this->displayCodeLine = $displayCodeLine;
			return true;
		}
		return false;
	}

	/**
	 * Get whether or not to display the code line at the bottom
	 *
	 * @return bool True if yes, false if no
	 */
	public function getDisplayCodeLine()
	{
		return $this->displayCodeLine;
	}

	private function writeInpaymentSlipLines($lines, $attributes) {

		$fPdf = $this->fPdf;

		if (is_array($lines) && is_array($attributes)) {

			$posX = $attributes['PosX'];
			$posY = $attributes['PosY'];
			$height = $attributes['Height'];
			$width = $attributes['Width'];
			$fontFamily = $attributes['FontFamily'];
			$background = $attributes['Background'];
			$fontSize = $attributes['FontSize'];
			$fontColor = $attributes['FontColor'];
			$lineHeight = $attributes['LineHeight'];
			$textAlign = $attributes['TextAlign'];

			$fPdf->SetFont($fontFamily, '', $fontSize);
			//$fPdf->SetFillColor(255, 0 , 0);  // TODO replace with conditional coloring (check for transparent) color conversion?

			foreach ($lines as $lineNr => $line) {
				$fPdf->SetXY($this->slipPosX + $posX, $this->slipPosY + $posY + ($lineNr * $lineHeight));
				$fPdf->Cell($height, $width, utf8_decode($line), 0, 0, $textAlign, false);
			}
		}
	}

	public function createInpaymentSlip($withBackground = true) {
		$fPdf = $this->fPdf;
		$inpaymentSlip = $this->inpaymentSlip;

		// Place background
		if ($withBackground) {
			// TODO check if slipBackground is a color or a path to a file
			$fPdf->Image($this->slipBackground, $this->slipPosX, $this->slipPosY, $this->slipWidth, $this->slipHeight, "GIF");
		}

		// Place left bank lines
		if ($this->getDisplayBank()) {
			$bankLines = array($inpaymentSlip->getBankName(),
								$inpaymentSlip->getBankCity());

			$this->writeInpaymentSlipLines($bankLines, $this->bankLeftAttr);
		}

		// Place right bank lines
		if ($this->getDisplayBank()) {
			$bankLines = array($inpaymentSlip->getBankName(),
				$inpaymentSlip->getBankCity());

			$this->writeInpaymentSlipLines($bankLines, $this->bankRightAttr);
		}

		// Place left recipient lines
		if ($this->getDisplayRecipient()) {
			$bankLines = array($inpaymentSlip->getRecipientLine1(),
				$inpaymentSlip->getRecipientLine2(), $inpaymentSlip->getRecipientLine3(),
				$inpaymentSlip->getRecipientLine4());

			$this->writeInpaymentSlipLines($bankLines, $this->recipientLeftAttr);
		}

		// Place right recipient lines
		if ($this->getDisplayRecipient()) {
			$bankLines = array($inpaymentSlip->getRecipientLine1(),
				$inpaymentSlip->getRecipientLine2(), $inpaymentSlip->getRecipientLine3(),
				$inpaymentSlip->getRecipientLine4());

			$this->writeInpaymentSlipLines($bankLines, $this->recipientRightAttr);
		}

		// Place left account number
		if ($this->getDisplayAccount()) {
			$bankLines = array($inpaymentSlip->getAccountNumber());

			$this->writeInpaymentSlipLines($bankLines, $this->accountLeftAttr);
		}

		// Place right account number
		if ($this->getDisplayAccount()) {
			$bankLines = array($inpaymentSlip->getAccountNumber());

			$this->writeInpaymentSlipLines($bankLines, $this->accountRightAttr);
		}

		// Place left amount in francs
		if ($this->getDisplayAmount()) {
			$bankLines = array($inpaymentSlip->getAmountFrancs());

			$this->writeInpaymentSlipLines($bankLines, $this->amountFrancsLeftAttr);
		}

		// Place right amount in francs
		if ($this->getDisplayAmount()) {
			$bankLines = array($inpaymentSlip->getAmountFrancs());

			$this->writeInpaymentSlipLines($bankLines, $this->amountFrancsRightAttr);
		}

		// Place left amount in cents
		if ($this->getDisplayAmount()) {
			$bankLines = array($inpaymentSlip->getAmountCents());

			$this->writeInpaymentSlipLines($bankLines, $this->amountCentsLeftAttr);
		}

		// Place right amount in cents
		if ($this->getDisplayAmount()) {
			$bankLines = array($inpaymentSlip->getAmountCents());

			$this->writeInpaymentSlipLines($bankLines, $this->amountCentsRightAttr);
		}

		// Place left reference number
		if ($this->getDisplayReferenceNr()) {
			$bankLines = array($inpaymentSlip->getCompleteReferenceNumber());

			$this->writeInpaymentSlipLines($bankLines, $this->referenceNumberLeftAttr);
		}

		// Place right reference number
		if ($this->getDisplayReferenceNr()) {
			$bankLines = array($inpaymentSlip->getCompleteReferenceNumber());

			$this->writeInpaymentSlipLines($bankLines, $this->referenceNumberRightAttr);
		}

		// Place left payer lines
		if ($this->getDisplayPayer()) {
			$bankLines = array($inpaymentSlip->getPayerLine1(),
				$inpaymentSlip->getPayerLine2(), $inpaymentSlip->getPayerLine3(),
				$inpaymentSlip->getPayerLine4());

			$this->writeInpaymentSlipLines($bankLines, $this->payerLeftAttr);
		}

		// Place right payer lines
		if ($this->getDisplayPayer()) {
			$bankLines = array($inpaymentSlip->getPayerLine1(),
				$inpaymentSlip->getPayerLine2(), $inpaymentSlip->getPayerLine3(),
				$inpaymentSlip->getPayerLine4());

			$this->writeInpaymentSlipLines($bankLines, $this->payerRightAttr);
		}

		// Place code line
		if ($this->getDisplayCodeLine()) {
			$bankLines = array($inpaymentSlip->getCodeLine());

			$this->writeInpaymentSlipLines($bankLines, $this->codeLineAttr);
		}
	}
}
