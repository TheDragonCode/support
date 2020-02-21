<?php

namespace Helldar\Support\Exceptions;

use Exception;

class DirectoryNotFoundException extends Exception
{
    public function __construct(string $path)
    {
        $message = "Directory \"{$path}\" does not exist";

        parent::__construct($message, 500);
    }
}
