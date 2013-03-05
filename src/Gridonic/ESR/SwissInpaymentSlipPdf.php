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
 * @version: 0.4.0
 */

namespace Gridonic\ESR;

use fpdf\FPDF;

/**
 * Responsible for generating standard Swiss inpayment Slips using FPDF as engine.
 * Layout done by utilizing SwissInpaymentSlip
 * Data organisation through SwissInpaymentSlipData
 */
abstract class SwissInpaymentSlipPdf
{
	/**
	 * The PDF engine object to generate the PDF output
	 *
	 * @var null|object The PDF engine object
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

	abstract protected function displayImage($background);

	abstract protected function setFont($fontFamily, $fontSize, $fontColor);

	abstract protected function setBackground($background);

	abstract protected function setPosition($posX, $posY);

	abstract protected function createCell($width, $height, $line,$textAlign, $fill);

	protected function writeInpaymentSlipLines($element) {

		if (is_array($element)) {

			if (isset($element['lines']) && isset($element['attributes'])) {
				$lines = $element['lines'];
				$attributes = $element['attributes'];

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

					$this->setFont($fontFamily, $fontSize, $fontColor);
					if ($background != 'transparent') {
						$this->setBackground($background);
						$fill = true;
					} else {
						$fill = false;
					}

					foreach ($lines as $lineNr => $line) {
						$this->setPosition($this->inpaymentSlip->getSlipPosX() + $posX, $this->inpaymentSlip->getSlipPosY() + $posY + ($lineNr * $lineHeight));
						$this->createCell($width, $height, $line, $textAlign, $fill);
					}
				}
			}
		}
	}

	public function createInpaymentSlip($formatted = true, $fillZeroes = true, $withBackground = true) {
		$inpaymentSlip = $this->inpaymentSlip;

		// Place background
		if ($withBackground) {
			$this->displayImage($inpaymentSlip->getSlipBackground());
		}

		// go through all elements/element groups, write each line
		foreach ($inpaymentSlip->getAllElements($formatted, $fillZeroes) as $elementName => $element) {
			$this->writeInpaymentSlipLines($element);
		}
	}
}
