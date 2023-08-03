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

namespace Tests\Unit\Exceptions;

use ArgumentCountError;
use DragonCode\Support\Exceptions\FileNotFoundException;
use Tests\TestCase;

class FileNotFoundExceptionTest extends TestCase
{
    public function testPath()
    {
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage('File "foo/bar" does not exist.');

        throw new FileNotFoundException('foo/bar');
    }

    public function testEmptyPath()
    {
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage('File "" does not exist.');

        throw new FileNotFoundException(null);
    }

    public function testWithoutParameter()
    {
        $this->expectException(ArgumentCountError::class);

        throw new FileNotFoundException();
    }
}
