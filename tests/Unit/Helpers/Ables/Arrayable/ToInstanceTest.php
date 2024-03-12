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

namespace Tests\Unit\Helpers\Ables\Arrayable;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Invokable;
use Tests\Fixtures\Instances\Map;
use Tests\TestCase;

class ToInstanceTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Map::class, Arr::of([])->toInstance(Map::class));

        $this->assertSame(['foo' => 'Foo'], Arr::of(['foo' => 'Foo'])->toInstance(Map::class)->values);
    }

    public function testInvokable()
    {
        $this->assertInstanceOf(Invokable::class, Arr::of([])->toInstance(Invokable::class));

        $this->assertSame(['foo' => 'Foo'], Arr::of(['foo' => 'Foo'])->toInstance(Invokable::class)->values);
    }
}
