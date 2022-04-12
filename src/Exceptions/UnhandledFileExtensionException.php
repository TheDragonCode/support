<?php

namespace DragonCode\Support\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class UnhandledFileExtensionException extends Exception
{
    #[Pure]
    public function __construct(?string $path)
    {
        parent::__construct('Unhandled file extension: ' . $path);
    }
}
