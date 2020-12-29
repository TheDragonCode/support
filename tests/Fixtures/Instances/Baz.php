<?php

namespace Tests\Fixtures\Instances;

final class Baz
{
    public $first = 'foo';

    public $second = 'bar';

    public function toArray()
    {
        return ['qwerty' => 'Qwerty'];
    }
}
