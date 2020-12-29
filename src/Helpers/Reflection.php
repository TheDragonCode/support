<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Is;
use ReflectionClass;

final class Reflection
{
    /**
     * Creates a ReflectionClass object.
     *
     * @param  object|ReflectionClass  $class
     *
     * @return \ReflectionClass
     */
    public function resolve($class): ReflectionClass
    {
        return Is::reflectionClass($class) ? $class : new ReflectionClass($class);
    }
}
