<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Fixtures\Instances;

use Tests\Fixtures\Concerns\Foable;

class Baz extends Bat
{
    use Foable;

    public $first = 'foo';

    public $second = 'bar';

    public function toArray()
    {
        return ['qwerty' => 'Qwerty'];
    }
}
