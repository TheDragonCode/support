<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Concerns;

use Error;
use Helldar\Support\Facades\Helpers\Arr as ArrFacade;
use Helldar\Support\Facades\Helpers\Digit as DigitFacade;
use Helldar\Support\Facades\Helpers\Filesystem\Directory as DirectoryFacade;
use Helldar\Support\Facades\Helpers\Filesystem\File as FileFacade;
use Helldar\Support\Facades\Helpers\Instance as InstanceFacade;
use Helldar\Support\Facades\Helpers\Is as IsFacade;
use Helldar\Support\Facades\Helpers\OS as OSFacade;
use Helldar\Support\Facades\Helpers\Reflection as ReflectionFacade;
use Helldar\Support\Facades\Helpers\Str as StrFacade;
use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Helldar\Support\Facades\Http\Url as UrlFacade;
use Helldar\Support\Facades\Tools\Stub as StubFacade;
use Helldar\Support\Helpers\Arr;
use Helldar\Support\Helpers\Digit;
use Helldar\Support\Helpers\Filesystem\Directory;
use Helldar\Support\Helpers\Filesystem\File;
use Helldar\Support\Helpers\Http\Builder;
use Helldar\Support\Helpers\Http\Url;
use Helldar\Support\Helpers\Instance;
use Helldar\Support\Helpers\Is;
use Helldar\Support\Helpers\OS;
use Helldar\Support\Helpers\Reflection;
use Helldar\Support\Helpers\Str;
use Helldar\Support\Tools\Stub;
use RuntimeException;
use Tests\Fixtures\Facades\NotImplement;
use Tests\Fixtures\Facades\Resolve;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testNotImplementMethod()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Facade does not implement getFacadeAccessor method.');

        NotImplement::foo();
    }

    public function testResolve()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches('/^Class (\'|")foo(\'|") not found$/');

        Resolve::bar();
    }

    public function testInstance()
    {
        $this->assertTrue(DirectoryFacade::getFacadeRoot() instanceof Directory);
        $this->assertTrue(FileFacade::getFacadeRoot() instanceof File);
        $this->assertTrue(ArrFacade::getFacadeRoot() instanceof Arr);
        $this->assertTrue(DigitFacade::getFacadeRoot() instanceof Digit);
        $this->assertTrue(BuilderFacade::getFacadeRoot() instanceof Builder);
        $this->assertTrue(UrlFacade::getFacadeRoot() instanceof Url);
        $this->assertTrue(InstanceFacade::getFacadeRoot() instanceof Instance);
        $this->assertTrue(IsFacade::getFacadeRoot() instanceof Is);
        $this->assertTrue(OSFacade::getFacadeRoot() instanceof OS);
        $this->assertTrue(ReflectionFacade::getFacadeRoot() instanceof Reflection);
        $this->assertTrue(StrFacade::getFacadeRoot() instanceof Str);
        $this->assertTrue(StubFacade::getFacadeRoot() instanceof Stub);
    }
}
