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

namespace Tests\Unit\Filesystem\File;

use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class ExistsTest extends TestCase
{
    public function testExists()
    {
        $this->assertFalse(File::exists($this->fixturesDirectory()));
        $this->assertFalse(File::exists($this->fixturesDirectory('foo.bar')));

        $this->assertTrue(File::exists($this->fixturesDirectory('Contracts/Contract.php')));
    }
}
