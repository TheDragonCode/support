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

class CamelTest extends TestCase
{
    public function testCamel()
    {
        $this->assertSame('fooBar', Str::camel('Foo Bar'));
        $this->assertSame('foOBaR', Str::camel('FoO BaR'));
        $this->assertSame('fooBar', Str::camel('foo bar'));
        $this->assertSame('foOBaR', Str::camel('FoO-BaR'));
        $this->assertSame('foOBaR', Str::camel('FoO   -   BaR'));
    }
}
