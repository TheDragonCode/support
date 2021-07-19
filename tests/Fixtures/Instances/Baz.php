<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************@author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 */

namespace Tests\Fixtures\Instances;

class Baz extends Bat
{
    public $first = 'foo';

    public $second = 'bar';

    public function toArray()
    {
        return ['qwerty' => 'Qwerty'];
    }
}
