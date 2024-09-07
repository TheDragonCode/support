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
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

/** @deprecated */
class DoesntEmptyTest extends TestCase
{
    public function testDoesntEmpty()
    {
        $this->assertFalse(Is::doesntEmpty(''));
        $this->assertFalse(Is::doesntEmpty(' '));
        $this->assertFalse(Is::doesntEmpty('      '));
        $this->assertFalse(Is::doesntEmpty(null));

        $this->assertTrue(Is::doesntEmpty(0));
        $this->assertTrue(Is::doesntEmpty('   0   '));
        $this->assertTrue(Is::doesntEmpty(false));

        $this->assertFalse(Is::doesntEmpty([]));
        $this->assertFalse(Is::doesntEmpty(new Foo()));

        $this->assertTrue(Is::doesntEmpty(new Bar()));
        $this->assertTrue(Is::doesntEmpty(new Bam()));
        $this->assertTrue(Is::doesntEmpty(new Baq()));
        $this->assertTrue(Is::doesntEmpty(new Arrayable()));
    }
}
