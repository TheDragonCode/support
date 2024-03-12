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

class AfterTest extends TestCase
{
    public function testAfter()
    {
        $this->assertSame('Bar', Str::after('Foo Bar', ' '));
        $this->assertSame('BaR', Str::after('FoO BaR', ' '));
        $this->assertSame('bar', Str::after('foo bar', ' '));
        $this->assertSame('FoO-BaR', Str::after('FoO-BaR', ' '));
        $this->assertSame('   BaR', Str::after('FoO   -   BaR', '-'));
        $this->assertSame('  BaR', Str::after('FoO   -   BaR', ' - '));
    }
}
