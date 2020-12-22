<?php

namespace Tests\Fixtures;

final class Foo implements Contract
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
}
