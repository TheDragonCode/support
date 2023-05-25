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

namespace Tests\Unit\Tools\Stub;

use DragonCode\Support\Exceptions\UnknownStubFileException;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Tools\Stub;
use DragonCode\Support\Tools\Stub as Tool;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testGetPhp()
    {
        $this->assertSame("<?php\n\ndeclare(strict_types=1);\n\nreturn {{slot}};\n", Stub::get(Tool::PHP));
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
