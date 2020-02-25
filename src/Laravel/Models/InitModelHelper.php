<?php

namespace Helldar\Support\Laravel\Models;

use Helldar\Support\Exceptions\MethodNotFoundException;
use Illuminate\Container\Container;

trait InitModelHelper
{
    /** @var \Helldar\Support\Laravel\Models\ModelHelper */
    protected static $model_helper;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Helldar\Support\Laravel\Models\ModelHelper
     */
    protected static function model(): ModelHelper
    {
        if (static::$model_helper === null) {
            static::$model_helper = Container::getInstance()
                ->make(ModelHelper::class);
        }

        return static::$model_helper;
    }

    public function __call($name, $arguments)
    {
        if (! \method_exists(self::class, $name)) {
            throw new MethodNotFoundException(\class_basename(self::class), $name);
        }

        return $name === 'model'
            ? static::model()
            : $this->{$name}(...$arguments);
    }
}
