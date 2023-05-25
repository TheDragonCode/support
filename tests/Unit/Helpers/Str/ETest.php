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

class ETest extends TestCase
{
    public function testE()
    {
        $this->assertSame('foo&quot;bar', Str::e('foo"bar'));
        $this->assertSame('foo&amp;bar', Str::e('foo&bar'));
        $this->assertSame('foo&#039;bar', Str::e('foo\'bar'));
        $this->assertSame('foo&#039;bar', Str::e("foo'bar"));
        $this->assertSame('foo\&#039;bar', Str::e('foo\\\'bar'));

        $this->assertSame('Foo-&gt;bar with space', Str::e('Foo->bar with space'));
        $this->assertSame('A#symbol^and%a$few@special!chars~`', Str::e('A#symbol^and%a$few@special!chars~`'));
    }
}
