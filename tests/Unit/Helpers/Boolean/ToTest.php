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

namespace Tests\Unit\Helpers\Boolean;

use DragonCode\Support\Facades\Helpers\Boolean;
use Tests\TestCase;

class ToTest extends TestCase
{
    public function testTo(): void
    {
        $this->assertTrue(Boolean::to(true));
        $this->assertTrue(Boolean::to(1));
        $this->assertTrue(Boolean::to('1'));
        $this->assertTrue(Boolean::to('on'));
        $this->assertTrue(Boolean::to('On'));
        $this->assertTrue(Boolean::to('ON'));
        $this->assertTrue(Boolean::to('yes'));
        $this->assertTrue(Boolean::to('Yes'));
        $this->assertTrue(Boolean::to('YES'));
        $this->assertTrue(Boolean::to('true'));
        $this->assertTrue(Boolean::to('True'));
        $this->assertTrue(Boolean::to('TRUE'));

        $this->assertFalse(Boolean::to(false));
        $this->assertFalse(Boolean::to(0));
        $this->assertFalse(Boolean::to('0'));
        $this->assertFalse(Boolean::to('off'));
        $this->assertFalse(Boolean::to('Off'));
        $this->assertFalse(Boolean::to('OFF'));
        $this->assertFalse(Boolean::to('no'));
        $this->assertFalse(Boolean::to('No'));
        $this->assertFalse(Boolean::to('NO'));
        $this->assertFalse(Boolean::to('false'));
        $this->assertFalse(Boolean::to('False'));
        $this->assertFalse(Boolean::to('FALSE'));

        $this->assertFalse(Boolean::to(' '));
        $this->assertFalse(Boolean::to('foo'));
        $this->assertFalse(Boolean::to('bar'));
        $this->assertFalse(Boolean::to('baz'));
        $this->assertFalse(Boolean::to([]));
        $this->assertFalse(Boolean::to(['foo', 'bar']));
    }
}
