<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Filesystem\File;

use DragonCode\Support\Exceptions\FileNotFoundException;
use DragonCode\Support\Exceptions\UnhandledFileExtensionException;
use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class LoadTest extends TestCase
{
    public function testPhp()
    {
        $expected = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $this->assertSame($expected, File::load($this->fixturesDirectory('array.php')));
    }

    public function testJson()
    {
        $expected = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $this->assertSame($expected, File::load($this->fixturesDirectory('array.json')));
    }

    public function testFileNotFoundException()
    {
        $path = $this->fixturesDirectory('unknown.php');

        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage('File "' . $path . '" does not exist.');

        File::load($path);
    }

    public function testUnhandledException()
    {
        $path = $this->fixturesDirectory('.bar');

        $this->expectException(UnhandledFileExtensionException::class);
        $this->expectExceptionMessage('Unhandled file extension: ' . $path);

        File::load($path);
    }
}
