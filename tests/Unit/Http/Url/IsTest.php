<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Http\Url;

use DragonCode\Support\Facades\Http\Url;

class IsTest extends Base
{
    public function testIs()
    {
        $this->assertTrue(Url::is('https://localhost'));
        $this->assertTrue(Url::is('https://foo.bar'));
        $this->assertTrue(Url::is('https://example.com'));
        $this->assertTrue(Url::is('http://example.com'));
        $this->assertTrue(Url::is('ftp://example.com'));
        $this->assertTrue(Url::is('ws://example.com'));

        $this->assertTrue(Url::is($this->builder()));

        $this->assertFalse(Url::is('localhost'));
        $this->assertFalse(Url::is('://foo.bar'));
        $this->assertFalse(Url::is('//example.com'));
    }

    public function testDynamicParams()
    {
        $this->assertTrue(Url::is('https://localhost?param=%s'));

        $this->assertTrue(Url::is('https://localhost?' . http_build_query([
            'param' => '%s',
            'arr'   => ['foo', 'bar'],
        ])));
    }
}
