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

namespace Tests\Facades\Callbacks;

use Helldar\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

class EmptiesTest extends TestCase
{
    public function testFilter()
    {
        $callback = Empties::notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }

    public function testFilterBoth()
    {
        $callback = Empties::notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }
}
