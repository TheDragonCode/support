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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\TestCase;

class FlipTest extends TestCase
{
    public function testFlip()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $target = [
            'Foo'     => 'foo',
            'Bar'     => 'bar',
            'Baz'     => 'baz',
            'Num 200' => 200,
            'Num 400' => 400,
        ];

        $this->assertSame($target, Arr::flip($source));
    }

    public function testFlipArrayable()
    {
        $expected_bar = [
            'Foo' => 'first',
            'Bar' => 'second',
        ];

        $expected_baz = [
            'Qwerty' => 'qwerty',
        ];

        $this->assertSame($expected_bar, Arr::flip(new Bar()));
        $this->assertSame($expected_baz, Arr::flip(new Bam()));
    }
}
