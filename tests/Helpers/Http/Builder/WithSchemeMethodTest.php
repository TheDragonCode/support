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

class WithSchemeMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertEmpty($builder->getScheme());

        $builder->withScheme($this->psr_scheme);

        $this->assertIsString($builder->getScheme());
        $this->assertSame($this->psr_scheme, $builder->getScheme());
    }

    public function testReplace()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_scheme, $builder->getScheme());

        $builder->withScheme('ws');

        $this->assertIsString($builder->getScheme());
        $this->assertSame('ws', $builder->getScheme());
    }
}
