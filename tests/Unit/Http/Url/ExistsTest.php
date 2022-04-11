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

use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Facades\Http\Url;

class ExistsTest extends Base
{
    public function testExists()
    {
        $this->assertTrue(Url::exists('https://google.com'));
        $this->assertTrue(Url::exists('https://yandex.com'));

        $this->assertFalse(Url::exists('https://a.a'));
        $this->assertFalse(Url::exists('https://b.b'));
    }

    public function testExistsNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        Url::exists(null);
    }

    public function testExistsUriInterface()
    {
        $uri = $this->builder();

        $this->assertTrue(Url::exists($uri));
    }
}
