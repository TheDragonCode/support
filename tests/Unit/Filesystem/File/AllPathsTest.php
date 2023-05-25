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

namespace Tests\Unit\Filesystem\File;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class AllPathsTest extends TestCase
{
    public function testNames()
    {
        $available = [
            realpath($this->fixturesDirectory('.bar')),
            realpath($this->fixturesDirectory('.beep')),
            realpath($this->fixturesDirectory('.foo')),
            realpath($this->fixturesDirectory('.gitkeep')),
            realpath($this->fixturesDirectory('array-incorrect.json')),
            realpath($this->fixturesDirectory('array-incorrect.php')),
            realpath($this->fixturesDirectory('array.json')),
            realpath($this->fixturesDirectory('array.php')),
        ];

        $names = File::allPaths($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesRecursive()
    {
        $available = [
            realpath($this->fixturesDirectory('.bar')),
            realpath($this->fixturesDirectory('.beep')),
            realpath($this->fixturesDirectory('.foo')),
            realpath($this->fixturesDirectory('.gitkeep')),
            realpath($this->fixturesDirectory('Concerns/Barable.php')),
            realpath($this->fixturesDirectory('Concerns/Foable.php')),
            realpath($this->fixturesDirectory('Concerns/NestedClass.php')),
            realpath($this->fixturesDirectory('Concerns/NestedLevel2.php')),
            realpath($this->fixturesDirectory('Concerns/NestedLevel3.php')),
            realpath($this->fixturesDirectory('Concerns/NestedLevel4.php')),
            realpath($this->fixturesDirectory('Contracts/Contract.php')),
            realpath($this->fixturesDirectory('Exceptions/AnyException.php')),
            realpath($this->fixturesDirectory('Facades/NotImplement.php')),
            realpath($this->fixturesDirectory('Facades/Resolve.php')),
            realpath($this->fixturesDirectory('Foo/Bar/.gitkeep')),
            realpath($this->fixturesDirectory('Instances/Arrayable.php')),
            realpath($this->fixturesDirectory('Instances/Bam.php')),
            realpath($this->fixturesDirectory('Instances/Baq.php')),
            realpath($this->fixturesDirectory('Instances/Bar.php')),
            realpath($this->fixturesDirectory('Instances/Bat.php')),
            realpath($this->fixturesDirectory('Instances/Foo.php')),
            realpath($this->fixturesDirectory('Instances/Invokable.php')),
            realpath($this->fixturesDirectory('Instances/Map.php')),
            realpath($this->fixturesDirectory('Instances/Psr.php')),
            realpath($this->fixturesDirectory('array-incorrect.json')),
            realpath($this->fixturesDirectory('array-incorrect.php')),
            realpath($this->fixturesDirectory('array.json')),
            realpath($this->fixturesDirectory('array.php')),
            realpath($this->fixturesDirectory('stubs/custom.stub')),
        ];

        $names = File::allPaths($this->fixturesDirectory(), null, true);

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = [
            realpath($this->fixturesDirectory('.beep')),
            realpath($this->fixturesDirectory('.gitkeep')),
        ];

        $names = File::allPaths(
            $this->fixturesDirectory(),
            static fn (string $name): bool => Str::endsWith($name, 'ep')
        );

        $this->assertSame($available, $names);
    }
}
