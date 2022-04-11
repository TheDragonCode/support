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

namespace Tests\Unit\Instances\Instance;

use DragonCode\Support\Facades\Instances\Instance;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ClassnameTest extends TestCase
{
    public function testClassname()
    {
        $this->assertSame('Tests\Fixtures\Instances\Foo', Instance::classname(Foo::class));
        $this->assertSame('Tests\Fixtures\Instances\Bar', Instance::classname(Bar::class));
        $this->assertSame('Tests\Fixtures\Instances\Bam', Instance::classname(Bam::class));

        $this->assertSame('Tests\Fixtures\Instances\Foo', Instance::classname(new Foo()));
        $this->assertSame('Tests\Fixtures\Instances\Bar', Instance::classname(new Bar()));
        $this->assertSame('Tests\Fixtures\Instances\Bam', Instance::classname(new Bam()));

        $this->assertSame('Tests\Fixtures\Contracts\Contract', Instance::classname(Contract::class));

        $this->assertNull(Instance::classname('foo'));
    }
}
