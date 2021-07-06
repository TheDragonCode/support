<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class ToUrlMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame(rtrim($this->test_url, '/'), $builder->toUrl());
    }

    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame($this->psr_url, $builder->toUrl());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::toUrl());

        $this->assertSame('', BuilderFacade::toUrl());
    }
}
