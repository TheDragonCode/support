<?php

namespace Tests\Exceptions;

use ArgumentCountError;
use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Tests\TestCase;

final class DirectoryNotFoundExceptionTest extends TestCase
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
