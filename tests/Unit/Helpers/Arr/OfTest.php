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
use DragonCode\Support\Helpers\Ables\Arrayable;
use Tests\TestCase;

class OfTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame([], Arr::of()->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of());

        $this->assertSame([], Arr::of(null)->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of(null));

        $this->assertSame([], Arr::of([])->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of([]));

        $this->assertSame([], Arr::of('')->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of(''));
    }
}
