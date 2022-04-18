<?php

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class TrimTest extends TestCase
{
    public function testTrim()
    {
        $this->assertSame('foo', Str::trim(' foo '));
        $this->assertSame('foo', Str::trim(' foo'));
        $this->assertSame('foo', Str::trim('foo '));
        $this->assertSame('foo', Str::trim('foo'));
        $this->assertSame('foo', Str::trim('     foo     '));
    }

    public function testCharacters()
    {
        $this->assertSame(' foo ', Str::trim(' foo ', ':'));
        $this->assertSame(' foo', Str::trim(' foo', ':'));
        $this->assertSame('foo ', Str::trim('foo ', ':'));
        $this->assertSame('foo', Str::trim('foo', ':'));
        $this->assertSame('     foo     ', Str::trim('     foo     ', ':'));

        $this->assertSame(' foo ', Str::trim(': foo :', ':'));
        $this->assertSame(' foo', Str::trim(': foo:', ':'));
        $this->assertSame('foo ', Str::trim(':foo :', ':'));
        $this->assertSame('foo', Str::trim(':foo:', ':'));
        $this->assertSame('     foo     ', Str::trim(':     foo     :', ':'));

        $this->assertSame(' :foo: ', Str::trim(' :foo: ', ':'));
        $this->assertSame(' :foo', Str::trim(' :foo:', ':'));
        $this->assertSame('foo: ', Str::trim(':foo: ', ':'));
        $this->assertSame('foo', Str::trim(':foo:', ':'));
        $this->assertSame('     :foo:     ', Str::trim('     :foo:     ', ':'));
    }
}
