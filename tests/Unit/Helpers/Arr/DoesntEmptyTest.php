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

class DoesntEmptyTest extends TestCase
{
    public function testDoesntEmpty()
    {
        $this->assertTrue(Arr::doesntEmpty(''));
        $this->assertTrue(Arr::doesntEmpty(' '));
        $this->assertTrue(Arr::doesntEmpty('      '));
        $this->assertTrue(Arr::doesntEmpty(null));

        $this->assertTrue(Arr::doesntEmpty(0));
        $this->assertTrue(Arr::doesntEmpty('   0   '));
        $this->assertTrue(Arr::doesntEmpty(false));

        $this->assertFalse(Arr::doesntEmpty([]));
        $this->assertFalse(Arr::doesntEmpty(new Foo()));

        $this->assertTrue(Arr::doesntEmpty(new Bar()));
        $this->assertTrue(Arr::doesntEmpty(new Bam()));
        $this->assertTrue(Arr::doesntEmpty(new Baq()));
        $this->assertTrue(Arr::doesntEmpty(new Arrayable()));
    }
}
