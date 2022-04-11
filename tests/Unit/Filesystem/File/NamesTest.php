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

namespace Tests\Unit\Filesystem\File;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class NamesTest extends TestCase
{
    public function testNames()
    {
        $available = ['.bar', '.beep', '.foo', '.gitkeep'];

        $names = File::names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesRecursive()
    {
        $available = [
            '.bar',
            '.beep',
            '.foo',
            '.gitkeep',
            'Concerns/Barable.php',
            'Concerns/Foable.php',
            'Contracts/Contract.php',
            'Exceptions/AnyException.php',
            'Facades/NotImplement.php',
            'Facades/Resolve.php',
            'Foo/Bar/.gitkeep',
            'Instances/Arrayable.php',
            'Instances/Bam.php',
            'Instances/Baq.php',
            'Instances/Bar.php',
            'Instances/Bat.php',
            'Instances/Foo.php',
            'Instances/Map.php',
            'Instances/Psr.php',
            'stubs/custom.stub',
        ];

        $names = File::names($this->fixturesDirectory(), null, true);

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['.beep', '.gitkeep'];

        $names = File::names(
            $this->fixturesDirectory(),
            static fn (string $name): bool => Str::endsWith($name, 'ep')
        );

        $this->assertSame($available, $names);
    }
}
