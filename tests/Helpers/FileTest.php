<?php

namespace Tests\Helpers;

use function file_exists;
use Helldar\Support\Facades\File;

use function json_encode;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function testStore()
    {
        $path    = './build/foo/bar/baz/qwe.json';
        $content = json_encode(['foo', 'bar', 'baz']);

        File::store($path, $content);

        $this->assertTrue(file_exists($path));
        $this->assertJsonStringEqualsJsonFile($path, $content);
    }
}
