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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\TestCase;

class ValuesTest extends TestCase
{
    public function testValues()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $expected = [
            'Foo',
            'Bar',
            'Baz',
            'Num 200',
            'Num 400',
        ];

        $this->assertSame($expected, Arr::values($source));
    }

    public function testValuesArrayable()
    {
        $expected_bar = [
            'Foo',
            'Bar',
        ];

        $expected_baz = [
            'Qwerty',
        ];

        $this->assertSame($expected_bar, Arr::values(new Bar()));
        $this->assertSame($expected_baz, Arr::values(new Bam()));
    }
}
