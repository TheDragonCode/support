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

namespace Tests\Unit\Filesystem\Directory;

use DragonCode\Support\Facades\Filesystem\Directory;
use Tests\TestCase;

class ExistsTest extends TestCase
{
    public function testExists()
    {
        $this->assertTrue(Directory::exists($this->fixturesDirectory()));

        $this->assertFalse(Directory::exists(__DIR__ . '/AllTest.php'));
    }
}
