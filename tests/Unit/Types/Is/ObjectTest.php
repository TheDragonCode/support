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

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ObjectTest extends TestCase
{
    public function testObject()
    {
        $this->assertFalse(Is::object('foo'));
        $this->assertFalse(Is::object('bar'));
        $this->assertFalse(Is::object('baz'));

        $this->assertFalse(Is::object(Foo::class));
        $this->assertFalse(Is::object(Bar::class));
        $this->assertFalse(Is::object(Bam::class));

        $this->assertTrue(Is::object(new Foo()));
        $this->assertTrue(Is::object(new Bar()));
        $this->assertTrue(Is::object(new Bam()));
    }
}
