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

namespace Tests\Unit\Callbacks;

use DragonCode\Support\Callbacks\Empties;
use Tests\TestCase;

class EmptiesTest extends TestCase
{
    public function testFilter()
    {
        $callback = $this->call()->notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }

    public function testFilterBoth()
    {
        $callback = $this->call()->notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }

    protected function call(): Empties
    {
        return new Empties();
    }
}
