<?php

use Helldar\Support\Facades\Dumper;

if (! function_exists('dd_sql')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @deprecated 2.0: Using "dd_sql" is deprecated.
     *
     * @param      $query
     * @param  bool  $is_short
     * @param  bool  $is_return
     *
     * @return array|string
     */
    function dd_sql($query, bool $is_short = false, bool $is_return = false)
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "dd_sql" is deprecated.');

        return Dumper::ddSql($query, $is_short, $is_return);
    }
}
