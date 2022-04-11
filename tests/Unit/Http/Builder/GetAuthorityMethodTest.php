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

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class GetAuthorityMethodTest extends Base
{
    public function testUserPassword()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@en.example.com:8901', $builder->getAuthority());
    }

    public function testUser()
    {
        $builder = Builder::parse('https://foo@example.com:8901');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com:8901', $builder->getAuthority());
    }

    public function testFullWithoutPort()
    {
        $builder = Builder::parse('https://foo:bar@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@example.com', $builder->getAuthority());
    }

    public function testUserWithoutPort()
    {
        $builder = Builder::parse('https://foo@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com', $builder->getAuthority());
    }

    public function testEmpty()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('en.example.com', $builder->getAuthority());
    }
}
