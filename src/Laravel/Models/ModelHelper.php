<?php

namespace Helldar\Support\Laravel\Models;

use Helldar\Support\Exceptions\Laravel\IncorrectModelException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ModelHelper
{
    private $models = [];

    /**
     * @param $model
     *
     * @throws IncorrectModelException
     *
     * @return string
     */
    public function connection($model): ?string
    {
        return $this
            ->model($model)
            ->getConnectionName();
    }

    /**
     * @param $model
     *
     * @throws IncorrectModelException
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
     * @throws IncorrectModelException
     *
     * @return string
     */
    public function tableWithConnection($model): string
    {
        $connection = $this->connection($model);
        $table      = $this->table($model);

        return $connection
            ? $connection . '.' . $table
            : $table;
    }

    /**
     * @param $model
     *
     * @throws IncorrectModelException
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
        if (is_string($model)) {
            return $model;
        }

        return get_class($model);
    }

    /**
     * @param $model
     *
     * @throws IncorrectModelException
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
     * @param Model|mixed $model
     * @param Request $request
     *
     * @throws IncorrectModelException
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
     * @throws IncorrectModelException
     *
     * @return array
     */
    public function exceptFillable($model, ...$except): array
    {
        return array_diff($this->fillable($model), (array) $except);
    }

    /**
     * @param string|Model $model
     *
     * @throws IncorrectModelException
     *
     * @return Model
     */
    public function model($model)
    {
        if ($model instanceof Model) {
            $name = get_class($model);

            return $this->models[$name] = $model;
        }

        if (is_string($model)) {
            return $this->models[$model] = new $model;
        }

        throw new IncorrectModelException($model);
    }
}
