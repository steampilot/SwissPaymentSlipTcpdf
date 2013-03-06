<?php
namespace Gridonic\ESR;

require __DIR__ . '/../../../vendor/autoload.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-04 at 18:39:52.
 */
class SwissInpaymentSlipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SwissInpaymentSlip
     */
    protected $object;

	/**
	 * @var array
	 */
	protected $defaultAttributes;

	/**
	 * @var array
	 */
	protected $setAttributes;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$slipData = new SwissInpaymentSlipData();
        $this->object = new SwissInpaymentSlip($slipData);

		$attributes['PosX'] = 0;
		$attributes['PosY'] = 0;
		$attributes['Width'] = 0;
		$attributes['Height'] = 0;
		$attributes['Background'] = 'transparent';
		$attributes['FontFamily'] = 'Helvetica';
		$attributes['FontSize'] = '10';
		$attributes['FontColor'] = '#000';
		$attributes['LineHeight'] = 4;
		$attributes['TextAlign'] = 'L';

		$this->defaultAttributes = $attributes;


		$attributes['PosX'] = 123;
		$attributes['PosY'] = 456;
		$attributes['Width'] = 987;
		$attributes['Height'] = 654;
		$attributes['Background'] = '#123456';
		$attributes['FontFamily'] = 'Courier';
		$attributes['FontSize'] = '1';
		$attributes['FontColor'] = '#654321';
		$attributes['LineHeight'] = '15';
		$attributes['TextAlign'] = 'C';

		$this->setAttributes = $attributes;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::__construct
	 */
	public function testIsInstanceOf()
	{
		$this->assertInstanceOf('Gridonic\ESR\SwissInpaymentSlip',
			new SwissInpaymentSlip(new SwissInpaymentSlipData()));
		$this->assertInstanceOf('Gridonic\ESR\SwissInpaymentSlip',
			new SwissInpaymentSlip(new SwissInpaymentSlipData(), 100));
		$this->assertInstanceOf('Gridonic\ESR\SwissInpaymentSlip',
			new SwissInpaymentSlip(new SwissInpaymentSlipData(), 100, 100));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::__construct
	 * @expectedException \InvalidArgumentException
	 */
	public function testNullSlipDataParameter()
	{
		new SwissInpaymentSlip(null);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::__construct
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidSlipDataParameter()
	{
		new SwissInpaymentSlip(new \ArrayObject());
	}

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::getInpaymentSlipData
     */
    public function testGetInpaymentSlipDataIsInstanceOf()
    {
		$this->assertInstanceOf('Gridonic\ESR\SwissInpaymentSlipData',
			$this->object->getInpaymentSlipData());
    }

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipPosition
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipPosX
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipPosY
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getSlipPosX
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getSlipPosY
     */
    public function testSetSlipPosition()
    {
		$this->assertTrue($this->object->setSlipPosition(200, 100));
		$this->assertEquals(200, $this->object->getSlipPosX());
		$this->assertEquals(100, $this->object->getSlipPosY());

		$this->assertFalse($this->object->setSlipPosition('A', 100));
		$this->assertEquals(200, $this->object->getSlipPosX());
		$this->assertEquals(100, $this->object->getSlipPosY());

		$this->assertFalse($this->object->setSlipPosition(200, 'B'));
		$this->assertEquals(200, $this->object->getSlipPosX());
		$this->assertEquals(100, $this->object->getSlipPosY());
    }

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipSize
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipWidth
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipHeight
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getSlipWidth
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getSlipHeight
     */
    public function testSetSlipSize()
    {
		$this->assertTrue($this->object->setSlipSize(200, 100));
		$this->assertEquals(200, $this->object->getSlipWidth());
		$this->assertEquals(100, $this->object->getSlipHeight());

		$this->assertFalse($this->object->setSlipSize('A', 100));
		$this->assertEquals(200, $this->object->getSlipWidth());
		$this->assertEquals(100, $this->object->getSlipHeight());

		$this->assertFalse($this->object->setSlipSize(200, 'B'));
		$this->assertEquals(200, $this->object->getSlipWidth());
		$this->assertEquals(100, $this->object->getSlipHeight());
    }

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::setSlipBackground
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getSlipBackground
     */
    public function testSetSlipBackground()
    {
		$this->assertTrue($this->object->setSlipBackground('#123456'));
		$this->assertEquals('#123456', $this->object->getSlipBackground());

		$this->assertTrue($this->object->setSlipBackground(__DIR__.'/Resources/img/ezs_orange.gif'));
		$this->assertEquals(__DIR__.'/Resources/img/ezs_orange.gif', $this->object->getSlipBackground());
    }

    /**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
     */
    public function testBankLeftAttrDefaultValuesOrangeType()
    {
		$attributes = $this->object->getBankLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 3;
		$expectedAttributes['PosY'] = 8;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
    }

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testBankRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getBankRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 66;
		$expectedAttributes['PosY'] = 8;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testRecipientLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getRecipientLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 3;
		$expectedAttributes['PosY'] = 23;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testRecipientRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getRecipientRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 66;
		$expectedAttributes['PosY'] = 23;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAccountLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAccountLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 27;
		$expectedAttributes['PosY'] = 43;
		$expectedAttributes['Width'] = 30;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAccountRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAccountRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 90;
		$expectedAttributes['PosY'] = 43;
		$expectedAttributes['Width'] = 30;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAmountFrancsLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAmountFrancsLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 5;
		$expectedAttributes['PosY'] = 50.5;
		$expectedAttributes['Width'] = 35;
		$expectedAttributes['Height'] = 4;
		$expectedAttributes['TextAlign'] = 'R';

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAmountFrancsRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAmountFrancsRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 66;
		$expectedAttributes['PosY'] = 50.5;
		$expectedAttributes['Width'] = 35;
		$expectedAttributes['Height'] = 4;
		$expectedAttributes['TextAlign'] = 'R';

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAmountCentsLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAmountCentsLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 50;
		$expectedAttributes['PosY'] = 50.5;
		$expectedAttributes['Width'] = 6;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testAmountCentsRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getAmountCentsRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 111;
		$expectedAttributes['PosY'] = 50.5;
		$expectedAttributes['Width'] = 6;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testReferenceNumberLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getReferenceNumberLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 3;
		$expectedAttributes['PosY'] = 60;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;
		$expectedAttributes['FontSize'] = 8;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testReferenceNumberRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getReferenceNumberRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 125;
		$expectedAttributes['PosY'] = 33.5;
		$expectedAttributes['Width'] = 80;
		$expectedAttributes['Height'] = 4;
		$expectedAttributes['TextAlign'] = 'R';

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testPayerLeftAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getPayerLeftAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 3;
		$expectedAttributes['PosY'] = 65;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testPayerRightAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getPayerRightAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 125;
		$expectedAttributes['PosY'] = 48;
		$expectedAttributes['Width'] = 50;
		$expectedAttributes['Height'] = 4;

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testCodeLineAttrDefaultValuesOrangeType()
	{
		$attributes = $this->object->getCodeLineAttr();

		$expectedAttributes = $this->defaultAttributes;

		$expectedAttributes['PosX'] = 64;
		$expectedAttributes['PosY'] = 85;
		$expectedAttributes['Width'] = 140;
		$expectedAttributes['Height'] = 4;
		$expectedAttributes['FontFamily'] = 'OCRB10';
		$expectedAttributes['TextAlign'] = 'R';

		$this->assertEquals($expectedAttributes, $attributes);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testSlipBackgroundDefaultValuesOrangeType()
	{
		$this->assertEquals('ezs_orange.gif', basename($this->object->getSlipBackground()));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testBankLeftAttrDefaultValuesRedType
	 */
	public function testBankLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testBankRightAttrDefaultValuesRedType
	 */
	public function testBankRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testRecipientLeftAttrDefaultValuesRedType
	 */
	public function testRecipientLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testRecipientRightAttrDefaultValuesRedType
	 */
	public function testRecipientRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAccountLeftAttrDefaultValuesRedType
	 */
	public function testAccountLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAccountRightAttrDefaultValuesRedType
	 */
	public function testAccountRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAmountFrancsLeftAttrDefaultValuesRedType
	 */
	public function testAmountFrancsLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAmountFrancsRightAttrDefaultValuesRedType
	 */
	public function testAmountFrancsRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAmountCentsLeftAttrDefaultValuesRedType
	 */
	public function testAmountCentsLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testAmountCentsRightAttrDefaultValuesRedType
	 */
	public function testAmountCentsRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testReferenceNumberLeftAttrDefaultValuesRedType
	 */
	public function testReferenceNumberLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testReferenceNumberRightAttrDefaultValuesRedType
	 */
	public function testReferenceNumberRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testPayerLeftAttrDefaultValuesRedType
	 */
	public function testPayerLeftAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testPayerRightAttrDefaultValuesRedType
	 */
	public function testPayerRightAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 * @todo Implement testCodeLineAttrDefaultValuesRedType
	 */
	public function testCodeLineAttrDefaultValuesRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDefaults
	 */
	public function testSlipBackgroundDefaultValuesRedType()
	{
		$slipData = new SwissInpaymentSlipData('red');
		$this->object = new SwissInpaymentSlip($slipData);

		$this->assertEquals('ezs_red.gif', basename($this->object->getSlipBackground()));
	}

    /**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setBankLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
     * @covers Gridonic\ESR\SwissInpaymentSlip::getBankLeftAttr
     */
    public function testSetBankLeftAttr()
    {
		$this->assertTrue($this->object->setBankLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getBankLeftAttr());
    }

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setBankRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getBankRightAttr
	 */
	public function testSetBankRightAttr()
	{
		$this->assertTrue($this->object->setBankRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getBankRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setRecipientLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getRecipientLeftAttr
	 */
	public function testSetRecipientLeftAttr()
	{
		$this->assertTrue($this->object->setRecipientLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getRecipientLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setRecipientRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getRecipientRightAttr
	 */
	public function testSetRecipientRightAttr()
	{
		$this->assertTrue($this->object->setRecipientRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getRecipientRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAccountLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAccountLeftAttr
	 */
	public function testSetAccountLeftAttr()
	{
		$this->assertTrue($this->object->setAccountLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAccountLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAccountRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAccountRightAttr
	 */
	public function testSetAccountRightAttr()
	{
		$this->assertTrue($this->object->setAccountRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAccountRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAmountFrancsLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAmountFrancsLeftAttr
	 */
	public function testSetAmountFrancsLeftAttr()
	{
		$this->assertTrue($this->object->setAmountFrancsLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAmountFrancsLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAmountCentsLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAmountCentsLeftAttr
	 */
	public function testSetAmountCentsLeftAttr()
	{
		$this->assertTrue($this->object->setAmountCentsLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAmountCentsLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAmountCentsRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAmountCentsRightAttr
	 */
	public function testSetAmountCentsRightAttr()
	{
		$this->assertTrue($this->object->setAmountCentsRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAmountCentsRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAmountFrancsRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAmountFrancsRightAttr
	 */
	public function testSetAmountFrancsRightAttr()
	{
		$this->assertTrue($this->object->setAmountFrancsRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getAmountFrancsRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setReferenceNumberLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getReferenceNumberLeftAttr
	 */
	public function testSetReferenceNumberLeftAttr()
	{
		$this->assertTrue($this->object->setReferenceNumberLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getReferenceNumberLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setReferenceNumberRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getReferenceNumberRightAttr
	 */
	public function testSetReferenceNumberRightAttr()
	{
		$this->assertTrue($this->object->setReferenceNumberRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getReferenceNumberRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setPayerLeftAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getPayerLeftAttr
	 */
	public function testSetPayerLeftAttr()
	{
		$this->assertTrue($this->object->setPayerLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getPayerLeftAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setPayerRightAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getPayerRightAttr
	 */
	public function testSetPayerRightAttr()
	{
		$this->assertTrue($this->object->setPayerRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getPayerRightAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setCodeLineAttr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setAttributes
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getCodeLineAttr
	 */
	public function testSetCodeLineAttr()
	{
		$this->assertTrue($this->object->setCodeLineAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C'));
		$this->assertEquals($this->setAttributes, $this->object->getCodeLineAttr());
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayBank
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayBank
	 */
	public function testSetDisplayBank()
	{
		$this->assertTrue($this->object->setDisplayBank());
		$this->assertEquals(true, $this->object->getDisplayBank());

		$this->assertTrue($this->object->setDisplayBank(true));
		$this->assertEquals(true, $this->object->getDisplayBank());

		$this->assertTrue($this->object->setDisplayBank(false));
		$this->assertEquals(false, $this->object->getDisplayBank());

		$this->assertFalse($this->object->setDisplayBank('XXX'));
	}

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayAccount
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayAccount
     */
    public function testSetDisplayAccount()
    {
		$this->assertTrue($this->object->setDisplayAccount());
		$this->assertEquals(true, $this->object->getDisplayAccount());

		$this->assertTrue($this->object->setDisplayAccount(true));
		$this->assertEquals(true, $this->object->getDisplayAccount());

		$this->assertTrue($this->object->setDisplayAccount(false));
		$this->assertEquals(false, $this->object->getDisplayAccount());

		$this->assertFalse($this->object->setDisplayAccount('XXX'));
    }

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayRecipient
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayRecipient
	 */
	public function testSetDisplayRecipient()
	{
		$this->assertTrue($this->object->setDisplayRecipient());
		$this->assertEquals(true, $this->object->getDisplayRecipient());

		$this->assertTrue($this->object->setDisplayRecipient(true));
		$this->assertEquals(true, $this->object->getDisplayRecipient());

		$this->assertTrue($this->object->setDisplayRecipient(false));
		$this->assertEquals(false, $this->object->getDisplayRecipient());

		$this->assertFalse($this->object->setDisplayRecipient('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayAmount
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayAmount
	 */
	public function testSetDisplayAmount()
	{
		$this->assertTrue($this->object->setDisplayAmount());
		$this->assertEquals(true, $this->object->getDisplayAmount());

		$this->assertTrue($this->object->setDisplayAmount(true));
		$this->assertEquals(true, $this->object->getDisplayAmount());

		$this->assertTrue($this->object->setDisplayAmount(false));
		$this->assertEquals(false, $this->object->getDisplayAmount());

		$this->assertFalse($this->object->setDisplayAmount('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayReferenceNr
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayReferenceNr
	 */
	public function testSetDisplayReferenceNr()
	{
		$this->assertTrue($this->object->setDisplayReferenceNr());
		$this->assertEquals(true, $this->object->getDisplayReferenceNr());

		$this->assertTrue($this->object->setDisplayReferenceNr(true));
		$this->assertEquals(true, $this->object->getDisplayReferenceNr());

		$this->assertTrue($this->object->setDisplayReferenceNr(false));
		$this->assertEquals(false, $this->object->getDisplayReferenceNr());

		$this->assertFalse($this->object->setDisplayReferenceNr('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayPayer
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayPayer
	 */
	public function testSetDisplayPayer()
	{
		$this->assertTrue($this->object->setDisplayPayer());
		$this->assertEquals(true, $this->object->getDisplayPayer());

		$this->assertTrue($this->object->setDisplayPayer(true));
		$this->assertEquals(true, $this->object->getDisplayPayer());

		$this->assertTrue($this->object->setDisplayPayer(false));
		$this->assertEquals(false, $this->object->getDisplayPayer());

		$this->assertFalse($this->object->setDisplayPayer('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayCodeLine
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayCodeLine
	 */
	public function testSetDisplayCodeLine()
	{
		$this->assertTrue($this->object->setDisplayCodeLine());
		$this->assertEquals(true, $this->object->getDisplayCodeLine());

		$this->assertTrue($this->object->setDisplayCodeLine(true));
		$this->assertEquals(true, $this->object->getDisplayCodeLine());

		$this->assertTrue($this->object->setDisplayCodeLine(false));
		$this->assertEquals(false, $this->object->getDisplayCodeLine());

		$this->assertFalse($this->object->setDisplayCodeLine('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayIban
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayIban
	 */
	public function testSetDisplayIban()
	{
		$this->assertTrue($this->object->setDisplayIban());
		$this->assertEquals(true, $this->object->getDisplayIban());

		$this->assertTrue($this->object->setDisplayIban(true));
		$this->assertEquals(true, $this->object->getDisplayIban());

		$this->assertTrue($this->object->setDisplayIban(false));
		$this->assertEquals(false, $this->object->getDisplayIban());

		$this->assertFalse($this->object->setDisplayIban('XXX'));
	}

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::setDisplayPaymentReason
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getDisplayPaymentReason
	 */
	public function testSetDisplayPaymentReason()
	{
		$this->assertTrue($this->object->setDisplayPaymentReason());
		$this->assertEquals(true, $this->object->getDisplayPaymentReason());

		$this->assertTrue($this->object->setDisplayPaymentReason(true));
		$this->assertEquals(true, $this->object->getDisplayPaymentReason());

		$this->assertTrue($this->object->setDisplayPaymentReason(false));
		$this->assertEquals(false, $this->object->getDisplayPaymentReason());

		$this->assertFalse($this->object->setDisplayPaymentReason('XXX'));
	}

    /**
     * @covers Gridonic\ESR\SwissInpaymentSlip::getAllElements
     */
    public function testGetAllElementsOrangeType()
    {
		$elements = $this->object->getAllElements();

		$expectedElementsArray = array('bankLeft',
										'bankRight',
										'recipientLeft',
										'recipientRight',
										'accountLeft',
										'accountRight',
										'amountFrancsLeft',
										'amountFrancsRight',
										'amountCentsLeft',
										'amountCentsRight',
										'referenceNumberLeft',
										'referenceNumberRight',
										'payerLeft',
										'payerRight',
										'codeLine');

		foreach ($expectedElementsArray as $elementNr => $element) {
			$this->assertArrayHasKey($element, $elements);

			$this->assertArrayHasKey('lines', $elements[$element]);
			$this->assertArrayHasKey('attributes', $elements[$element]);
		}
    }

	/**
	 * @covers Gridonic\ESR\SwissInpaymentSlip::getAllElements
	 * @todo Implement testGetAllElementsRedType
	 */
	public function testGetAllElementsRedType()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}
}
