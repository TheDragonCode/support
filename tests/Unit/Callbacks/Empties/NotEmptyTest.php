<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Callbacks\Empties;

use DragonCode\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

class NotEmptyTest extends TestCase
{
    public function testFilter()
    {
        $callback = Empties::notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }
}
