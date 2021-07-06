<?php

namespace Helldar\Support\Exceptions;

use Exception;

class NotValidUrlException extends Exception
{
    public function __construct(?string $url)
    {
        $value = $this->value($url);

        $message = $this->message($value);

        parent::__construct($message, 412);
    }

    protected function value(?string $url): string
    {
        if (! empty($url)) {
            return 'The "' . $url . '"';
        }

        return 'Empty string';
    }

    protected function message(string $value): string
    {
        return $value . ' is not a valid URL.';
    }
}
