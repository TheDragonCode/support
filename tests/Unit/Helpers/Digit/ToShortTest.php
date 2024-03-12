<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Digit;

use DragonCode\Support\Facades\Helpers\Digit;
use Tests\TestCase;

class ToShortTest extends TestCase
{
    public function testDefault()
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

    public function testWithPrecision()
    {
        $this->assertSame('100', Digit::toShort(100, 2));
        $this->assertSame('1K', Digit::toShort(1000, 2));
        $this->assertSame('4K', Digit::toShort(4000, 2));
        $this->assertSame('4.4K', Digit::toShort(4400, 2));
        $this->assertSame('4.45K', Digit::toShort(4450, 2));

        $this->assertSame('1M', Digit::toShort(1000000, 3));
        $this->assertSame('1.001M', Digit::toShort(1000900, 3));
        $this->assertSame('1.002M', Digit::toShort(1001900, 3));
        $this->assertSame('4.002M', Digit::toShort(4001900, 3));
        $this->assertSame('4.292M', Digit::toShort(4291900, 3));
        $this->assertSame('4.302M', Digit::toShort(4301900, 3));
        $this->assertSame('4.502M', Digit::toShort(4501900, 3));
        $this->assertSame('4.502M', Digit::toShort(4501900, 3));
    }

    public function testWithSuffix()
    {
        $this->assertSame('100b', Digit::toShort(100, 1, 'b'));
        $this->assertSame('1Kb', Digit::toShort(1000, 1, 'b'));
        $this->assertSame('4Kb', Digit::toShort(4000, 1, 'b'));
        $this->assertSame('4.4Kb', Digit::toShort(4400, 1, 'b'));
        $this->assertSame('4.5Kb', Digit::toShort(4450, 1, 'b'));

        $this->assertSame('1Mb', Digit::toShort(1000000, 1, 'b'));
        $this->assertSame('1Mb', Digit::toShort(1000900, 1, 'b'));
        $this->assertSame('1Mb', Digit::toShort(1001900, 1, 'b'));
        $this->assertSame('4Mb', Digit::toShort(4001900, 1, 'b'));
        $this->assertSame('4.3Mb', Digit::toShort(4291900, 1, 'b'));
        $this->assertSame('4.3Mb', Digit::toShort(4301900, 1, 'b'));
        $this->assertSame('4.5Mb', Digit::toShort(4501900, 1, 'b'));
        $this->assertSame('4.5Mb', Digit::toShort(4501900, 1, 'b'));

        $this->assertSame('1Bb', Digit::toShort(1000000000, 1, 'b'));
        $this->assertSame('1Bb', Digit::toShort(1000900000, 1, 'b'));
        $this->assertSame('1Bb', Digit::toShort(1001900000, 1, 'b'));
        $this->assertSame('4Bb', Digit::toShort(4001900000, 1, 'b'));
        $this->assertSame('4.3Bb', Digit::toShort(4291900000, 1, 'b'));
        $this->assertSame('4.3Bb', Digit::toShort(4301900000, 1, 'b'));
        $this->assertSame('4.5Bb', Digit::toShort(4501900000, 1, 'b'));
        $this->assertSame('4.5Bb', Digit::toShort(4501900000, 1, 'b'));

        $this->assertSame('1Tb+', Digit::toShort(1000000000000, 1, 'b'));
        $this->assertSame('1Tb+', Digit::toShort(1000900000000, 1, 'b'));
        $this->assertSame('1Tb+', Digit::toShort(1001900000000, 1, 'b'));
        $this->assertSame('4Tb+', Digit::toShort(4001900000000, 1, 'b'));
        $this->assertSame('4.3Tb+', Digit::toShort(4291900000000, 1, 'b'));
        $this->assertSame('4.3Tb+', Digit::toShort(4301900000000, 1, 'b'));
        $this->assertSame('4.5Tb+', Digit::toShort(4501900000000, 1, 'b'));
        $this->assertSame('4.5Tb+', Digit::toShort(4501900000000, 1, 'b'));
    }
}
