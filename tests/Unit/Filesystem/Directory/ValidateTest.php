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

namespace Tests\Unit\Filesystem\Directory;

use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Facades\Filesystem\Directory;
use Tests\TestCase;

class ValidateTest extends TestCase
{
    public function testValidateSuccess()
    {
        Directory::validate($this->fixturesDirectory());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        Directory::validate($this->fixturesDirectory('qwe/rty'));
    }

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory();

        $result = Directory::validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        Directory::validated($this->fixturesDirectory('qwe/rty'));
    }
}
