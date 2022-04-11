<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class WithSchemeMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = Builder::same();

        $this->assertEmpty($builder->getScheme());

        $builder->withScheme($this->psr_scheme);

        $this->assertIsString($builder->getScheme());
        $this->assertSame($this->psr_scheme, $builder->getScheme());
    }

    public function testReplace()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_scheme, $builder->getScheme());

        $builder->withScheme('ws');

        $this->assertIsString($builder->getScheme());
        $this->assertSame('ws', $builder->getScheme());
    }
}
