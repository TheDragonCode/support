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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class WhenTest extends TestCase
{
    public function testWhenTrue()
    {
        $this->assertSame('ok', Call::when(true, Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::when(true, Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::when(true, new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::when(true, new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::when(true, static fn ($value) => $value, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::when(true, static fn ($value, ...$values): array => array_merge([$value], $values), 'foo', 'bar', 'baz'));
    }

    public function testWhenFalse()
    {
        $this->assertNull(Call::when(false, Foo::class, 'callStatic'));
        $this->assertNull(Call::when(false, Foo::class, 'callParameter', 'bar'));

        $this->assertNull(Call::when(false, new Foo(), 'callStatic'));
        $this->assertNull(Call::when(false, new Foo(), 'callParameter', 'bar'));

        $this->assertNull(Call::when(false, static fn ($value) => $value, 'foo'));

        $this->assertNull(Call::when(false, static fn ($value, ...$values): array => array_merge([$value], $values), 'foo', 'bar', 'baz'));
    }
}
