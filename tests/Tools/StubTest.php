<?php

namespace Tests\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;
use Helldar\Support\Tools\Stub as Tool;
use Tests\TestCase;

final class StubTest extends TestCase
{
    public function testReplacePhp()
    {
        $this->assertSame("<?php\n\nreturn {{slot}};\n", $this->stub()->replace(Tool::PHP_ARRAY, []));
        $this->assertSame("<?php\n\nreturn 'foo';\n", $this->stub()->replace(Tool::PHP_ARRAY, ['{{slot}}' => '\'foo\'']));
    }

    public function testReplaceJson()
    {
        $this->assertSame("{{slot}}\n", $this->stub()->replace(Tool::JSON, []));
        $this->assertSame("foo\n", $this->stub()->replace(Tool::JSON, ['{{slot}}' => 'foo']));
    }

    public function testGetPhp()
    {
        $this->assertSame("<?php\n\nreturn {{slot}};\n", $this->stub()->get(Tool::PHP_ARRAY));
    }

    public function testGetJson()
    {
        $this->assertSame("{{slot}}\n", $this->stub()->get(Tool::JSON));
    }

    public function testGetThrow()
    {
        $this->expectException(UnknownStubFileException::class);
        $this->expectExceptionMessage('Unknown stub file: "foo"');

        $this->stub()->get('foo');
    }

    protected function stub(): Tool
    {
        return new Tool();
    }
}
