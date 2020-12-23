<?php

namespace Tests\Fixtures;

final class Baz
{
    public $first = 'foo';

    public $second = 'bar';

    public function toArray()
    {
        return ['qwerty' => 'Qwerty'];
    }
}
