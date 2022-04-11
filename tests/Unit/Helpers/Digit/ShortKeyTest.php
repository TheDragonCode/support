<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Digit;

use DragonCode\Support\Facades\Helpers\Digit;
use Tests\TestCase;

class ShortKeyTest extends TestCase
{
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
}
