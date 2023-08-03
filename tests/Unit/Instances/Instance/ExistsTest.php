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

namespace Tests\Unit\Instances\Instance;

use DragonCode\Support\Facades\Instances\Instance;
use Tests\Fixtures\Concerns\Foable;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ExistsTest extends TestCase
{
    public function testExists()
    {
        $this->assertTrue(Instance::exists(new Foo()));
        $this->assertTrue(Instance::exists(new Bar()));
        $this->assertTrue(Instance::exists(new Bam()));

        $this->assertTrue(Instance::exists(Foo::class));
        $this->assertTrue(Instance::exists(Bar::class));
        $this->assertTrue(Instance::exists(Bam::class));

        $this->assertTrue(Instance::exists(Contract::class));

        $this->assertTrue(Instance::exists(Foable::class));

        $this->assertFalse(Instance::exists('foo'));
    }
}
