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

namespace Tests\Unit\Tools\Replace;

use DragonCode\Support\Facades\Tools\Replace;
use Tests\TestCase;

class ToFormatTest extends TestCase
{
    public function testToFormat()
    {
        $this->assertSame('foo', Replace::toFormat('foo'));
        $this->assertSame('foo', Replace::toFormat('foo', ''));
        $this->assertSame('foo', Replace::toFormat('foo', '%s'));
        $this->assertSame('{foo}', Replace::toFormat('foo', '{%s}'));
        $this->assertSame('_foo_', Replace::toFormat('foo', '_%s_'));
    }
}
