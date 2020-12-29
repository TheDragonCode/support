<?php

namespace Tests\Facades\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;
use Helldar\Support\Facades\Tools\Stub;
use Helldar\Support\Tools\Stub as Tool;
use Tests\TestCase;

final class StubTest extends TestCase
{
    public function testReplacePhp()
    {
        $this->assertSame("<?php\n\nreturn {{slot}};\n", Stub::replace(Tool::PHP_ARRAY, []));
        $this->assertSame("<?php\n\nreturn 'foo';\n", Stub::replace(Tool::PHP_ARRAY, ['{{slot}}' => '\'foo\'']));
    }

    public function testReplaceJson()
    {
        $this->assertSame("{{slot}}\n", Stub::replace(Tool::JSON, []));
        $this->assertSame("foo\n", Stub::replace(Tool::JSON, ['{{slot}}' => 'foo']));
    }

    public function testGetPhp()
    {
        $this->assertSame("<?php\n\nreturn {{slot}};\n", Stub::get(Tool::PHP_ARRAY));
    }

    public function testGetJson()
    {
        $this->assertSame("{{slot}}\n", Stub::get(Tool::JSON));
    }

    public function testGetThrow()
    {
        $this->expectException(UnknownStubFileException::class);
        $this->expectExceptionMessage('Unknown stub file: "foo"');

        Stub::get('foo');
    }
}
