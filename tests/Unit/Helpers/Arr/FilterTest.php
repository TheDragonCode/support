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
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class FilterTest extends TestCase
{
    public function testFilter()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $target = [
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
        ];

        $result = Arr::filter(
            $source,
            static fn ($value, $key): bool => Str::contains($value, 200) || Str::startsWith($key, 'b'),
            ARRAY_FILTER_USE_BOTH
        );

        $this->assertSame($target, $result);
    }
}
