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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsEmptyTest extends TestCase
{
    public function testIsEmpty()
    {
        $this->assertFalse(Arr::isEmpty(''));
        $this->assertFalse(Arr::isEmpty(' '));
        $this->assertFalse(Arr::isEmpty('      '));
        $this->assertFalse(Arr::isEmpty(null));

        $this->assertFalse(Arr::isEmpty(0));
        $this->assertFalse(Arr::isEmpty('   0   '));
        $this->assertFalse(Arr::isEmpty(false));

        $this->assertTrue(Arr::isEmpty([]));
        $this->assertTrue(Arr::isEmpty(new Foo()));

        $this->assertFalse(Arr::isEmpty(new Bar()));
        $this->assertFalse(Arr::isEmpty(new Bam()));
        $this->assertFalse(Arr::isEmpty(new Baq()));
        $this->assertFalse(Arr::isEmpty(new Arrayable()));
    }
}
