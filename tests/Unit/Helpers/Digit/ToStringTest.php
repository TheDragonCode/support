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

class ToStringTest extends TestCase
{
    public function testConvertToString()
    {
        $this->assertSame('1', Digit::toString(1));
        $this->assertSame('1.3', Digit::toString(1.3));

        $this->assertSame('0', Digit::toString(0));
        $this->assertSame('0.3', Digit::toString(0.3));

        $this->assertSame('1234', Digit::toString(1234));
        $this->assertSame('1234.5', Digit::toString(1234.5));
    }
}
