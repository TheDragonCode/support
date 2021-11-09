<?php
/*
 * This file is part of the "dragon-code/support" project.
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
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Exceptions;

use LogicException;

class ForbiddenVariableTypeException extends LogicException
{
    public function __construct(string $haystack, $needles)
    {
        $needles = $this->needles($needles);

        $message = $this->message($haystack, $needles);

        parent::__construct($message);
    }

    protected function needles($needles): string
    {
        return is_string($needles) ? $needles : implode(', ', $needles);
    }

    protected function message(string $haystack, string $needles): string
    {
        return "Forbidden variable type: $needles needles, $haystack given.";
    }
}
