<?php

namespace Tests\Fixtures\Instances;

use Tests\Fixtures\Contracts\Contract;

class Foo implements Contract
{
    public static function callStatic()
    {
        return 'ok';
    }

    public function callDymamic()
    {
        return 'ok';
    }

    public function callEmpty()
    {
        return false;
    }

    public function callParameter(string $value): string
    {
        return 'foo_' . $value;
    }
}
