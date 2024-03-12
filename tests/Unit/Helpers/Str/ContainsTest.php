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

class ContainsTest extends TestCase
{
    public function testStrContains()
    {
        $this->assertTrue(Str::contains('qwerty', 'ert'));
        $this->assertTrue(Str::contains('qwerty', 'qwerty'));
        $this->assertTrue(Str::contains('qwerty', ['ert']));
        $this->assertTrue(Str::contains('qwerty', ['xxx', 'ert']));

        $this->assertFalse(Str::contains('qwerty', 'xxx'));
        $this->assertFalse(Str::contains('qwerty', ['xxx']));
        $this->assertFalse(Str::contains('qwerty', ''));
        $this->assertFalse(Str::contains('qwerty', null));
        $this->assertFalse(Str::contains('qwerty', [null]));
        $this->assertFalse(Str::contains('qwerty', [0]));
        $this->assertFalse(Str::contains('qwerty', ['0']));
        $this->assertFalse(Str::contains('qwerty', 0));
        $this->assertFalse(Str::contains('qwerty', '0'));
        $this->assertFalse(Str::contains('', ''));
    }
}
