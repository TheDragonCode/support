<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Instances\Tools;

use DragonCode\Support\Exceptions\UnknownStubFileException;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Tools\Stub;
use DragonCode\Support\Tools\Stub as Tool;
use Tests\TestCase;

class StubTest extends TestCase
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

    public function testCustomStubSee()
    {
        $path = __DIR__ . '/../../../Fixtures/stubs/custom.stub';

        $this->assertTrue(Str::contains(Stub::get($path), '// Foo'));
        $this->assertTrue(Str::contains(Stub::get($path), '// Bar'));
        $this->assertTrue(Str::contains(Stub::get($path), '* Foo Bar'));
        $this->assertTrue(Str::contains(Stub::get($path), 'return {{slot}};'));
    }

    public function testGetThrow()
    {
        $this->expectException(UnknownStubFileException::class);
        $this->expectExceptionMessage('Unknown stub file: "foo"');

        Stub::get('foo');
    }
}
