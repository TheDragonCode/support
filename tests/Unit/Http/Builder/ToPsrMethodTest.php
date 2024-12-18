<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Http\Builder;
use Psr\Http\Message\UriInterface;

class ToPsrMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, \DragonCode\Support\Facades\Http\Builder::toPsr());
        $this->assertInstanceOf(Builder::class, \DragonCode\Support\Facades\Http\Builder::same()->parse($this->test_url)->toPsr());
        $this->assertInstanceOf(Builder::class, \DragonCode\Support\Facades\Http\Builder::parse($this->test_url)->toPsr());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, \DragonCode\Support\Facades\Http\Builder::toPsr());
        $this->assertInstanceOf(UriInterface::class, \DragonCode\Support\Facades\Http\Builder::same()->parse($this->test_url)->toPsr());
        $this->assertInstanceOf(UriInterface::class, \DragonCode\Support\Facades\Http\Builder::parse($this->test_url)->toPsr());
    }
}
