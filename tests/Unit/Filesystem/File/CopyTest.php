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

class CopyTest extends TestCase
{
    public function testCopy()
    {
        $source = $this->tempDirectory('/foo/bar.txt');
        $target = $this->tempDirectory('/foo/baz.txt');

        $this->assertFalse(File::exists($source));
        $this->assertFalse(File::exists($target));

        File::store($source, 'foo');

        $this->assertTrue(File::exists($source));
        $this->assertFalse(File::exists($target));

        File::copy($source, $target);

        $this->assertTrue(File::exists($source));
        $this->assertTrue(File::exists($target));

        $this->assertSame('foo', file_get_contents($target));

        File::store($source, 'qwerty');
        File::copy($source, $target);

        $this->assertTrue(File::exists($source));
        $this->assertTrue(File::exists($target));

        $this->assertSame('qwerty', file_get_contents($target));
    }
}
