<?php

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
        $this->expectExceptionMessage('The "" is not a valid URL.');

        throw new NotValidUrlException(null);
    }

    public function testWithoutParameter()
    {
        $this->expectException(ArgumentCountError::class);

        throw new NotValidUrlException();
    }
}
