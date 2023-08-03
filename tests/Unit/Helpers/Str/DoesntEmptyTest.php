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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class DoesntEmptyTest extends TestCase
{
    public function testDoesntEmpty()
    {
        $this->assertFalse(Str::doesntEmpty(''));
        $this->assertFalse(Str::doesntEmpty(' '));
        $this->assertFalse(Str::doesntEmpty('      '));
        $this->assertFalse(Str::doesntEmpty(null));

        $this->assertTrue(Str::doesntEmpty(0));
        $this->assertTrue(Str::doesntEmpty('   0   '));
        $this->assertTrue(Str::doesntEmpty(false));
        $this->assertTrue(Str::doesntEmpty([]));

        $this->assertTrue(Str::doesntEmpty(new Foo()));
        $this->assertTrue(Str::doesntEmpty(new Bar()));
        $this->assertTrue(Str::doesntEmpty(new Bam()));
        $this->assertTrue(Str::doesntEmpty(new Baq()));
        $this->assertTrue(Str::doesntEmpty(new Arrayable()));
    }
}
