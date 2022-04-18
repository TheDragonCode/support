<?php

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
