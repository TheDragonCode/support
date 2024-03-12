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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class RunOfTest extends TestCase
{
    public function testRunOf()
    {
        $this->assertSame(
            'ok',
            Call::runOf([
                Contract::class => 'callDymamic',
            ], new Foo())
        );

        $this->assertSame(
            'ok',
            Call::runOf([
                'Unknown'       => 'unknown',
                Contract::class => 'callDymamic',
            ], new Foo())
        );

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], new Foo(), 'foo'));

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], new Foo()));

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], 'foo'));
    }
}
