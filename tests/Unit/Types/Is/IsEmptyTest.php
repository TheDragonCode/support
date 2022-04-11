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

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsEmptyTest extends TestCase
{
    public function testIsEmpty()
    {
        $this->assertTrue(Is::isEmpty(''));
        $this->assertTrue(Is::isEmpty(' '));
        $this->assertTrue(Is::isEmpty('      '));
        $this->assertTrue(Is::isEmpty(null));

        $this->assertFalse(Is::isEmpty(0));
        $this->assertFalse(Is::isEmpty('   0   '));
        $this->assertFalse(Is::isEmpty(false));

        $this->assertTrue(Is::isEmpty([]));
        $this->assertTrue(Is::isEmpty(new Foo()));

        $this->assertFalse(Is::isEmpty(new Bar()));
        $this->assertFalse(Is::isEmpty(new Bam()));
        $this->assertFalse(Is::isEmpty(new Baq()));
        $this->assertFalse(Is::isEmpty(new Arrayable()));
    }
}
