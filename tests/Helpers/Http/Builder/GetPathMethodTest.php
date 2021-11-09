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

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetPathMethodTest extends Base
{
    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());
    }
}
