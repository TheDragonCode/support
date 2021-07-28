<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Helldar\Support\Exceptions;

use LogicException;

class UnknownUrlComponentIndexException extends LogicException
{
    public function __construct(int $component)
    {
        parent::__construct('Unknown URL component index: ' . $component);
    }
}
