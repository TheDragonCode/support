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

namespace Tests\Unit\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;
use Tests\TestCase;

class DefaultTest extends TestCase
{
    public function testDefaultCallback()
    {
        $callback = Sorter::default();

        $this->assertIsCallable($callback);

        $this->assertSame(0, $callback(0, 0));
        $this->assertSame(0, $callback('0', '0'));
        $this->assertSame(0, $callback('foo', 'foo'));

        $this->assertSame(-1, $callback('#', 2));
        $this->assertSame(1, $callback('foo', 2));

        $this->assertSame(1, $callback(2, '#'));
        $this->assertSame(-1, $callback(2, 'foo'));

        $this->assertSame(-1, $callback('a', 'b'));
        $this->assertSame(-1, $callback('foo', 'foz'));
        $this->assertSame(-1, $callback('baz', 'qwe'));

        $this->assertSame(1, $callback('b', 'a'));
        $this->assertSame(1, $callback('foz', 'foo'));
        $this->assertSame(1, $callback('qwe', 'baz'));
    }
}
