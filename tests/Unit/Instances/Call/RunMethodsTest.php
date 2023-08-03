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
use Tests\Fixtures\Exceptions\AnyException;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class RunMethodsTest extends TestCase
{
    public function testRunMethods()
    {
        $this->assertSame('ok', Call::runMethods(Foo::class, 'callStatic'));
        $this->assertSame('ok', Call::runMethods(Foo::class, ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', Call::runMethods(Foo::class, 'callParameter', 'bar'));
        $this->assertSame('foo_bar', Call::runMethods(Foo::class, ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('ok', Call::runMethods(new Foo(), 'callStatic'));
        $this->assertSame('ok', Call::runMethods(new Foo(), ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', Call::runMethods(new Foo(), 'callParameter', 'bar'));
        $this->assertSame('foo_bar', Call::runMethods(new Foo(), ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('foo', Call::runMethods(static fn ($value) => $value, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::runMethods(static fn ($value, ...$values): array => array_merge([$value], $values), 'foo', 'bar', 'baz'));

        $this->assertSame('Foo Bar', Call::runMethods(new AnyException(), 'getMessage'));
    }
}
