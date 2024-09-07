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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
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
        $this->assertTrue(Arr::isNotEmpty(''));
        $this->assertTrue(Arr::isNotEmpty(' '));
        $this->assertTrue(Arr::isNotEmpty('      '));
        $this->assertTrue(Arr::isNotEmpty(null));

        $this->assertTrue(Arr::isNotEmpty(0));
        $this->assertTrue(Arr::isNotEmpty('   0   '));
        $this->assertTrue(Arr::isNotEmpty(false));

        $this->assertFalse(Arr::isNotEmpty([]));
        $this->assertFalse(Arr::isNotEmpty(new Foo()));

        $this->assertTrue(Arr::isNotEmpty(new Bar()));
        $this->assertTrue(Arr::isNotEmpty(new Bam()));
        $this->assertTrue(Arr::isNotEmpty(new Baq()));
        $this->assertTrue(Arr::isNotEmpty(new Arrayable()));
    }
}
