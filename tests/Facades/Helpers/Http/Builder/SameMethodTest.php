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

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use DragonCode\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\Facades\Helpers\Http\Base;

class SameMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, BuilderFacade::same());
        $this->assertInstanceOf(Builder::class, BuilderFacade::same()->parse($this->test_url)->same());
        $this->assertInstanceOf(Builder::class, BuilderFacade::parse($this->test_url)->same());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::same());
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::same()->parse($this->test_url)->same());
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::parse($this->test_url)->same());
    }
}
