<?php

namespace Helldar\Support\Laravel\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use function is_array;

abstract class CompositeKeysModel extends Model
{
    public $incrementing = false;

    /**
     * Required!
     *
     * @var array
     */
    protected $primaryKey = [];

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
