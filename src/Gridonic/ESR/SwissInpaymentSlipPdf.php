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

// TODO getter and setter for position for each

class SwissInpaymentSlipPdf
{

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

	/**
	 * The FPDF engine object to generate the PDF output
	 *
	 * @var object The FPDF engine object
	 */
	private $fpdf = null;

	/**
	 * The inpayment slip object, which contains the inpayment slip data
	 *
	 * @var object The inpayment slip object
	 */
	private $inpaymentSlip = null;

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

	public function __construct($fpdf, $inpaymentSlip, $slipPosX = 0, $slipPosY = 0)
	{
		if (is_object($fpdf)) {
			$this->fpdf = $fpdf;
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
		if ($this->setSlipPosX($slipPosX &&
			$this->setSlipPosY($slipPosY))) {
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
}
