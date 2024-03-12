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

namespace Tests\Unit\Filesystem\Directory;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class NamesTest extends TestCase
{
    public function testNames()
    {
        $available = ['Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

        $names = Directory::names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesRecursive()
    {
        $available = [
            'Concerns',
            'Contracts',
            'Exceptions',
            'Facades',
            'Foo',
            'Foo' . DIRECTORY_SEPARATOR . 'Bar',
            'Instances',
            'stubs',
        ];

        $names = Directory::names($this->fixturesDirectory(), null, true);

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['Facades', 'Instances'];

        $names = Directory::names(
            $this->fixturesDirectory(),
            static fn (string $name): bool => Str::endsWith($name, 'es')
        );

        $this->assertSame($available, $names);
    }
}
