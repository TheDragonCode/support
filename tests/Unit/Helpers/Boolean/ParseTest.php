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

namespace Tests\Unit\Helpers\Boolean;

use DragonCode\Support\Facades\Helpers\Boolean;
use Tests\TestCase;

class ParseTest extends TestCase
{
    public function testParse(): void
    {
        $this->assertTrue(Boolean::parse(true));
        $this->assertTrue(Boolean::parse(1));
        $this->assertTrue(Boolean::parse('1'));
        $this->assertTrue(Boolean::parse('on'));
        $this->assertTrue(Boolean::parse('On'));
        $this->assertTrue(Boolean::parse('ON'));
        $this->assertTrue(Boolean::parse('yes'));
        $this->assertTrue(Boolean::parse('Yes'));
        $this->assertTrue(Boolean::parse('YES'));
        $this->assertTrue(Boolean::parse('true'));
        $this->assertTrue(Boolean::parse('True'));
        $this->assertTrue(Boolean::parse('TRUE'));

        $this->assertFalse(Boolean::parse(' '));
        $this->assertFalse(Boolean::parse(false));
        $this->assertFalse(Boolean::parse(0));
        $this->assertFalse(Boolean::parse('0'));
        $this->assertFalse(Boolean::parse('off'));
        $this->assertFalse(Boolean::parse('Off'));
        $this->assertFalse(Boolean::parse('OFF'));
        $this->assertFalse(Boolean::parse('no'));
        $this->assertFalse(Boolean::parse('No'));
        $this->assertFalse(Boolean::parse('NO'));
        $this->assertFalse(Boolean::parse('false'));
        $this->assertFalse(Boolean::parse('False'));
        $this->assertFalse(Boolean::parse('FALSE'));

        $this->assertNull(Boolean::parse('foo'));
        $this->assertNull(Boolean::parse('bar'));
        $this->assertNull(Boolean::parse('baz'));
        $this->assertNull(Boolean::parse([]));
        $this->assertNull(Boolean::parse(['foo', 'bar']));
    }
}
