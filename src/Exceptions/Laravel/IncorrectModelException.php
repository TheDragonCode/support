<?php

namespace Helldar\Support\Exceptions\Laravel;

use Illuminate\Database\Eloquent\Model;

class IncorrectModelException extends \Exception
{
    public function __construct($model)
    {
        $actual  = \get_class($model);
        $message = \sprintf('Argument 1 must be an instance of %s, instance of %s given.', Model::class, $actual);

        parent::__construct($message, 500);
    }
}
