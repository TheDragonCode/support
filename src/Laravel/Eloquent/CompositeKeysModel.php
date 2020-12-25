<?php

namespace Helldar\Support\Laravel\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Instead, use `Helldar\LaravelSupport\Eloquent\CompositeKeysModel`
 * from `andrey-helldar/laravel-support` package.
 *
 * @deprecated Will be removed from version 2.0
 */
abstract class CompositeKeysModel extends Model
{
    public $incrementing = false;

    /**
     * ATTENTION!
     *
     * Be sure to fill in the columns.
     *
     * @var array
     */
    protected $primaryKey = [];

    public function getAttribute($key)
    {
        return ! is_array($key)
            ? parent::getAttribute($key)
            : null;
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->primaryKey;

        if (! is_array($keys)) {
            return $query->where($keys, $this->getAttribute($keys));
        }

        foreach ($keys as $key) {
            $query->where($key, $this->getAttribute($key));
        }

        return $query;
    }
}
