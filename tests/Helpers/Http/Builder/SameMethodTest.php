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

namespace Tests\Helpers\Http\Builder;

use Helldar\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\Helpers\Http\Base;

class SameMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, $this->builder()->same());
        $this->assertInstanceOf(Builder::class, $this->builder()->same()->parse($this->test_url)->same());
        $this->assertInstanceOf(Builder::class, $this->builder()->parse($this->test_url)->same());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, $this->builder()->same());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->same()->parse($this->test_url)->same());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->parse($this->test_url)->same());
    }
}
