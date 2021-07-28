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

class GetBaseUrlMethodTest extends Base
{
    public function testFull()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getBaseUrl());
        $this->assertSame('https://en.example.com', $builder->getBaseUrl());
    }

    public function testOnlyHost()
    {
        $builder = $this->builder()->parsed(['host' => 'example.com']);

        $this->assertIsString($builder->getBaseUrl());
        $this->assertSame('example.com', $builder->getBaseUrl());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getBaseUrl());
        $this->assertEmpty($builder->getBaseUrl());
    }
}
