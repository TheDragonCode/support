<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Callbacks\Empties;

use DragonCode\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

class NotFilterBothTest extends TestCase
{
    public function testFilterBoth()
    {
        $callback = Empties::notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }
}
