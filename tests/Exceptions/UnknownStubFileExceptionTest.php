<?php

namespace Tests\Exceptions;

use ArgumentCountError;
use Helldar\Support\Exceptions\UnknownStubFileException;
use Tests\TestCase;

final class UnknownStubFileExceptionTest extends TestCase
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
