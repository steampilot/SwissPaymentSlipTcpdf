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

namespace SwissPaymentSlip\SwissPaymentSlipTcdf\Tests;

use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip;
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlipData;

// Include Composer's autoloader
require __DIR__.'/../vendor/autoload.php';

/**
 * A wrapping class to allow testing the abstract class SwissPaymentSlipData
 */
class TestablePaymentSlipData extends SwissPaymentSlipData
{
}

/**
 * A wrapping class to allow testing the abstract class SwissPaymentSlip
 */
class TestablePaymentSlip extends SwissPaymentSlip
{
}
