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
use Psr\Http\Message\UriInterface;

class ValidatedTest extends Base
{
    public function testValidated()
    {
        $url = 'https://example.com';

        $validated = Url::validated($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedPsr()
    {
        $builder = $this->builder();

        $validated = Url::validated($builder);

        $this->assertInstanceOf(UriInterface::class, $validated);
        $this->assertSame($this->test_url, (string) $validated);
    }
}
