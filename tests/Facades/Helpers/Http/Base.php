<?php

namespace Tests\Facades\Helpers\Http;

use Tests\Fixtures\Instances\Psr;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected $test_url = 'https://en.example.com/';

    protected $psr_url = 'https://foo:bar@en.example.com:8901/foo/bar?id=123&name=hey#qwerty';

    protected $psr_scheme = 'https';

    protected $psr_user = 'foo';

    protected $psr_pass = 'bar';

    protected $psr_host = 'en.example.com';

    protected $psr_port = 8901;

    protected $psr_path = '/foo/bar';

    protected $psr_query = 'id=123&name=hey';

    protected $psr_fragment = 'qwerty';

    protected function psr(bool $empty = false): Psr
    {
        if ($empty) {
            return Psr::make();
        }

        return Psr::make()
            ->withScheme($this->psr_scheme)
            ->withUserInfo($this->psr_user, $this->psr_pass)
            ->withHost($this->psr_host)
            ->withPort($this->psr_port)
            ->withPath($this->psr_path)
            ->withQuery($this->psr_query)
            ->withFragment($this->psr_fragment);
    }
}
