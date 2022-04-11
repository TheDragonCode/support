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
use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class ValidatedTest extends TestCase
{
    public function testValidateSuccess()
    {
        File::validate($this->fixturesDirectory('.gitkeep'));

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(FileNotFoundException::class);

        File::validate($this->fixturesDirectory('foo/bar'));
    }

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory('.gitkeep');

        $result = File::validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(FileNotFoundException::class);

        File::validated($this->fixturesDirectory('foo/bar'));
    }
}
