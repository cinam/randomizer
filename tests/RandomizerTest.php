<?php

namespace Cinam\Randomizer\Tests;

use Cinam\Randomizer\NumberGenerator;
use Cinam\Randomizer\Randomizer;
use Cinam\Randomizer\Exception\InvalidArgumentException;

class RandomizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Randomizer
     */
    protected $randomizer;

    public function setUp()
    {
        parent::setUp();

        $this->randomizer = new Randomizer(new NumberGenerator());
    }

    public function tearDown()
    {
        $this->randomizer = null;
    }

    public function testGetBooleanType()
    {
        $parameterValues = array(0, 0.5, 1);
        for ($i = 0; $i < 100; $i++) {
            $parameter = $parameterValues[\array_rand($parameterValues)];
            $value = $this->randomizer->getBoolean($parameter);
            $this->assertInternalType('boolean', $value);
        }
    }

    /**
     * @dataProvider providerForGetBooleanException
     * @expectedException InvalidArgumentException
     */
    public function testGetBooleanException($probability)
    {
        $this->randomizer->getBoolean($probability);
    }

    public function providerForGetBooleanException()
    {
        return array(
            array(null),
            array(false),
            array(true),
            array('1'),
            array(new \stdClass()),
            array(-1),
            array(-0.00001),
            array(1.00001),
            array(2),
        );
    }

    public function testGetArrayKeyByPowers()
    {
        $this->assertEquals(0, $this->randomizer->getArrayKeyByPowers(array(44, 0, 0)));
        $this->assertEquals(1, $this->randomizer->getArrayKeyByPowers(array(0, 5, 0)));
        $this->assertEquals(2, $this->randomizer->getArrayKeyByPowers(array(0, 0, 0.0001)));
        $this->assertEquals(0, $this->randomizer->getArrayKeyByPowers(array(15)));
    }

    /**
     * @dataProvider providerForGetArrayKeyByPowersException
     * @expectedException InvalidArgumentException
     */
    public function testGetArrayKeyByPowersException($powers)
    {
        $this->randomizer->getArrayKeyByPowers($powers);
    }

    public function providerForGetArrayKeyByPowersException()
    {
        return array(
            // empty array:
            array(array()),

            // sum of powers zero or power negative:
            array(array(0, 0, 0)),
            array(array(1, 1, -0.0001)),
        );
    }

    public function testValuePowers()
    {
        $values = array('one', 'two', 'three');
        $this->assertEquals('one', $this->randomizer->getValueByPowers($values, array(44, 0, 0)));
        $this->assertEquals('two', $this->randomizer->getValueByPowers($values, array(0, 5, 0)));
        $this->assertEquals('three', $this->randomizer->getValueByPowers($values, array(0, 0, 0.0001)));

        $this->assertEquals('one', $this->randomizer->getValueByPowers(array('one'), array(15)));
    }

    /**
     * @dataProvider providerForGetValueByPowersException
     * @expectedException InvalidArgumentException
     */
    public function testGetValueByPowersException($values, $powers)
    {
        $this->randomizer->getValueByPowers($values, $powers);
    }

    public function providerForGetValueByPowersException()
    {
        return array(
            // empty array:
            array(array(), array()),
            array(array(1), array()),
            array(array(), array(1)),

            // counts not equal:
            array(array(1), array(1, 1)),
            array(array(1, 1), array(1)),

            // sum of powers zero or power negative:
            array(array(1, 1, 1), array(0, 0, 0)),
            array(array(1, 1, 1), array(1, 1, -0.0001)),
        );
    }
}
