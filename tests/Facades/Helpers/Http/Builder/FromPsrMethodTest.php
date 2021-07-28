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

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class FromPsrMethodTest extends Base
{
    public function testFull()
    {
        $psr = $this->psr();

        $builder = BuilderFacade::fromPsr($psr);

        $this->assertSame($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_user, $builder->getUser());
        $this->assertSame($this->psr_pass, $builder->getPassword());
        $this->assertSame($this->psr_host, $builder->getHost());
        $this->assertSame($this->psr_port, $builder->getPort());
        $this->assertSame($this->psr_path, $builder->getPath());
        $this->assertSame($this->psr_query, $builder->getQuery());
        $this->assertSame($this->psr_fragment, $builder->getFragment());

        $this->assertIsString($builder->getScheme());
        $this->assertIsString($builder->getUser());
        $this->assertIsString($builder->getPassword());
        $this->assertIsString($builder->getHost());
        $this->assertIsString($builder->getPath());
        $this->assertIsString($builder->getQuery());
        $this->assertIsString($builder->getFragment());

        $this->assertIsNumeric($builder->getPort());
    }

    public function testEmpty()
    {
        $psr = $this->psr(true);

        $builder = BuilderFacade::fromPsr($psr);

        $this->assertEmpty($builder->getScheme());
        $this->assertEmpty($builder->getUser());
        $this->assertEmpty($builder->getPassword());
        $this->assertEmpty($builder->getHost());
        $this->assertEmpty($builder->getPort());
        $this->assertEmpty($builder->getPath());
        $this->assertEmpty($builder->getQuery());
        $this->assertEmpty($builder->getFragment());

        $this->assertNull($builder->getPort());
    }
}
