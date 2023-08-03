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

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use Exception;
use Tests\Fixtures\Instances\Bam;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    public function testError()
    {
        $this->assertTrue(Is::error(new Exception()));

        $this->assertFalse(Is::error(new Foo()));
        $this->assertFalse(Is::error(new Bar()));
        $this->assertFalse(Is::error(new Bam()));

        $this->assertFalse(Is::error('foo'));
    }
}
