<?php

namespace Tests\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;
use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Tools\Stub as Tool;
use Tests\TestCase;

class StubTest extends TestCase
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

    public function testCustomStubSee()
    {
        $path = __DIR__ . '/../Fixtures/stubs/custom.stub';

        $this->assertTrue(Str::contains($this->stub()->get($path), '// Foo'));
        $this->assertTrue(Str::contains($this->stub()->get($path), '// Bar'));
        $this->assertTrue(Str::contains($this->stub()->get($path), '* Foo Bar'));
        $this->assertTrue(Str::contains($this->stub()->get($path), 'return {{slot}};'));
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
