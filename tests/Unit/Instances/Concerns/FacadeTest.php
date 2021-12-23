<?php
/*
 * This file is part of the "dragon-code/support" project.
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
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Instances\Concerns;

use DragonCode\Support\Facades\Helpers\Arr as ArrFacade;
use DragonCode\Support\Facades\Helpers\Digit as DigitFacade;
use DragonCode\Support\Facades\Helpers\Filesystem\Directory as DirectoryFacade;
use DragonCode\Support\Facades\Helpers\Filesystem\File as FileFacade;
use DragonCode\Support\Facades\Helpers\Instance as InstanceFacade;
use DragonCode\Support\Facades\Helpers\Is as IsFacade;
use DragonCode\Support\Facades\Helpers\OS as OSFacade;
use DragonCode\Support\Facades\Helpers\Reflection as ReflectionFacade;
use DragonCode\Support\Facades\Helpers\Str as StrFacade;
use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use DragonCode\Support\Facades\Http\Url as UrlFacade;
use DragonCode\Support\Facades\Tools\Stub as StubFacade;
use DragonCode\Support\Helpers\Arr;
use DragonCode\Support\Helpers\Digit;
use DragonCode\Support\Helpers\Filesystem\Directory;
use DragonCode\Support\Helpers\Filesystem\File;
use DragonCode\Support\Helpers\Http\Builder;
use DragonCode\Support\Helpers\Http\Url;
use DragonCode\Support\Helpers\Instance;
use DragonCode\Support\Helpers\Is;
use DragonCode\Support\Helpers\OS;
use DragonCode\Support\Helpers\Reflection;
use DragonCode\Support\Helpers\Str;
use DragonCode\Support\Tools\Stub;
use Error;
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
