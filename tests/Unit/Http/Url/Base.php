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

namespace Tests\Unit\Http\Url;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use DragonCode\Support\Http\Builder;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected string $test_url = 'https://example.com';

    protected function builder(): Builder
    {
        return BuilderFacade::parse($this->test_url);
    }
}
