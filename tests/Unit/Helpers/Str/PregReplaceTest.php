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

class PregReplaceTest extends TestCase
{
    public function testPregReplace()
    {
        $this->assertSame('', Str::pregReplace('', '!\s+!', ''));
        $this->assertSame('', Str::pregReplace(' ', '!\s+!', ''));
        $this->assertSame('', Str::pregReplace(null, '!\s+!', ''));

        $this->assertSame('foobar', Str::pregReplace('foo bar', '!\s+!', ''));
        $this->assertSame('foo-bar', Str::pregReplace('foo bar', '!\s+!', '-'));
        $this->assertSame('foo-bar', Str::pregReplace('foo     bar', '!\s+!', '-'));

        $this->assertSame('71234567890', Str::pregReplace('abc 7 (123)  456-78-90', '!(\W|\D)+!', ''));
    }
}
