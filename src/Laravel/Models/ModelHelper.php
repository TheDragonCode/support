<?php

namespace Helldar\Support\Laravel\Models;

use Helldar\Support\Exceptions\Laravel\IncorrectModelException;
use Illuminate\Database\Eloquent\Model;

class ModelHelper
{
    private $models = [];

    /**
     * @param $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return string
     */
    public function table($model): string
    {
        return $this
            ->model($model)
            ->getTable();
    }

    /**
     * @param $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return string
     */
    public function primaryKey($model): string
    {
        return $this
            ->model($model)
            ->getKeyName();
    }

    public function className($model): string
    {
        if (\is_string($model)) {
            return $model;
        }

        return \get_class($model);
    }

    /**
     * @param $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    public function fillable($model): array
    {
        return $this
            ->model($model)
            ->getFillable();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|mixed $model
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    public function onlyFillable($model, $request): array
    {
        $fillable = $this->fillable($model);

        return $request->only($fillable);
    }

    /**
     * @param $model
     * @param mixed ...$except
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    public function exceptFillable($model, ...$except): array
    {
        return \array_diff($this->fillable($model), (array) $except);
    }

    /**
     * @param string|\Illuminate\Database\Eloquent\Model $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model($model)
    {
        if ($model instanceof Model) {
            $name = \get_class($model);

            return $this->models[$name] = $model;
        }

        if (\is_string($model)) {
            return $this->models[$model] = new $model;
        }

        throw new IncorrectModelException($model);
    }
}
