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

class AllPathsTest extends TestCase
{
    public function testPaths()
    {
        $available = [
            realpath($this->fixturesDirectory('Concerns')),
            realpath($this->fixturesDirectory('Contracts')),
            realpath($this->fixturesDirectory('Exceptions')),
            realpath($this->fixturesDirectory('Facades')),
            realpath($this->fixturesDirectory('Foo')),
            realpath($this->fixturesDirectory('Instances')),
            realpath($this->fixturesDirectory('stubs')),
        ];

        $names = Directory::allPaths($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testPathsRecursive()
    {
        $available = [
            realpath($this->fixturesDirectory('Concerns')),
            realpath($this->fixturesDirectory('Contracts')),
            realpath($this->fixturesDirectory('Exceptions')),
            realpath($this->fixturesDirectory('Facades')),
            realpath($this->fixturesDirectory('Foo')),
            realpath($this->fixturesDirectory('Foo/Bar')),
            realpath($this->fixturesDirectory('Instances')),
            realpath($this->fixturesDirectory('stubs')),
        ];

        $names = Directory::allPaths($this->fixturesDirectory(), recursive: true);

        $this->assertSame($available, $names);
    }

    public function testPathsCallback()
    {
        $available = [
            realpath($this->fixturesDirectory('Facades')),
            realpath($this->fixturesDirectory('Instances')),
        ];

        $names = Directory::allPaths(
            $this->fixturesDirectory(),
            static fn (string $name): bool => Str::endsWith($name, 'es')
        );

        $this->assertSame($available, $names);
    }
}
