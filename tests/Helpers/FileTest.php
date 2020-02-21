<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\File;
use Tests\TestCase;

use function file_exists;
use function json_encode;

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
