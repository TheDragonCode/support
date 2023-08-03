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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class ReplaceTest extends TestCase
{
    public function testReplace()
    {
        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', Str::replace('foo', ['a', 's'], ['Z', 'X']));
        $this->assertSame('fQQ', Str::replace('foo', ['a', 's', 'o'], ['Z', 'X', 'Q']));
        $this->assertSame('Eoo', Str::replace('foo', ['a', 's', 'f'], ['Z', 'X', 'E']));
        $this->assertSame('EPP', Str::replace('foo', ['a', 's', 'f', 'o'], ['Z', 'X', 'E', 'P']));

        $this->assertSame('f00', Str::replace('foo', 'o', '0'));
    }
}
