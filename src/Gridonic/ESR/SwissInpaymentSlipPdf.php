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

use fpdf\FPDF;

/**
 * Responsible for generating standard Swiss inpayment Slips using FPDF as engine.
 * Layouting done by utilizing SwissInpaymentSlip
 * Data organisation through SwissInpaymentSlipData
 */
abstract class SwissInpaymentSlipPdf
{

	/**
	 * The FPDF engine object to generate the PDF output
	 *
	 * @var null|FPDF The FPDF engine object
	 */
	protected $pdfEngine = null;

	/**
	 * The inpayment slip object, which contains the inpayment slip data
	 *
	 * @var null|SwissInpaymentSlip The inpayment slip object
	 */
	protected $inpaymentSlip = null;

	/**
	 *
	 *
	 * @param object $pdfEngine
	 * @param SwissInpaymentSlip $inpaymentSlip
	 */
	public function __construct($pdfEngine, $inpaymentSlip)
	{
		if (is_object($pdfEngine)) {
			$this->pdfEngine = $pdfEngine;
		} else {
			// throw error
		}
		if (is_object($inpaymentSlip)) {
			$this->inpaymentSlip = $inpaymentSlip;
		} else {
			// throw error
		}
	}

	abstract protected function setFont($fontFamily, $fontSize);

	abstract protected function setBackground($background);

	abstract protected function setPosition($posX, $posY);

	abstract protected function createCell($height, $width, $line,$textAlign, $fill);

	private function writeInpaymentSlipLines($lines, $attributes) {

		$pdfEngine = $this->pdfEngine;

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

			$pdfEngine->SetFont($fontFamily, '', $fontSize);
			//$pdfEngine->SetFillColor(255, 0 , 0);  // TODO replace with conditional coloring (check for transparent) color conversion?

			foreach ($lines as $lineNr => $line) {
				$pdfEngine->SetXY($this->inpaymentSlip->getSlipPosX() + $posX, $this->inpaymentSlip->getSlipPosY() + $posY + ($lineNr * $lineHeight));
				$pdfEngine->Cell($height, $width, utf8_decode($line), 0, 0, $textAlign, false);
			}
		}
	}

	public function createInpaymentSlip($withBackground = true) {
		$pdfEngine = $this->pdfEngine;
		$inpaymentSlip = $this->inpaymentSlip;
		$inpaymentSlipData = $inpaymentSlip->getSlipData();

		// Place background
		if ($withBackground) {
			// TODO check if slipBackground is a color or a path to a file
			$pdfEngine->Image($inpaymentSlip->getSlipBackground(), $inpaymentSlip->getSlipPosX(), $inpaymentSlip->getSlipPosY(), $inpaymentSlip->getSlipWidth(), $inpaymentSlip->getSlipHeight(), "GIF");
		}

		// Place left bank lines
		if ($inpaymentSlip->getDisplayBank()) {
			$bankLines = array($inpaymentSlipData->getBankName(),
								$inpaymentSlipData->getBankCity());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getBankLeftAttr());
		}

		// Place right bank lines
		if ($inpaymentSlip->getDisplayBank()) {
			$bankLines = array($inpaymentSlipData->getBankName(),
				$inpaymentSlipData->getBankCity());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getBankRightAttr());
		}

		// Place left recipient lines
		if ($inpaymentSlip->getDisplayRecipient()) {
			$bankLines = array($inpaymentSlipData->getRecipientLine1(),
				$inpaymentSlipData->getRecipientLine2(), $inpaymentSlipData->getRecipientLine3(),
				$inpaymentSlipData->getRecipientLine4());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getRecipientLeftAttr());
		}

		// Place right recipient lines
		if ($inpaymentSlip->getDisplayRecipient()) {
			$bankLines = array($inpaymentSlipData->getRecipientLine1(),
				$inpaymentSlipData->getRecipientLine2(), $inpaymentSlipData->getRecipientLine3(),
				$inpaymentSlipData->getRecipientLine4());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getRecipientRightAttr());
		}

		// Place left account number
		if ($inpaymentSlip->getDisplayAccount()) {
			$bankLines = array($inpaymentSlipData->getAccountNumber());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAccountLeftAttr());
		}

		// Place right account number
		if ($inpaymentSlip->getDisplayAccount()) {
			$bankLines = array($inpaymentSlipData->getAccountNumber());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAccountRightAttr());
		}

		// Place left amount in francs
		if ($inpaymentSlip->getDisplayAmount()) {
			$bankLines = array($inpaymentSlipData->getAmountFrancs());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAmountFrancsLeftAttr());
		}

		// Place right amount in francs
		if ($inpaymentSlip->getDisplayAmount()) {
			$bankLines = array($inpaymentSlipData->getAmountFrancs());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAmountFrancsRightAttr());
		}

		// Place left amount in cents
		if ($inpaymentSlip->getDisplayAmount()) {
			$bankLines = array($inpaymentSlipData->getAmountCents());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAmountCentsLeftAttr());
		}

		// Place right amount in cents
		if ($inpaymentSlip->getDisplayAmount()) {
			$bankLines = array($inpaymentSlipData->getAmountCents());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getAmountCentsRightAttr());
		}

		// Place left reference number
		if ($inpaymentSlip->getDisplayReferenceNr()) {
			$bankLines = array($inpaymentSlipData->getCompleteReferenceNumber());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getReferenceNumberLeftAttr());
		}

		// Place right reference number
		if ($inpaymentSlip->getDisplayReferenceNr()) {
			$bankLines = array($inpaymentSlipData->getCompleteReferenceNumber());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getReferenceNumberRightAttr());
		}

		// Place left payer lines
		if ($inpaymentSlip->getDisplayPayer()) {
			$bankLines = array($inpaymentSlipData->getPayerLine1(),
				$inpaymentSlipData->getPayerLine2(), $inpaymentSlipData->getPayerLine3(),
				$inpaymentSlipData->getPayerLine4());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getPayerLeftAttr());
		}

		// Place right payer lines
		if ($inpaymentSlip->getDisplayPayer()) {
			$bankLines = array($inpaymentSlipData->getPayerLine1(),
				$inpaymentSlipData->getPayerLine2(), $inpaymentSlipData->getPayerLine3(),
				$inpaymentSlipData->getPayerLine4());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getPayerRightAttr());
		}

		// Place code line
		if ($inpaymentSlip->getDisplayCodeLine()) {
			$bankLines = array($inpaymentSlipData->getCodeLine());

			$this->writeInpaymentSlipLines($bankLines, $inpaymentSlip->getCodeLineAttr());
		}
	}
}
