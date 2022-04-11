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

use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function testDeleteAsString()
    {
        $path = $this->tempDirectory('foo.bar');

        File::store($path, 'foo');

        $this->assertFileExists($path);

        File::delete($path);

        $this->assertFalse(File::exists($path));
    }

    public function testDeleteAsArray()
    {
        $path1 = $this->tempDirectory('foo1');
        $path2 = $this->tempDirectory('foo2');
        $path3 = $this->tempDirectory('foo3');

        File::store($path1, 'foo');
        File::store($path2, 'foo');
        File::store($path3, 'foo');

        $this->assertFileExists($path1);
        $this->assertFileExists($path2);
        $this->assertFileExists($path3);

        File::delete([$path1, $path2, $path3]);

        $this->assertFalse(File::exists($path1));
        $this->assertFalse(File::exists($path2));
        $this->assertFalse(File::exists($path3));
    }
}
