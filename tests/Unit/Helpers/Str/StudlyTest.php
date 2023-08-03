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

class StudlyTest extends TestCase
{
    public function testStudly()
    {
        $this->assertSame('FooBar', Str::studly('Foo Bar'));
        $this->assertSame('FoOBaR', Str::studly('FoO BaR'));
        $this->assertSame('FooBar', Str::studly('foo bar'));
        $this->assertSame('FoOBaR', Str::studly('FoO-BaR'));
        $this->assertSame('FoOBaR', Str::studly('FoO   -   BaR'));
    }
}
