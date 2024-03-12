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

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class StringTest extends TestCase
{
    public function testString()
    {
        $this->assertTrue(Is::string('foo'));
        $this->assertTrue(Is::string('bar'));
        $this->assertTrue(Is::string('baz'));

        $this->assertTrue(Is::string(Foo::class));
        $this->assertTrue(Is::string(Bar::class));
        $this->assertTrue(Is::string(Bam::class));

        $this->assertFalse(Is::string(new Foo()));
        $this->assertFalse(Is::string(new Bar()));
        $this->assertFalse(Is::string(new Bam()));
    }
}
