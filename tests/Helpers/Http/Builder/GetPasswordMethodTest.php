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

class GetPasswordMethodTest extends Base
{
    public function testWith()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getPassword());
        $this->assertSame($this->psr_pass, $builder->getPassword());
    }

    public function testWithout()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getPassword());
        $this->assertEmpty($builder->getPassword());
    }

    public function testOnlyUser()
    {
        $builder = $this->builder()->parse('https://foo@example.com');

        $this->assertIsString($builder->getPassword());
        $this->assertEmpty($builder->getPassword());
    }
}
