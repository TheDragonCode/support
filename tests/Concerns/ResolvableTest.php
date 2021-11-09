<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Concerns;

use DragonCode\Support\Concerns\Resolvable;
use DragonCode\Support\Facades\Helpers\Str;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Instances\Bat;

class ResolvableTest extends TestCase
{
    use Resolvable;

    public function testResolveInstanceAsStringEmpty()
    {
        $this->clean();

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(Bat::class);

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(Bat::class);

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }

    public function testResolveInstanceAsString()
    {
        $this->clean();

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(Bat::class, 'Foo', 'Bar');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertSame('Foo', $resolved->foo);
        $this->assertSame('Bar', $resolved->bar);

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(Bat::class, 'Qwe', 'Rty');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertSame('Foo', $resolved->foo);
        $this->assertSame('Bar', $resolved->bar);
    }

    public function testResolveInstanceAsObjectEmpty()
    {
        $this->clean();

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(new Bat());

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(new Bat());

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }

    public function testResolveInstanceAsObject()
    {
        $this->clean();

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(new Bat(), 'Foo', 'Bar');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);

        /** @var \Tests\Fixtures\Instances\Bat $resolved */
        $resolved = self::resolveInstance(new Bat(), 'Qwe', 'Rty');

        $this->assertInstanceOf(Bat::class, $resolved);

        $this->assertNull($resolved->foo);
        $this->assertNull($resolved->bar);
    }

    public function testResolveCallback()
    {
        $this->clean();

        $resolved = self::resolveCallback('foo', static function (string $value) {
            return Str::upper($value);
        });

        $this->assertSame('FOO', $resolved);

        $resolved = self::resolveCallback('foo', static function () {
            return 123;
        });

        $this->assertSame('FOO', $resolved);
    }

    public function testGetSameClass()
    {
        $this->clean();

        $this->assertSame(static::class, self::getSameClass());
    }

    protected function clean(): void
    {
        self::$resolved = [];
    }
}
