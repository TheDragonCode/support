<?php

namespace Helldar\Support\Exceptions;

use Exception;
use Helldar\Support\Traits\Deprecation;

class DirectoryNotFoundException extends Exception
{
    use Deprecation;

    public function __construct(string $path)
    {
        static::deprecatedMethodParameters(__FUNCTION__);

        $message = "Directory \"{$path}\" does not exist";

        parent::__construct($message, 500);
    }
}
