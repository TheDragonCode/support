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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Stringable;
use Tests\TestCase;

class OfTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame('', (string) Str::of(''));
        $this->assertInstanceOf(Stringable::class, Str::of(''));

        $this->assertSame('', (string) Str::of(null));
        $this->assertInstanceOf(Stringable::class, Str::of(null));

        $this->assertSame('foo', (string) Str::of('foo'));
        $this->assertInstanceOf(Stringable::class, Str::of('foo'));
    }

    public function testSome()
    {
        $source = 'foo bar';

        $actual = Str::of($source)
            ->upper()
            ->explode(' ', Stringable::class)
            ->map(fn (Stringable $value) => $value->prepend(1)->append(2))
            ->implode('=')
            ->replace(['O', 'R'], 0)
            ->toString();

        $this->assertSame('1F002=1BA02', $actual);
    }
}
