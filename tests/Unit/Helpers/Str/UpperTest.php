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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class UpperTest extends TestCase
{
    public function testUpper()
    {
        $this->assertSame('FOO BAR BAZ', Str::upper('FOO BAR BAZ'));
        $this->assertSame('FOO BAR BAZ', Str::upper('fOo Bar bAz'));
    }
}
