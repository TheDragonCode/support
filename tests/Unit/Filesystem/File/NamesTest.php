<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
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

class NamesTest extends TestCase
{
    public function testNames()
    {
        $available = [
            '.bar',
            '.beep',
            '.foo',
            '.gitkeep',
            'array-incorrect.json',
            'array-incorrect.php',
            'array.json',
            'array.php',
        ];

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
            'Concerns' . DIRECTORY_SEPARATOR . 'Barable.php',
            'Concerns' . DIRECTORY_SEPARATOR . 'Foable.php',
            'Concerns' . DIRECTORY_SEPARATOR . 'NestedClass.php',
            'Concerns' . DIRECTORY_SEPARATOR . 'NestedLevel2.php',
            'Concerns' . DIRECTORY_SEPARATOR . 'NestedLevel3.php',
            'Concerns' . DIRECTORY_SEPARATOR . 'NestedLevel4.php',
            'Contracts' . DIRECTORY_SEPARATOR . 'Contract.php',
            'Exceptions' . DIRECTORY_SEPARATOR . 'AnyException.php',
            'Facades' . DIRECTORY_SEPARATOR . 'NotImplement.php',
            'Facades' . DIRECTORY_SEPARATOR . 'Resolve.php',
            'Foo' . DIRECTORY_SEPARATOR . 'Bar' . DIRECTORY_SEPARATOR . '.gitkeep',
            'Instances' . DIRECTORY_SEPARATOR . 'Arrayable.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Bam.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Baq.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Bar.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Bat.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Foo.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Invokable.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Map.php',
            'Instances' . DIRECTORY_SEPARATOR . 'Psr.php',
            'array-incorrect.json',
            'array-incorrect.php',
            'array.json',
            'array.php',
            'stubs' . DIRECTORY_SEPARATOR . 'custom.stub',
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
