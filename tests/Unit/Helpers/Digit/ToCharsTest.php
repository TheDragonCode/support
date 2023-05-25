<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Digit;

use DragonCode\Support\Facades\Helpers\Digit;
use Tests\TestCase;

class ToCharsTest extends TestCase
{
    public function testShortKey()
    {
        $this->assertSame('a', Digit::toChars(0));
        $this->assertSame('b', Digit::toChars(1));
        $this->assertSame('d', Digit::toChars(3));
        $this->assertSame('f', Digit::toChars(5));
        $this->assertSame('h', Digit::toChars(7));
        $this->assertSame('k', Digit::toChars(10));
        $this->assertSame('l', Digit::toChars(11));
        $this->assertSame('m', Digit::toChars(12));
        $this->assertSame('n', Digit::toChars(13));
        $this->assertSame('q', Digit::toChars(16));
        $this->assertSame('u', Digit::toChars(20));
        $this->assertSame('dw', Digit::toChars(100));
        $this->assertSame('hs', Digit::toChars(200));
        $this->assertSame('bmm', Digit::toChars(1000));
        $this->assertSame('hki', Digit::toChars(5000));
    }
}
