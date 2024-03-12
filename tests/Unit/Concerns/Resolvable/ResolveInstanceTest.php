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

namespace Tests\Unit\Concerns\Resolvable;

use Tests\Fixtures\Instances\Bat;

class ResolveInstanceTest extends Base
{
    public function testResolveInstanceAsStringEmpty()
    {
        $this->clean();

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(Bat::class);

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(Bat::class);

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }

    public function testResolveInstanceAsString()
    {
        $this->clean();

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(Bat::class, 'Foo', 'Bar');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertSame('Foo', $resolved->foo);
        $this->assertSame('Bar', $resolved->bar);

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(Bat::class, 'Qwe', 'Rty');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertSame('Foo', $resolved->foo);
        $this->assertSame('Bar', $resolved->bar);
    }

    public function testResolveInstanceAsObjectEmpty()
    {
        $this->clean();

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(new Bat());

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(new Bat());

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }

    public function testResolveInstanceAsObject()
    {
        $this->clean();

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(new Bat(), 'Foo', 'Bar');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var Bat $resolved */
        $resolved = self::resolveInstance(new Bat(), 'Qwe', 'Rty');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }
}
