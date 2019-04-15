<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\File;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function testStore()
    {
        $path    = './build/foo/bar/baz/qwe.json';
        $content = \json_encode(['foo', 'bar', 'baz']);

        File::store($path, $content);

        $this->assertTrue(\file_exists($path));
        $this->assertJsonStringEqualsJsonFile($path, $content);
    }

    public function testMakeDirectory()
    {
        $path = './build/foo/bar/baz';

        $result = File::makeDirectory($path);

        $this->assertTrue($result);
        $this->assertTrue(\is_dir($path));
    }
}
