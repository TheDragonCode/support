<?php

namespace Helldar\Support\Facades;

use Illuminate\Database\Eloquent\Builder;

class Dumper
{
    /**
     * Dump the passed variables and end the script.
     *
     * @see https://gist.github.com/Ellrion/561fc48894a87b853917e0a5cec83181#file-helper-php
     *
     * @param $query
     * @param  bool  $is_short
     * @param  bool  $is_return
     *
     * @return array|string
     */
    public static function ddSql($query, bool $is_short = false, bool $is_return = false)
    {
        if ($query instanceof Builder) {
            $query = $query->getQuery();
        }

        $sql = $query->toSql();

        $bindings = array_map(function ($binding) {
            return is_int($binding) || is_float($binding) ? $binding : "'{$binding}'";
        }, $query->getBindings());

        $raw      = vsprintf(str_replace(['%', '?'], ['%%', '%s'], $sql), $bindings);
        $bindings = $query->getRawBindings();

        if ($is_return) {
            return $is_short ? $raw : compact('sql', 'bindings', 'raw');
        }

        dd($is_short ? $raw : compact('sql', 'bindings', 'raw'));
    }
}
