<?php

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class RtrimTest extends TestCase
{
    public function testTrim()
    {
        $this->assertSame(' foo', Str::rtrim(' foo '));
        $this->assertSame(' foo', Str::rtrim(' foo'));
        $this->assertSame('foo', Str::rtrim('foo '));
        $this->assertSame('foo', Str::rtrim('foo'));
        $this->assertSame('     foo', Str::rtrim('     foo     '));
    }

    public function testCharacters()
    {
        $this->assertSame(' foo ', Str::rtrim(' foo ', ':'));
        $this->assertSame(' foo', Str::rtrim(' foo', ':'));
        $this->assertSame('foo ', Str::rtrim('foo ', ':'));
        $this->assertSame('foo', Str::rtrim('foo', ':'));
        $this->assertSame('     foo     ', Str::rtrim('     foo     ', ':'));

        $this->assertSame(': foo ', Str::rtrim(': foo :', ':'));
        $this->assertSame(': foo', Str::rtrim(': foo:', ':'));
        $this->assertSame(':foo ', Str::rtrim(':foo :', ':'));
        $this->assertSame(':foo', Str::rtrim(':foo:', ':'));
        $this->assertSame(':     foo     ', Str::rtrim(':     foo     :', ':'));

        $this->assertSame(' :foo: ', Str::rtrim(' :foo: ', ':'));
        $this->assertSame(' :foo', Str::rtrim(' :foo:', ':'));
        $this->assertSame(':foo: ', Str::rtrim(':foo: ', ':'));
        $this->assertSame(':foo', Str::rtrim(':foo:', ':'));
        $this->assertSame('     :foo:     ', Str::rtrim('     :foo:     ', ':'));
    }
}
