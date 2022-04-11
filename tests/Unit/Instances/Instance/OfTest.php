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

namespace Tests\Unit\Instances\Instance;

use DragonCode\Support\Facades\Instances\Instance;
use Tests\Fixtures\Concerns\Barable;
use Tests\Fixtures\Concerns\Foable;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Bat;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class OfTest extends TestCase
{
    public function testOf()
    {
        // Foo
        $this->assertTrue(Instance::of(Foo::class, Foo::class));
        $this->assertFalse(Instance::of(Foo::class, Bar::class));
        $this->assertTrue(Instance::of(Foo::class, Contract::class));
        $this->assertTrue(Instance::of(Foo::class, Foable::class));

        $this->assertTrue(Instance::of(new Foo(), Foo::class));
        $this->assertFalse(Instance::of(new Foo(), Bar::class));
        $this->assertTrue(Instance::of(new Foo(), Contract::class));
        $this->assertTrue(Instance::of(new Foo(), Foable::class));

        // Bar
        $this->assertTrue(Instance::of(Bar::class, Bar::class));
        $this->assertFalse(Instance::of(Bar::class, Foo::class));
        $this->assertFalse(Instance::of(Bar::class, Contract::class));
        $this->assertFalse(Instance::of(Bar::class, Foable::class));

        $this->assertTrue(Instance::of(new Bar(), Bar::class));
        $this->assertFalse(Instance::of(new Bar(), Foo::class));
        $this->assertFalse(Instance::of(new Bar(), Contract::class));
        $this->assertFalse(Instance::of(new Bar(), Foable::class));

        // Baz
        $this->assertTrue(Instance::of(Bam::class, Bat::class));
        $this->assertTrue(Instance::of(Bam::class, Contract::class));
        $this->assertTrue(Instance::of(new Bam(), Bat::class));
        $this->assertTrue(Instance::of(new Bam(), Contract::class));
        $this->assertTrue(Instance::of(new Bam(), Foable::class));
    }

    public function testOfClass()
    {
        $this->assertTrue(Instance::of(Bam::class, Bat::class));
        $this->assertTrue(Instance::of(Bam::class, Foable::class));
        $this->assertTrue(Instance::of(Bam::class, Contract::class));

        $this->assertFalse(Instance::of(Bam::class, Barable::class));
    }

    public function testOfTrait()
    {
        $this->assertTrue(Instance::of(Foable::class, Foable::class));

        $this->assertFalse(Instance::of(Foable::class, Bat::class));
        $this->assertFalse(Instance::of(Foable::class, Barable::class));
        $this->assertFalse(Instance::of(Foable::class, Contract::class));
    }

    public function testOfInterface()
    {
        $this->assertTrue(Instance::of(Contract::class, Contract::class));

        $this->assertFalse(Instance::of(Contract::class, Bat::class));
        $this->assertFalse(Instance::of(Contract::class, Foable::class));
        $this->assertFalse(Instance::of(Contract::class, Barable::class));
    }
}
