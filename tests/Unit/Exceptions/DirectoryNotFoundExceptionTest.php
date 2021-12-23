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

namespace Tests\Unit\Exceptions;

use ArgumentCountError;
use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use Tests\TestCase;

class DirectoryNotFoundExceptionTest extends TestCase
{
    public function testPath()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "qwe/rty" does not exist.');

        throw new DirectoryNotFoundException('qwe/rty');
    }

    public function testEmptyPath()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "" does not exist.');

        throw new DirectoryNotFoundException(null);
    }

    public function testWithoutParameter()
    {
        $this->expectException(ArgumentCountError::class);

        throw new DirectoryNotFoundException();
    }
}
