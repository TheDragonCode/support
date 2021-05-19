<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Is as IsHelper;
use ReflectionClass;

class Reflection
{
    /**
     * Creates a ReflectionClass object.
     *
     * @param  object|ReflectionClass|string  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    public function resolve($class): ReflectionClass
    {
        return IsHelper::reflectionClass($class) ? $class : new ReflectionClass($class);
    }
}
