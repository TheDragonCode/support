<?php

namespace Helldar\Support\Exceptions\Laravel;

use Exception;
use Helldar\Support\Traits\Deprecation;
use Illuminate\Database\Eloquent\Model;

/**
 * Instead, use `Helldar\LaravelSupport\Exceptions\IncorrectModelException`
 * from `andrey-helldar/laravel-support` package.
 *
 * @deprecated Will be removed from version 2.0.
 */
class IncorrectModelException extends Exception
{
    use Deprecation;

    public function __construct($model)
    {
        static::deprecatedClass();

        $actual  = get_class($model);
        $message = sprintf('Argument 1 must be an instance of %s, instance of %s given.', Model::class, $actual);

        parent::__construct($message, 500);
    }
}
