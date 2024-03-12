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

class BeforeTest extends TestCase
{
    public function testBefore()
    {
        $this->assertSame('Foo', Str::before('Foo Bar', ' '));
        $this->assertSame('FoO', Str::before('FoO BaR', ' '));
        $this->assertSame('foo', Str::before('foo bar', ' '));
        $this->assertSame('FoO-BaR', Str::before('FoO-BaR', ' '));
        $this->assertSame('FoO   ', Str::before('FoO   -   BaR', '-'));
        $this->assertSame('FoO  ', Str::before('FoO   -   BaR', ' - '));
    }
}
