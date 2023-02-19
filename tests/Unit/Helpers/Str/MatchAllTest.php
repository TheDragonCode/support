<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class MatchAllTest extends TestCase
{
    public function testMatchAll()
    {
        $this->assertSame(['ba', 'bb'], Str::matchAll('foo bar bbq', '/b[a-d]/'));
        $this->assertSame(['bar baq'], Str::matchAll('foo bar baq', '/foo (.*)/'));

        $this->assertNull(Str::matchAll('foo bar', '/nothing/'));
    }
}
