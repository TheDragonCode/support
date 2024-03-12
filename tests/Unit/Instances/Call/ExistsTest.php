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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ExistsTest extends TestCase
{
    public function testExists()
    {
        $this->assertSame('ok', Call::runExists(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::runExists(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::runExists(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::runExists(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::runExists(static fn ($value) => $value, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::runExists(static fn ($value, ...$values): array => array_merge([$value], $values), 'foo', 'bar', 'baz'));
    }
}
