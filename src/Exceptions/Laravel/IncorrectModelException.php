<?php

namespace Helldar\Support\Exceptions\Laravel;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Instead, use `Helldar\LaravelSupport\Exceptions\IncorrectModelException`
 * from `andrey-helldar/laravel-support` package.
 *
 * @deprecated Will be removed from version 2.0
 */
class IncorrectModelException extends Exception
{
    public function __construct($model)
    {
        $actual  = get_class($model);
        $message = sprintf('Argument 1 must be an instance of %s, instance of %s given.', Model::class, $actual);

        parent::__construct($message, 500);
    }
}
