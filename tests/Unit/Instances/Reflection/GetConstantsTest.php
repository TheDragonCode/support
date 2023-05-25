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

namespace Tests\Unit\Instances\Reflection;

use DragonCode\Support\Facades\Instances\Reflection;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class GetConstantsTest extends TestCase
{
    public function testConstants()
    {
        $expected = [
            'FOO' => 'Foo',
            'BAR' => 'Bar',
            'BAZ' => 'Baz',
        ];

        $this->assertSame($expected, Reflection::getConstants(Foo::class));
        $this->assertSame($expected, Reflection::getConstants(new Foo()));
    }
}
