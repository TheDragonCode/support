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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class LtrimTest extends TestCase
{
    public function testTrim()
    {
        $this->assertSame('foo ', Str::ltrim(' foo '));
        $this->assertSame('foo', Str::ltrim(' foo'));
        $this->assertSame('foo ', Str::ltrim('foo '));
        $this->assertSame('foo', Str::ltrim('foo'));
        $this->assertSame('foo     ', Str::ltrim('     foo     '));
    }

    public function testCharacters()
    {
        $this->assertSame(' foo ', Str::ltrim(' foo ', ':'));
        $this->assertSame(' foo', Str::ltrim(' foo', ':'));
        $this->assertSame('foo ', Str::ltrim('foo ', ':'));
        $this->assertSame('foo', Str::ltrim('foo', ':'));
        $this->assertSame('     foo     ', Str::ltrim('     foo     ', ':'));

        $this->assertSame(' foo :', Str::ltrim(': foo :', ':'));
        $this->assertSame(' foo:', Str::ltrim(': foo:', ':'));
        $this->assertSame('foo :', Str::ltrim(':foo :', ':'));
        $this->assertSame('foo:', Str::ltrim(':foo:', ':'));
        $this->assertSame('     foo     :', Str::ltrim(':     foo     :', ':'));

        $this->assertSame(' :foo: ', Str::ltrim(' :foo: ', ':'));
        $this->assertSame(' :foo:', Str::ltrim(' :foo:', ':'));
        $this->assertSame('foo: ', Str::ltrim(':foo: ', ':'));
        $this->assertSame('foo:', Str::ltrim(':foo:', ':'));
        $this->assertSame('     :foo:     ', Str::ltrim('     :foo:     ', ':'));
    }
}
