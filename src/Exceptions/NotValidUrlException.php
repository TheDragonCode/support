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

use Exception;
use JetBrains\PhpStorm\Pure;

class NotValidUrlException extends Exception
{
    #[Pure]
    public function __construct(?string $url)
    {
        $value = $this->value($url);

        $message = $this->message($value);

        parent::__construct($message, 412);
    }

    protected function value(?string $url): string
    {
        return ! empty($url) ? 'The "' . $url . '"' : 'Empty string';
    }

    protected function message(string $value): string
    {
        return $value . ' is not a valid URL.';
    }
}
