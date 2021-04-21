<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Digit;
use Tests\TestCase;

final class DigitTest extends TestCase
{
    public function testRounded()
    {
        $this->assertSame(410000.0, Digit::rounded(4100, 2));
        $this->assertSame(499000.0, Digit::rounded(4990, 2));
        $this->assertSame(98900.0, Digit::rounded(989, 2));
        $this->assertSame(98900.0, Digit::rounded(989, 2));

        $this->assertSame(6100.0, Digit::rounded(6100));
        $this->assertSame(7990.0, Digit::rounded(7990));
        $this->assertSame(289.0, Digit::rounded(289));
    }

    public function testShortKey()
    {
        $this->assertSame('a', Digit::shortKey(0));
        $this->assertSame('d', Digit::shortKey(3));
        $this->assertSame('f', Digit::shortKey(5));
        $this->assertSame('h', Digit::shortKey(7));
        $this->assertSame('k', Digit::shortKey(10));
        $this->assertSame('l', Digit::shortKey(11));
        $this->assertSame('m', Digit::shortKey(12));
        $this->assertSame('n', Digit::shortKey(13));
        $this->assertSame('q', Digit::shortKey(16));
        $this->assertSame('u', Digit::shortKey(20));
        $this->assertSame('dw', Digit::shortKey(100));
        $this->assertSame('hs', Digit::shortKey(200));
        $this->assertSame('bmm', Digit::shortKey(1000));
        $this->assertSame('hki', Digit::shortKey(5000));
    }

    public function testFactorial()
    {
        $this->assertSame(1, Digit::factorial(1));
        $this->assertSame(2, Digit::factorial(2));
        $this->assertSame(120, Digit::factorial(5));
        $this->assertSame(40320, Digit::factorial(8));
        $this->assertSame(3628800, Digit::factorial(10));
    }

    public function testToShort()
    {
        $this->assertSame('100', Digit::toShort(100));
        $this->assertSame('1K', Digit::toShort(1000));
        $this->assertSame('4K', Digit::toShort(4000));
        $this->assertSame('4.4K', Digit::toShort(4400));
        $this->assertSame('4.5K', Digit::toShort(4450));

        $this->assertSame('1M', Digit::toShort(1000000));
        $this->assertSame('1M', Digit::toShort(1000900));
        $this->assertSame('1M', Digit::toShort(1001900));
        $this->assertSame('4M', Digit::toShort(4001900));
        $this->assertSame('4.3M', Digit::toShort(4291900));
        $this->assertSame('4.3M', Digit::toShort(4301900));
        $this->assertSame('4.5M', Digit::toShort(4501900));
        $this->assertSame('4.5M', Digit::toShort(4501900));

        $this->assertSame('1B', Digit::toShort(1000000000));
        $this->assertSame('1B', Digit::toShort(1000900000));
        $this->assertSame('1B', Digit::toShort(1001900000));
        $this->assertSame('4B', Digit::toShort(4001900000));
        $this->assertSame('4.3B', Digit::toShort(4291900000));
        $this->assertSame('4.3B', Digit::toShort(4301900000));
        $this->assertSame('4.5B', Digit::toShort(4501900000));
        $this->assertSame('4.5B', Digit::toShort(4501900000));

        $this->assertSame('1T+', Digit::toShort(1000000000000));
        $this->assertSame('1T+', Digit::toShort(1000900000000));
        $this->assertSame('1T+', Digit::toShort(1001900000000));
        $this->assertSame('4T+', Digit::toShort(4001900000000));
        $this->assertSame('4.3T+', Digit::toShort(4291900000000));
        $this->assertSame('4.3T+', Digit::toShort(4301900000000));
        $this->assertSame('4.5T+', Digit::toShort(4501900000000));
        $this->assertSame('4.5T+', Digit::toShort(4501900000000));
    }

    public function testConvertToString()
    {
        $this->assertSame('1', Digit::convertToString(1));
        $this->assertSame('1.3', Digit::convertToString(1.3));

        $this->assertSame('0', Digit::convertToString(0));
        $this->assertSame('0.3', Digit::convertToString(0.3));

        $this->assertSame('1234', Digit::convertToString(1234));
        $this->assertSame('1234.5', Digit::convertToString(1234.5));
    }
}
