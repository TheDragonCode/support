<?php

namespace Tests\Exceptions;

use ArgumentCountError;
use Helldar\Support\Exceptions\FileNotFoundException;
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
