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
use Tests\TestCase;

class BooleanTest extends TestCase
{
    public function testIsBoolean()
    {
        $this->assertTrue(Is::boolean(true));
        $this->assertTrue(Is::boolean(1));
        $this->assertTrue(Is::boolean('1'));
        $this->assertTrue(Is::boolean('on'));
        $this->assertTrue(Is::boolean('On'));
        $this->assertTrue(Is::boolean('ON'));
        $this->assertTrue(Is::boolean('yes'));
        $this->assertTrue(Is::boolean('Yes'));
        $this->assertTrue(Is::boolean('YES'));
        $this->assertTrue(Is::boolean('true'));
        $this->assertTrue(Is::boolean('True'));
        $this->assertTrue(Is::boolean('TRUE'));

        $this->assertTrue(Is::boolean(false));
        $this->assertTrue(Is::boolean(0));
        $this->assertTrue(Is::boolean('0'));
        $this->assertTrue(Is::boolean('off'));
        $this->assertTrue(Is::boolean('Off'));
        $this->assertTrue(Is::boolean('OFF'));
        $this->assertTrue(Is::boolean('no'));
        $this->assertTrue(Is::boolean('No'));
        $this->assertTrue(Is::boolean('NO'));
        $this->assertTrue(Is::boolean('false'));
        $this->assertTrue(Is::boolean('False'));
        $this->assertTrue(Is::boolean('FALSE'));

        $this->assertFalse(Is::boolean(null));
        $this->assertFalse(Is::boolean('foo'));
        $this->assertFalse(Is::boolean('bar'));
        $this->assertFalse(Is::boolean('baz'));
        $this->assertFalse(Is::boolean('qwerty'));
        $this->assertFalse(Is::boolean(['foo']));
        $this->assertFalse(Is::boolean(['foo', 'bar']));
        $this->assertFalse(Is::boolean([]));
    }
}
