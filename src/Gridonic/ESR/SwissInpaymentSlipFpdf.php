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
class SwissInpaymentSlipFpdf extends SwissInpaymentSlipPdf
{
	protected function setFont($fontFamily, $fontSize) {
		$this->pdfEngine->SetFont($fontFamily, '', $fontSize);
	}

	protected function setBackground($background) {
		if ($background == 'transparent') {

		} else {
			// TODO check if it's a path to a file
			// TODO else it should be a color
			//$fPdf->SetFillColor(255, 0 , 0);
		}
	}

	protected function setPosition($posX, $posY) {
		$this->pdfEngine->SetXY($posX, $posY);
	}

	protected function createCell($height, $width, $line,$textAlign, $fill) {
		$this->pdfEngine->Cell($height, $width, utf8_decode($line), $textAlign, $fill);
	}
}
