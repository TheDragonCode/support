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

class IsTrueTest extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue(Boolean::isTrue(true));
        $this->assertTrue(Boolean::isTrue(1));
        $this->assertTrue(Boolean::isTrue('1'));
        $this->assertTrue(Boolean::isTrue('on'));
        $this->assertTrue(Boolean::isTrue('On'));
        $this->assertTrue(Boolean::isTrue('ON'));
        $this->assertTrue(Boolean::isTrue('yes'));
        $this->assertTrue(Boolean::isTrue('Yes'));
        $this->assertTrue(Boolean::isTrue('YES'));
        $this->assertTrue(Boolean::isTrue('true'));
        $this->assertTrue(Boolean::isTrue('True'));
        $this->assertTrue(Boolean::isTrue('TRUE'));

        $this->assertFalse(Boolean::isTrue(false));
        $this->assertFalse(Boolean::isTrue(0));
        $this->assertFalse(Boolean::isTrue('0'));
        $this->assertFalse(Boolean::isTrue('off'));
        $this->assertFalse(Boolean::isTrue('Off'));
        $this->assertFalse(Boolean::isTrue('OFF'));
        $this->assertFalse(Boolean::isTrue('no'));
        $this->assertFalse(Boolean::isTrue('No'));
        $this->assertFalse(Boolean::isTrue('NO'));
        $this->assertFalse(Boolean::isTrue('false'));
        $this->assertFalse(Boolean::isTrue('False'));
        $this->assertFalse(Boolean::isTrue('FALSE'));

        $this->assertFalse(Boolean::isTrue(null));
        $this->assertFalse(Boolean::isTrue(' '));
        $this->assertFalse(Boolean::isTrue('foo'));
        $this->assertFalse(Boolean::isTrue('bar'));
        $this->assertFalse(Boolean::isTrue('baz'));
        $this->assertFalse(Boolean::isTrue([]));
        $this->assertFalse(Boolean::isTrue(['foo', 'bar']));
    }
}
