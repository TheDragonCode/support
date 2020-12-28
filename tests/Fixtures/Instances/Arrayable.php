<?php

namespace Tests\Fixtures\Instances;

use ArrayAccess;

class Arrayable implements ArrayAccess
{
    protected $values = [
        'foo' => 'Foo',
        'bar' => 'Bar',
        'baz' => 'Baz',
    ];

    public function offsetExists($offset): bool
    {
        return isset($this->values[$offset]);
    }

    public function offsetGet($offset)
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
