<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class GetQueryArrayTest extends Base
{
    public function testWith()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsArray($builder->getQueryArray());
        $this->assertSame($this->psr_query_array, $builder->getQueryArray());
    }

    public function testWithout()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsArray($builder->getQueryArray());
        $this->assertEmpty($builder->getQueryArray());
    }
}
