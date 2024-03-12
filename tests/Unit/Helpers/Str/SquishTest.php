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

class SquishTest extends TestCase
{
    public function testSquish()
    {
        $this->assertEquals('foo bar', Str::squish('foo bar'));
        $this->assertEquals('foo bar', Str::squish('foo  bar'));
        $this->assertEquals('foo bar', Str::squish('foo    bar'));

        $this->assertEquals('foo bar baz', Str::squish('foo bar  baz'));
        $this->assertEquals('foo bar baz', Str::squish('foo  bar     baz'));
        $this->assertEquals('foo bar baz', Str::squish('foo    bar baz'));

        $this->assertSame('the dragon code', Str::squish(' the   dragon  code '));
        $this->assertSame('the dragon code', Str::squish("the\t\tdragon\n\ncode"));
        $this->assertSame('the dragon code', Str::squish('   the   dragon   code   '));

        $this->assertSame(
            'the dragon code',
            Str::squish('
            the
            dragon
            code
        ')
        );

        $this->assertSame('the dragon code', Str::squish('theᅠᅠᅠᅠᅠᅠᅠᅠᅠᅠdragonᅠᅠcode'));

        $this->assertSame('123', Str::squish('   123    '));
        $this->assertSame('だ', Str::squish('だ'));
        $this->assertSame('ム', Str::squish('ム'));
        $this->assertSame('だ', Str::squish('   だ    '));
        $this->assertSame('ム', Str::squish('   ム    '));

        $this->assertSame('the dragon code', Str::squish('theㅤㅤㅤdragonㅤcode'));
    }
}
