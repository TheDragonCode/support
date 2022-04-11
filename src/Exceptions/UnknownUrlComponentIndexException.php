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

namespace DragonCode\Support\Exceptions;

use JetBrains\PhpStorm\Pure;
use LogicException;

class UnknownUrlComponentIndexException extends LogicException
{
    #[Pure]
    public function __construct(int $component)
    {
        parent::__construct('Unknown URL component index: ' . $component);
    }
}
