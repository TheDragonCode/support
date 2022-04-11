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

namespace Tests\Unit\Http\Url;

use DragonCode\Support\Facades\Http\Url;

class DefaultTest extends Base
{
    public function testDefault()
    {
        $first = 'https://github.githubassets.com/pinned-octocat.svg';

        $this->assertSame($first, Url::default($first, 'https://example.com/foo.jpg'));

        $this->assertSame('https://example.com/foo.jpg', Url::default('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));
    }
}
