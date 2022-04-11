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
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsEmptyTest extends TestCase
{
    public function testIsEmpty()
    {
        $this->assertTrue(Str::isEmpty(''));
        $this->assertTrue(Str::isEmpty(' '));
        $this->assertTrue(Str::isEmpty('      '));
        $this->assertTrue(Str::isEmpty(null));

        $this->assertFalse(Str::isEmpty(0));
        $this->assertFalse(Str::isEmpty('   0   '));
        $this->assertFalse(Str::isEmpty(false));
        $this->assertFalse(Str::isEmpty([]));

        $this->assertFalse(Str::isEmpty(new Foo()));
        $this->assertFalse(Str::isEmpty(new Bar()));
        $this->assertFalse(Str::isEmpty(new Bam()));
        $this->assertFalse(Str::isEmpty(new Baq()));
        $this->assertFalse(Str::isEmpty(new Arrayable()));
    }
}
