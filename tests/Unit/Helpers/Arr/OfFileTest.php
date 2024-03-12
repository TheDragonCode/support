<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Exceptions\FileNotFoundException;
use DragonCode\Support\Exceptions\UnhandledFileExtensionException;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Helpers\Ables\Arrayable;
use Tests\TestCase;

class OfFileTest extends TestCase
{
    public function testPhp()
    {
        $expected = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $array = Arr::ofFile($this->fixturesDirectory('array.php'));

        $this->assertInstanceOf(Arrayable::class, $array);

        $this->assertSame($expected, $array->toArray());
    }

    public function testJson()
    {
        $expected = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $array = Arr::ofFile($this->fixturesDirectory('array.json'));

        $this->assertInstanceOf(Arrayable::class, $array);

        $this->assertSame($expected, $array->toArray());
    }

    public function testFileNotFoundException()
    {
        $path = $this->fixturesDirectory('unknown.php');

        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage('File "' . $path . '" does not exist.');

        Arr::ofFile($path);
    }

    public function testUnhandledException()
    {
        $path = $this->fixturesDirectory('.bar');

        $this->expectException(UnhandledFileExtensionException::class);
        $this->expectExceptionMessage('Unhandled file extension: ' . $path);

        Arr::ofFile($path);
    }
}
