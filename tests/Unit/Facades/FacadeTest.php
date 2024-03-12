<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Facades;

use DragonCode\Support\Application\OS;
use DragonCode\Support\Facades\Application\OS as OSFacade;
use DragonCode\Support\Facades\Filesystem\Directory as DirectoryFacade;
use DragonCode\Support\Facades\Filesystem\File as FileFacade;
use DragonCode\Support\Facades\Helpers\Arr as ArrFacade;
use DragonCode\Support\Facades\Helpers\Digit as DigitFacade;
use DragonCode\Support\Facades\Helpers\Str as StrFacade;
use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use DragonCode\Support\Facades\Http\Url as UrlFacade;
use DragonCode\Support\Facades\Instances\Instance as InstanceFacade;
use DragonCode\Support\Facades\Instances\Reflection as ReflectionFacade;
use DragonCode\Support\Facades\Tools\Stub as StubFacade;
use DragonCode\Support\Facades\Types\Is as IsFacade;
use DragonCode\Support\Filesystem\Directory;
use DragonCode\Support\Filesystem\File;
use DragonCode\Support\Helpers\Arr;
use DragonCode\Support\Helpers\Digit;
use DragonCode\Support\Helpers\Str;
use DragonCode\Support\Http\Builder;
use DragonCode\Support\Http\Url;
use DragonCode\Support\Instances\Instance;
use DragonCode\Support\Instances\Reflection;
use DragonCode\Support\Tools\Stub;
use DragonCode\Support\Types\Is;
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
        $this->assertInstanceOf(Directory::class, DirectoryFacade::getFacadeRoot());
        $this->assertInstanceOf(File::class, FileFacade::getFacadeRoot());
        $this->assertInstanceOf(Arr::class, ArrFacade::getFacadeRoot());
        $this->assertInstanceOf(Digit::class, DigitFacade::getFacadeRoot());
        $this->assertInstanceOf(Builder::class, BuilderFacade::getFacadeRoot());
        $this->assertInstanceOf(Url::class, UrlFacade::getFacadeRoot());
        $this->assertInstanceOf(Instance::class, InstanceFacade::getFacadeRoot());
        $this->assertInstanceOf(Is::class, IsFacade::getFacadeRoot());
        $this->assertInstanceOf(OS::class, OSFacade::getFacadeRoot());
        $this->assertInstanceOf(Reflection::class, ReflectionFacade::getFacadeRoot());
        $this->assertInstanceOf(Str::class, StrFacade::getFacadeRoot());
        $this->assertInstanceOf(Stub::class, StubFacade::getFacadeRoot());
    }
}
