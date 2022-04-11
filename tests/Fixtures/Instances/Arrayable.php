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

namespace Tests\Fixtures\Instances;

use ArrayAccess;

class Arrayable implements ArrayAccess
{
    protected array $values = [
        'foo' => 'Foo',
        'bar' => 'Bar',
        'baz' => 'Baz',
    ];

    public function offsetExists($offset): bool
    {
        return isset($this->values[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->values[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }
}
