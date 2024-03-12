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

declare(strict_types=1);

namespace Tests\Unit\Http\Url;

use DragonCode\Support\Facades\Http\Url;
use DragonCode\Support\Http\Builder;
use Psr\Http\Message\UriInterface;

class ParseTest extends Base
{
    public function testParse()
    {
        $url = 'https://github.githubassets.com/pinned-octocat.svg';

        $parsed = Url::parse($url);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testParseUriInterface()
    {
        $builder = $this->builder();

        $parsed = Url::parse($builder);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }
}
