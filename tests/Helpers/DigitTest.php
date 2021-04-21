<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Digit;
use Tests\TestCase;

final class DigitTest extends TestCase
{
    public function testRounded()
    {
        $this->assertSame(410000.0, $this->digit()->rounded(4100, 2));
        $this->assertSame(499000.0, $this->digit()->rounded(4990, 2));
        $this->assertSame(98900.0, $this->digit()->rounded(989, 2));
        $this->assertSame(98900.0, $this->digit()->rounded(989, 2));

        $this->assertSame(6100.0, $this->digit()->rounded(6100));
        $this->assertSame(7990.0, $this->digit()->rounded(7990));
        $this->assertSame(289.0, $this->digit()->rounded(289));
    }

    public function testShortKey()
    {
        $this->assertSame('a', $this->digit()->shortKey(0));
        $this->assertSame('d', $this->digit()->shortKey(3));
        $this->assertSame('f', $this->digit()->shortKey(5));
        $this->assertSame('h', $this->digit()->shortKey(7));
        $this->assertSame('k', $this->digit()->shortKey(10));
        $this->assertSame('l', $this->digit()->shortKey(11));
        $this->assertSame('m', $this->digit()->shortKey(12));
        $this->assertSame('n', $this->digit()->shortKey(13));
        $this->assertSame('q', $this->digit()->shortKey(16));
        $this->assertSame('u', $this->digit()->shortKey(20));
        $this->assertSame('dw', $this->digit()->shortKey(100));
        $this->assertSame('hs', $this->digit()->shortKey(200));
        $this->assertSame('bmm', $this->digit()->shortKey(1000));
        $this->assertSame('hki', $this->digit()->shortKey(5000));
    }

    public function testFactorial()
    {
        $this->assertSame(1, $this->digit()->factorial(1));
        $this->assertSame(2, $this->digit()->factorial(2));
        $this->assertSame(120, $this->digit()->factorial(5));
        $this->assertSame(40320, $this->digit()->factorial(8));
        $this->assertSame(3628800, $this->digit()->factorial(10));
    }

    public function testToShort()
    {
        $this->assertSame('100', $this->digit()->toShort(100));
        $this->assertSame('1K', $this->digit()->toShort(1000));
        $this->assertSame('4K', $this->digit()->toShort(4000));
        $this->assertSame('4.4K', $this->digit()->toShort(4400));
        $this->assertSame('4.5K', $this->digit()->toShort(4450));

        $this->assertSame('1M', $this->digit()->toShort(1000000));
        $this->assertSame('1M', $this->digit()->toShort(1000900));
        $this->assertSame('1M', $this->digit()->toShort(1001900));
        $this->assertSame('4M', $this->digit()->toShort(4001900));
        $this->assertSame('4.3M', $this->digit()->toShort(4291900));
        $this->assertSame('4.3M', $this->digit()->toShort(4301900));
        $this->assertSame('4.5M', $this->digit()->toShort(4501900));
        $this->assertSame('4.5M', $this->digit()->toShort(4501900));

        $this->assertSame('1B', $this->digit()->toShort(1000000000));
        $this->assertSame('1B', $this->digit()->toShort(1000900000));
        $this->assertSame('1B', $this->digit()->toShort(1001900000));
        $this->assertSame('4B', $this->digit()->toShort(4001900000));
        $this->assertSame('4.3B', $this->digit()->toShort(4291900000));
        $this->assertSame('4.3B', $this->digit()->toShort(4301900000));
        $this->assertSame('4.5B', $this->digit()->toShort(4501900000));
        $this->assertSame('4.5B', $this->digit()->toShort(4501900000));

        $this->assertSame('1T+', $this->digit()->toShort(1000000000000));
        $this->assertSame('1T+', $this->digit()->toShort(1000900000000));
        $this->assertSame('1T+', $this->digit()->toShort(1001900000000));
        $this->assertSame('4T+', $this->digit()->toShort(4001900000000));
        $this->assertSame('4.3T+', $this->digit()->toShort(4291900000000));
        $this->assertSame('4.3T+', $this->digit()->toShort(4301900000000));
        $this->assertSame('4.5T+', $this->digit()->toShort(4501900000000));
        $this->assertSame('4.5T+', $this->digit()->toShort(4501900000000));
    }

    public function testConvertToString()
    {
        $this->assertSame('1', $this->digit()->convertToString(1));
        $this->assertSame('1.3', $this->digit()->convertToString(1.3));

        $this->assertSame('0', $this->digit()->convertToString(0));
        $this->assertSame('0.3', $this->digit()->convertToString(0.3));

        $this->assertSame('1234', $this->digit()->convertToString(1234));
        $this->assertSame('1234.5', $this->digit()->convertToString(1234.5));
    }

    protected function digit(): Digit
    {
        return new Digit();
    }
}
