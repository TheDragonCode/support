<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Is as IsHelper;
use ReflectionClass;

final class Reflection
{
    /**
     * Creates a ReflectionClass object.
     *
     * @param  string|object|ReflectionClass  $class
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
