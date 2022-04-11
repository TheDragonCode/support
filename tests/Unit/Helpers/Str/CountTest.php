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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class CountTest extends TestCase
{
    public function testCount()
    {
        $this->assertSame(2, Str::count('foo bar baz', ' '));
        $this->assertSame(2, Str::count('foo bar baz', 'b'));
        $this->assertSame(1, Str::count('foo bar baz', 'f'));
        $this->assertSame(1, Str::count('foo bar baz', 'bar'));
        $this->assertSame(1, Str::count('foo bar baz', 'foo'));

        $this->assertSame(1, Str::count('foo bar baz', ' ', 4));
        $this->assertSame(2, Str::count('foo bar baz', 'b', 4));
        $this->assertSame(0, Str::count('foo bar baz', 'f', 4));
        $this->assertSame(1, Str::count('foo bar baz', 'bar', 4));
        $this->assertSame(0, Str::count('foo bar baz', 'foo', 4));
    }
}
