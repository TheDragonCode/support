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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class MatchTest extends TestCase
{
    public function testMatch()
    {
        $this->assertSame('bar', Str::match('foo bar', '/bar/'));
        $this->assertSame('bar', Str::match('foo bar', '/foo (.*)/'));

        $this->assertNull(Str::match('foo bar', '/nothing/'));
    }
}
