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

declare(strict_types=1);

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class TitleTest extends TestCase
{
    public function testTitle()
    {
        $this->assertSame('Foo Bar', Str::title('Foo Bar'));
        $this->assertSame('Foo Bar', Str::title('FoO BaR'));
        $this->assertSame('Foo Bar', Str::title('foo bar'));
        $this->assertSame('Foo-Bar', Str::title('FoO-BaR'));
        $this->assertSame('Foo   -   Bar', Str::title('FoO   -   BaR'));

        $this->assertSame('123', Str::title('123'));
        $this->assertSame('123', Str::title(123));

        $this->assertSame('0', Str::title('0'));
        $this->assertSame('0', Str::title(0));

        $this->assertNull(Str::title(''));
        $this->assertNull(Str::title(null));
        $this->assertNull(Str::title(false));
    }
}
