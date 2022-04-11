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

namespace Tests\Unit\Application\OS;

use DragonCode\Support\Facades\Application\OS;
use Tests\TestCase;

class IsDarwinTest extends TestCase
{
    public function testIsDarwin()
    {
        $this->assertFalse(OS::isDarwin());
    }
}
