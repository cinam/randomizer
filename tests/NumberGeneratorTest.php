<?php

namespace Cinam\Randomizer\Tests;

use Cinam\Randomizer\NumberGenerator;
use Cinam\Randomizer\Exception\InvalidArgumentException;

class NumberGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberGenerator
     */
    protected $generator;

    public function setUp()
    {
        parent::setUp();

        $this->generator = new NumberGenerator();
    }

    public function tearDown()
    {
        $this->generator = null;
    }

    public function testGetInt()
    {
        $this->assertEquals(3, $this->generator->getInt(3, 3));
        $this->assertEquals(-3, $this->generator->getInt(-3, -3));

        for ($i = 0; $i < 100; $i++) {
            $min = \mt_rand(-1000, 1000);
            $max = \mt_rand($min, $min + 2000);

            $randomNumber = $this->generator->getInt($min, $max);
            $this->assertGreaterThanOrEqual($min, $randomNumber);
            $this->assertLessThanOrEqual($max, $randomNumber);
        }
    }

    public function testGetFloat()
    {
        $this->assertEquals(3.5, $this->generator->getFloat(3.5, 3.5));
        $this->assertEquals(-3.5, $this->generator->getFloat(-3.5, -3.5));

        for ($i = 0; $i < 100; $i++) {
            $min = \mt_rand(-1000, 1000) + (\mt_rand(0, 100) / 100);
            $max = $min + (\mt_rand(0, 100) / 100);

            $randomNumber = $this->generator->getFloat($min, $max);
            $this->assertGreaterThanOrEqual($min, $randomNumber);
            $this->assertLessThanOrEqual($max, $randomNumber);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testIfGetIntThrowsExceptions()
    {
        $this->generator->getInt(5, 4);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testIfGetFloatThrowsExceptions()
    {
        $this->generator->getFloat(5.0002, 5.0001);
    }
}
