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
 * @version: 0.2.0
 */

namespace Gridonic\ESR;

use fpdf\FPDF;

/**
 * Responsible for generating standard Swiss inpayment Slips using FPDF as engine.
 * Layouting done by utilizing SwissInpaymentSlip
 * Data organisation through SwissInpaymentSlipData
 */
class SwissInpaymentSlipFpdf extends SwissInpaymentSlipPdf
{
	protected $rgbColors = array();

	/**
	 * The PDF engine object to generate the PDF output
	 *
	 * @var null|FPDF The PDF engine object
	 */
	protected $pdfEngine = null;

	protected function displayImage($background) {
		// TODO check if slipBackground is a color or a path to a file

		$this->pdfEngine->Image($background,
			$this->inpaymentSlip->getSlipPosX(),
			$this->inpaymentSlip->getSlipPosY(),
			$this->inpaymentSlip->getSlipWidth(),
			$this->inpaymentSlip->getSlipHeight(),
			strtoupper(substr($background, -3, 3)));
	}

	protected function setFont($fontFamily, $fontSize, $fontColor) {
		if ($fontColor) {
			$rgbArray = $this->convertColor2Rgb($fontColor);
			$this->pdfEngine->SetTextColor($rgbArray['red'], $rgbArray['green'], $rgbArray['blue']);
		}
		$this->pdfEngine->SetFont($fontFamily, '', $fontSize);
	}

	protected function setBackground($background) {
		// TODO check if it's a path to a file
		// TODO else it should be a color
		$rgbArray = $this->convertColor2Rgb($background);
		$this->pdfEngine->SetFillColor($rgbArray['red'], $rgbArray['green'], $rgbArray['blue']);
	}

	protected function setPosition($posX, $posY) {
		$this->pdfEngine->SetXY($posX, $posY);
	}

	protected function createCell($height, $width, $line, $textAlign, $fill) {
		$this->pdfEngine->Cell($width, $height, utf8_decode($line), 0, 0, $textAlign, $fill);
	}

	protected function convertColor2Rgb($color) {
		if (isset($this->rgbColors[$color])) {
			return $this->rgbColors[$color];
		}
		$this->rgbColors[$color] = $this->hex2RGB($color);
		return $this->rgbColors[$color];
	}

	/**
	 * Convert hexadecimal values into an array of RGB
	 *
	 * @param $hexStr
	 * @param bool $returnAsString
	 * @param string $seperator
	 * @return array|bool|string
	 *
	 * @copyright 2010 hafees at msn dot com
	 * @link http://www.php.net/manual/en/function.hexdec.php#99478
	 */
	private function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
		$rgbArray = array();
		if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} else {
			return false; //Invalid hex color code
		}
		return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}
}
