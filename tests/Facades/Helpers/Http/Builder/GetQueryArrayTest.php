<?php

/*
 * This file is part of the "dragon-code/support" project.
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
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types = 1);

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Helpers\Http\Base;

class GetQueryArrayTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsArray($builder->getQueryArray());
        $this->assertSame($this->psr_query_array, $builder->getQueryArray());
    }

    public function testWithout()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsArray($builder->getQueryArray());
        $this->assertEmpty($builder->getQueryArray());
    }
}
