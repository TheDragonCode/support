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
use Helldar\Support\Exceptions\NotValidUrlException;
use Tests\TestCase;

class NotValidUrlExceptionTest extends TestCase
{
    public function testPath()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "example" is not a valid URL.');

        throw new NotValidUrlException('example');
    }

    public function testEmptyPath()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        throw new NotValidUrlException(null);
    }

    public function testWithoutParameter()
    {
        $this->expectException(ArgumentCountError::class);

        throw new NotValidUrlException();
    }
}
