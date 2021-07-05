<?php

namespace Tests\Fixtures\Instances;

class Baz
{
    public $first = 'foo';

    public $second = 'bar';

    public function toArray()
    {
        return ['qwerty' => 'Qwerty'];
    }
}
