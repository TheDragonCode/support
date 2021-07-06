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

class Foo implements Contract
{
    public static function callStatic()
    {
        return 'ok';
    }

    public function callDymamic()
    {
        return 'ok';
    }

    public function callEmpty()
    {
        return false;
    }

    public function callParameter(string $value): string
    {
        return 'foo_' . $value;
    }
}
