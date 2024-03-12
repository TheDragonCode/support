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

namespace Tests\Unit\Instances\Instance;

use DragonCode\Support\Facades\Instances\Instance;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class BasenameTest extends TestCase
{
    public function testBasename()
    {
        $this->assertSame('Foo', Instance::basename(Foo::class));
        $this->assertSame('Bar', Instance::basename(Bar::class));
        $this->assertSame('Bam', Instance::basename(Bam::class));

        $this->assertSame('Foo', Instance::basename(new Foo()));
        $this->assertSame('Bar', Instance::basename(new Bar()));
        $this->assertSame('Bam', Instance::basename(new Bam()));

        $this->assertNull(Instance::basename('foo'));
    }
}
