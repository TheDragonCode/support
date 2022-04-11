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

namespace DragonCode\Support\Facades\Application;

use DragonCode\Support\Application\Version as Helper;
use DragonCode\Support\Facades\Facade;

/**
 * @method static Helper of(string $version)
 * @method static bool eq(string $version)
 * @method static bool equalTo(string $version)
 * @method static bool greaterThan(string $version)
 * @method static bool greaterThanOrEqualTo(string $version)
 * @method static bool gt(string $version)
 * @method static bool gte(string $version)
 * @method static bool lessThan(string $version)
 * @method static bool lessThanOrEqualTo(string $version)
 * @method static bool lt(string $version)
 * @method static bool lte(string $version)
 * @method static bool ne(string $version)
 * @method static bool notEqualTo(string $version)
 */
class Version extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
