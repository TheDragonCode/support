<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetAuthorityMethodTest extends Base
{
    public function testUserPassword()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@en.example.com:8901', $builder->getAuthority());
    }

    public function testUser()
    {
        $builder = $this->builder()->parse('https://foo@example.com:8901');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com:8901', $builder->getAuthority());
    }

    public function testFullWithoutPort()
    {
        $builder = $this->builder()->parse('https://foo:bar@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@example.com', $builder->getAuthority());
    }

    public function testUserWithoutPort()
    {
        $builder = $this->builder()->parse('https://foo@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com', $builder->getAuthority());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('en.example.com', $builder->getAuthority());
    }
}
