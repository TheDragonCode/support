<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Digit;
use Tests\TestCase;

class DigitTest extends TestCase
{
    public function testRoundedBcPow()
    {
        $this->assertEquals(410000, Digit::roundedBcPow(4100, 2));
        $this->assertEquals(499000, Digit::roundedBcPow(4990, 2));
        $this->assertEquals(98900, Digit::roundedBcPow(989, 2));
        $this->assertEquals(98900, Digit::roundedBcPow(989, 2));

        $this->assertEquals(6100, Digit::roundedBcPow(6100));
        $this->assertEquals(7990, Digit::roundedBcPow(7990));
        $this->assertEquals(289, Digit::roundedBcPow(289));
    }

    public function testFactorial()
    {
        $this->assertEquals(1, Digit::factorial(1));
        $this->assertEquals(2, Digit::factorial(2));
        $this->assertEquals(120, Digit::factorial(5));
        $this->assertEquals(40320, Digit::factorial(8));
        $this->assertEquals(3628800, Digit::factorial(10));
    }

    public function testShortNumber()
    {
        $this->assertEquals('100', Digit::shortNumber(100));
        $this->assertEquals('1K', Digit::shortNumber(1000));
        $this->assertEquals('4K', Digit::shortNumber(4000));
        $this->assertEquals('4.4K', Digit::shortNumber(4400));
        $this->assertEquals('4.5K', Digit::shortNumber(4450));

        $this->assertEquals('1M', Digit::shortNumber(1000000));
        $this->assertEquals('1M', Digit::shortNumber(1000900));
        $this->assertEquals('1M', Digit::shortNumber(1001900));
        $this->assertEquals('4M', Digit::shortNumber(4001900));
        $this->assertEquals('4.3M', Digit::shortNumber(4291900));
        $this->assertEquals('4.3M', Digit::shortNumber(4301900));
        $this->assertEquals('4.5M', Digit::shortNumber(4501900));
        $this->assertEquals('4.5M', Digit::shortNumber(4501900));

        $this->assertEquals('1B', Digit::shortNumber(1000000000));
        $this->assertEquals('1B', Digit::shortNumber(1000900000));
        $this->assertEquals('1B', Digit::shortNumber(1001900000));
        $this->assertEquals('4B', Digit::shortNumber(4001900000));
        $this->assertEquals('4.3B', Digit::shortNumber(4291900000));
        $this->assertEquals('4.3B', Digit::shortNumber(4301900000));
        $this->assertEquals('4.5B', Digit::shortNumber(4501900000));
        $this->assertEquals('4.5B', Digit::shortNumber(4501900000));

        $this->assertEquals('1T+', Digit::shortNumber(1000000000000));
        $this->assertEquals('1T+', Digit::shortNumber(1000900000000));
        $this->assertEquals('1T+', Digit::shortNumber(1001900000000));
        $this->assertEquals('4T+', Digit::shortNumber(4001900000000));
        $this->assertEquals('4.3T+', Digit::shortNumber(4291900000000));
        $this->assertEquals('4.3T+', Digit::shortNumber(4301900000000));
        $this->assertEquals('4.5T+', Digit::shortNumber(4501900000000));
        $this->assertEquals('4.5T+', Digit::shortNumber(4501900000000));
    }
}
