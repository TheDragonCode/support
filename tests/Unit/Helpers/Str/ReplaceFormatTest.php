<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
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

class ReplaceFormatTest extends TestCase
{
    public function testReplaceFormat()
    {
        $this->assertSame('foo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('bZr', Str::replaceFormat('bar', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('bZr', Str::replaceFormat('bar', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('bZr', Str::replaceFormat('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('bZr', Str::replaceFormat('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('foo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('foo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('foo', Str::replaceFormat('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZr', Str::replaceFormat('b{a}r', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('bZr', Str::replaceFormat('b{a}r', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('bZr', Str::replaceFormat('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('bZr', Str::replaceFormat('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZz', Str::replaceFormat('b_a_z', ['a' => 'Z', 's' => 'X'], '_%s_'));
        $this->assertSame('bZz', Str::replaceFormat('b_a_z', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '_%s_'));
        $this->assertSame('bZz', Str::replaceFormat('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '_%s_'));
        $this->assertSame('bZz', Str::replaceFormat('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '_%s_'));
    }
}
