<?php

namespace Tests;

use Helldar\Support\Helpers\Files;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testStore()
    {
        $path    = './build/foo/bar/baz/qwe.json';
        $content = \json_encode(['foo', 'bar', 'baz']);

        Files::store($path, $content);

        $this->assertTrue(\file_exists($path));
        $this->assertJsonStringEqualsJsonFile($path, $content);
    }

    public function testMakeDirectory()
    {
        $path = './build/foo/bar/baz';

        $result = Files::makeDirectory($path);

        $this->assertTrue($result);
        $this->assertTrue(\is_dir($path));
    }
}
