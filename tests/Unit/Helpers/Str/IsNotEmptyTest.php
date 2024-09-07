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
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsNotEmptyTest extends TestCase
{
    public function testIsNotEmpty()
    {
        $this->assertFalse(Str::isNotEmpty(''));
        $this->assertFalse(Str::isNotEmpty(' '));
        $this->assertFalse(Str::isNotEmpty('      '));
        $this->assertFalse(Str::isNotEmpty(null));

        $this->assertTrue(Str::isNotEmpty(0));
        $this->assertTrue(Str::isNotEmpty('   0   '));
        $this->assertTrue(Str::isNotEmpty(false));
        $this->assertTrue(Str::isNotEmpty([]));

        $this->assertTrue(Str::isNotEmpty(new Foo()));
        $this->assertTrue(Str::isNotEmpty(new Bar()));
        $this->assertTrue(Str::isNotEmpty(new Bam()));
        $this->assertTrue(Str::isNotEmpty(new Baq()));
        $this->assertTrue(Str::isNotEmpty(new Arrayable()));
    }
}
