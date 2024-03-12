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

namespace Tests\Unit\Helpers\Boolean;

use DragonCode\Support\Facades\Helpers\Boolean;
use Tests\TestCase;

class IsFalseTest extends TestCase
{
    public function testIsFalse(): void
    {
        $this->assertTrue(Boolean::isFalse(null));
        $this->assertTrue(Boolean::isFalse(false));
        $this->assertTrue(Boolean::isFalse(0));
        $this->assertTrue(Boolean::isFalse('0'));
        $this->assertTrue(Boolean::isFalse('off'));
        $this->assertTrue(Boolean::isFalse('Off'));
        $this->assertTrue(Boolean::isFalse('OFF'));
        $this->assertTrue(Boolean::isFalse('no'));
        $this->assertTrue(Boolean::isFalse('No'));
        $this->assertTrue(Boolean::isFalse('NO'));
        $this->assertTrue(Boolean::isFalse('false'));
        $this->assertTrue(Boolean::isFalse('False'));
        $this->assertTrue(Boolean::isFalse('FALSE'));

        $this->assertFalse(Boolean::isFalse(true));
        $this->assertFalse(Boolean::isFalse(1));
        $this->assertFalse(Boolean::isFalse('1'));
        $this->assertFalse(Boolean::isFalse('on'));
        $this->assertFalse(Boolean::isFalse('On'));
        $this->assertFalse(Boolean::isFalse('ON'));
        $this->assertFalse(Boolean::isFalse('yes'));
        $this->assertFalse(Boolean::isFalse('Yes'));
        $this->assertFalse(Boolean::isFalse('YES'));
        $this->assertFalse(Boolean::isFalse('true'));
        $this->assertFalse(Boolean::isFalse('True'));
        $this->assertFalse(Boolean::isFalse('TRUE'));

        $this->assertTrue(Boolean::isFalse(' '));
        $this->assertTrue(Boolean::isFalse('foo'));
        $this->assertTrue(Boolean::isFalse('bar'));
        $this->assertTrue(Boolean::isFalse('baz'));
        $this->assertTrue(Boolean::isFalse([]));
        $this->assertTrue(Boolean::isFalse(['foo', 'bar']));
    }
}
