<?php

namespace Tests;

use Helldar\Support\Helpers\Digits;
use PHPUnit\Framework\TestCase;

class DigitsTest extends TestCase
{
    public function testNumberFormat()
    {
        $this->assertEquals(4.1, Digits::numberFormat(4100, 2));
        $this->assertEquals(5.0, Digits::numberFormat(4990, 2));
        $this->assertEquals(9.9, Digits::numberFormat(989, 2));

        $this->assertEquals(4100, Digits::numberFormat(4100));
        $this->assertEquals(4990, Digits::numberFormat(4990));
        $this->assertEquals(989, Digits::numberFormat(989));
    }

    public function testFactorial()
    {
        $this->assertEquals(1, Digits::factorial(1));
        $this->assertEquals(2, Digits::factorial(2));
        $this->assertEquals(120, Digits::factorial(5));
        $this->assertEquals(40320, Digits::factorial(8));
        $this->assertEquals(3628800, Digits::factorial(10));
    }

    public function testShortNumber()
    {
        $this->assertEquals('100', Digits::shortNumber(100));
        $this->assertEquals('1K', Digits::shortNumber(1000));
        $this->assertEquals('4K', Digits::shortNumber(4000));
        $this->assertEquals('4.4K', Digits::shortNumber(4400));
        $this->assertEquals('4.5K', Digits::shortNumber(4450));

        $this->assertEquals('1M', Digits::shortNumber(1000000));
        $this->assertEquals('1M', Digits::shortNumber(1000900));
        $this->assertEquals('1M', Digits::shortNumber(1001900));
        $this->assertEquals('4M', Digits::shortNumber(4001900));
        $this->assertEquals('4.3M', Digits::shortNumber(4291900));
        $this->assertEquals('4.3M', Digits::shortNumber(4301900));
        $this->assertEquals('4.5M', Digits::shortNumber(4501900));
        $this->assertEquals('4.5M', Digits::shortNumber(4501900));

        $this->assertEquals('1B', Digits::shortNumber(1000000000));
        $this->assertEquals('1B', Digits::shortNumber(1000900000));
        $this->assertEquals('1B', Digits::shortNumber(1001900000));
        $this->assertEquals('4B', Digits::shortNumber(4001900000));
        $this->assertEquals('4.3B', Digits::shortNumber(4291900000));
        $this->assertEquals('4.3B', Digits::shortNumber(4301900000));
        $this->assertEquals('4.5B', Digits::shortNumber(4501900000));
        $this->assertEquals('4.5B', Digits::shortNumber(4501900000));

        $this->assertEquals('1T+', Digits::shortNumber(1000000000000));
        $this->assertEquals('1T+', Digits::shortNumber(1000900000000));
        $this->assertEquals('1T+', Digits::shortNumber(1001900000000));
        $this->assertEquals('4T+', Digits::shortNumber(4001900000000));
        $this->assertEquals('4.3T+', Digits::shortNumber(4291900000000));
        $this->assertEquals('4.3T+', Digits::shortNumber(4301900000000));
        $this->assertEquals('4.5T+', Digits::shortNumber(4501900000000));
        $this->assertEquals('4.5T+', Digits::shortNumber(4501900000000));
    }
}
