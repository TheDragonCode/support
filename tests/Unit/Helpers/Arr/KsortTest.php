<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class KsortTest extends TestCase
{
    public function testKsort()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 'Number 700',

            '*' => 'asterisk',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            '-' => 'hyphen',

            400 => 'Number 400',

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 'Number 0',
            '_' => 'underscore',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 'Number 700',

                '*' => 'asterisk',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                '-' => 'hyphen',

                400 => 'Number 400',

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 'Number 0',
                '_' => 'underscore',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*' => 'asterisk',
            '-' => 'hyphen',

            '_' => 'underscore',

            0   => 'Number 0',
            400 => 'Number 400',
            700 => 'Number 700',

            'add key'      => 'Add key',
            'add_key'      => 'Add_Key',
            'addkey'       => 'AddKey',
            'all key'      => 'All key',
            'all_key'      => 'All_Key',
            'allkey'       => 'AllKey',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,

            'sub' => [
                '*' => 'asterisk',
                '-' => 'hyphen',

                '_' => 'underscore',

                0   => 'Number 0',
                400 => 'Number 400',
                700 => 'Number 700',

                'add key'      => 'Add key',
                'add_key'      => 'Add_Key',
                'addkey'       => 'AddKey',
                'all key'      => 'All key',
                'all_key'      => 'All_Key',
                'allkey'       => 'AllKey',
                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,
            ],

            'w' => 123,
        ];

        $this->assertSame($target, Arr::ksort($source));
    }

    public function testKsortCallback()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 'Number 700',

            '*' => 'asterisk',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            '-' => 'hyphen',

            400 => 'Number 400',

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 'Number 0',
            '_' => 'underscore',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 'Number 700',

                '*' => 'asterisk',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                '-' => 'hyphen',

                400 => 'Number 400',

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 'Number 0',
                '_' => 'underscore',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*' => 'asterisk',
            '-' => 'hyphen',

            '_' => 'underscore',

            'add key'      => 'Add key',
            'add_key'      => 'Add_Key',
            'addkey'       => 'AddKey',
            'all key'      => 'All key',
            'all_key'      => 'All_Key',
            'allkey'       => 'AllKey',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,

            'sub' => [
                '*' => 'asterisk',
                '-' => 'hyphen',

                '_' => 'underscore',

                'add key'      => 'Add key',
                'add_key'      => 'Add_Key',
                'addkey'       => 'AddKey',
                'all key'      => 'All key',
                'all_key'      => 'All_Key',
                'allkey'       => 'AllKey',
                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                0   => 'Number 0',
                400 => 'Number 400',
                700 => 'Number 700',
            ],

            'w' => 123,

            0   => 'Number 0',
            400 => 'Number 400',
            700 => 'Number 700',
        ];

        $callback = static function ($current, $next) {
            $current = is_string($current) ? Str::lower($current) : $current;
            $next    = is_string($next) ? Str::lower($next) : $next;

            if ($current === $next) {
                return 0;
            }

            if (is_string($current) && is_numeric($next)) {
                return -1;
            }

            if (is_numeric($current) && is_string($next)) {
                return 1;
            }

            return $current < $next ? -1 : 1;
        };

        $this->assertSame($target, Arr::ksort($source, $callback));
    }
}
