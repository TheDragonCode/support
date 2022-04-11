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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class ReplaceTest extends TestCase
{
    public function testReplace()
    {
        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('bZr', Str::replace('bar', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('bZr', Str::replace('bar', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('bZr', Str::replace('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('bZr', Str::replace('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('foo', Str::replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZr', Str::replace('b{a}r', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('bZr', Str::replace('b{a}r', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('bZr', Str::replace('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('bZr', Str::replace('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZz', Str::replace('b_a_z', ['a' => 'Z', 's' => 'X'], '_%s_'));
        $this->assertSame('bZz', Str::replace('b_a_z', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '_%s_'));
        $this->assertSame('bZz', Str::replace('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '_%s_'));
        $this->assertSame('bZz', Str::replace('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '_%s_'));
    }
}
