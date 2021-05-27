<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Digit as Helper;

/**
 * @method static float rounded(float $number, int $length = 4, int $precision = 1)
 * @method static int factorial(int $n = 0)
 * @method static string convertToString(float $value)
 * @method static string shortKey(int $number, string $chars = 'abcdefghijklmnopqrstuvwxyz')
 * @method static string toShort(float $number, int $precision = 1)
 */
final class Digit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
