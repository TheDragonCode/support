<?php

namespace Tests\Helpers\Http;

use Helldar\Support\Helpers\Http\Builder;
use Tests\TestCase;

class BuilderTest extends TestCase
{
    protected function builder(): Builder
    {
        return new Builder();
    }
}
