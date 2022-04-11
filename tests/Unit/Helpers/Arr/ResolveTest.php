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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Bam;
use Tests\TestCase;

class ResolveTest extends TestCase
{
    public function testResolve()
    {
        $this->assertEquals(['foo', 'bar'], Arr::resolve(['foo', 'bar']));
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arr::resolve(['foo' => 'Foo', 'bar' => 'Bar']));
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arr::resolve((object) ['foo' => 'Foo', 'bar' => 'Bar']));
        $this->assertEquals(['foo'], Arr::resolve('foo'));

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], Arr::resolve(new Bar()));
        $this->assertEquals(['qwerty' => 'Qwerty'], Arr::resolve(new Bam()));

        $object = Arr::of(['first' => 'Foo', 'second' => 'Bar']);

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], Arr::resolve($object));

        $this->assertSame([Baq::class], Arr::resolve([Baq::class]));
    }
}
