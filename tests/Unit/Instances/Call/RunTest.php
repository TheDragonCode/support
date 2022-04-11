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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use InvalidArgumentException;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class RunTest extends TestCase
{
    public function testRun()
    {
        $this->assertSame('ok', Call::run(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::run(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::run(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::run(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::run(static fn ($value) => $value, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::run(static fn ($value, ...$values): array => array_merge([$value], $values), 'foo', 'bar', 'baz'));
    }

    public function testWrong()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument #1 must be either a class reference or an instance of a class, string given.');

        Call::run('foo', 'bar');
    }
}
