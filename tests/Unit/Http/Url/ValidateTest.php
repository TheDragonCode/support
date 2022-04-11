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

use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Facades\Http\Url;

class ValidateTest extends Base
{
    public function testValidate()
    {
        Url::validate('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateDuplicateSlashes()
    {
        Url::validate('https://example.com/foo');
        Url::validate('https://example.com//foo');
        Url::validate('https://example.com///foo');
        Url::validate('https://example.com////foo');

        $this->assertTrue(true);
    }

    public function testValidateWithoutSchema()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "//example.com/foo" is not a valid URL.');

        Url::validate('//example.com/foo');
    }

    public function testValidatePsr()
    {
        Url::validate($this->builder());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Url::validate('foo.bar');
    }
}
