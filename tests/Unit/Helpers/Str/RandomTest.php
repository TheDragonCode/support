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

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class RandomTest extends TestCase
{
    public function testRandom()
    {
        $this->assertEquals(16, strlen(Str::random()));

        $randomInteger = random_int(1, 100);

        $this->assertEquals($randomInteger, strlen(Str::random($randomInteger)));

        $this->assertIsString(Str::random());
    }
}
