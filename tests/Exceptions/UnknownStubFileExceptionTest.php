<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Exceptions;

use ArgumentCountError;
use Helldar\Support\Exceptions\UnknownStubFileException;
use Tests\TestCase;

class UnknownStubFileExceptionTest extends TestCase
{
    public function testPath()
    {
        $this->expectException(UnknownStubFileException::class);
        $this->expectExceptionMessage('Unknown stub file: "foo"');

        throw new UnknownStubFileException('foo');
    }

    public function testEmptyPath()
    {
        $this->expectException(UnknownStubFileException::class);
        $this->expectExceptionMessage('Unknown stub file: ""');

        throw new UnknownStubFileException(null);
    }

    public function testWithoutParameter()
    {
        $this->expectException(ArgumentCountError::class);

        throw new UnknownStubFileException();
    }
}
