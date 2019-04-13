<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Images;
use Tests\TestCase;

class ImagesTest extends TestCase
{
    public function testImageOrDefault()
    {
        $url_1 = 'http://example.com/foo/bar';
        $url_2 = 'http://example.com/foo/bar';

        $default = 'http://example.com/foo';

        $this->assertEquals($default, Images::imageOrDefault($url_1, $default));
        $this->assertEquals($default, Images::imageOrDefault($url_2, $default));
        $this->assertEquals(null, Images::imageOrDefault($url_2));
    }
}
