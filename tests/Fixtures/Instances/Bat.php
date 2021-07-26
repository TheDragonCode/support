<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Fixtures\Instances;

use Tests\Fixtures\Contracts\Contract;

class Bat implements Contract
{
    public $foo;

    public $bar;

    public function __construct(string $foo = null, string $bar = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
