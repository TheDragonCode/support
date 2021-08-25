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

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Is as IsHelper;
use ReflectionClass;

class Reflection
{
    /**
     * Creates a ReflectionClass object.
     *
     * @param  object|ReflectionClass|string  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    public function resolve($class): ReflectionClass
    {
        return IsHelper::reflectionClass($class) ? $class : new ReflectionClass($class);
    }

    /**
     * Gets class constants.
     *
     * @param  object|string  $class
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public function getConstants($class): array
    {
        return $this->resolve($class)->getConstants();
    }
}
