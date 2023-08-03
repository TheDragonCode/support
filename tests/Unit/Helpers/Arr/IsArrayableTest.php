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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Arrayable;
use Tests\TestCase;

class IsArrayableTest extends TestCase
{
    public function testIsArrayable()
    {
        $this->assertTrue(Arr::isArrayable([]));
        $this->assertTrue(Arr::isArrayable(['foo']));
        $this->assertTrue(Arr::isArrayable(new Arrayable()));
    }
}
