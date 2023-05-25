<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Tools\Stub;

use DragonCode\Support\Facades\Tools\Stub;
use DragonCode\Support\Tools\Stub as Tool;
use Tests\TestCase;

class ReplaceTest extends TestCase
{
    public function testReplacePhp()
    {
        $this->assertSame("<?php\n\ndeclare(strict_types=1);\n\nreturn {{slot}};\n", Stub::replace(Tool::PHP, []));
        $this->assertSame("<?php\n\ndeclare(strict_types=1);\n\nreturn 'foo';\n", Stub::replace(Tool::PHP, ['{{slot}}' => '\'foo\'']));
    }

    public function testReplaceJson()
    {
        $this->assertSame("{{slot}}\n", Stub::replace(Tool::JSON, []));
        $this->assertSame("foo\n", Stub::replace(Tool::JSON, ['{{slot}}' => 'foo']));
    }
}
