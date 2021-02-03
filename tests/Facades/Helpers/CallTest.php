<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Call;
use InvalidArgumentException;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class CallTest extends TestCase
{
    public function testRun()
    {
        $this->assertSame('ok', Call::run(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::run(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::run(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::run(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::run(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::run(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testExists()
    {
        $this->assertSame('ok', Call::runExists(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::runExists(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::runExists(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::runExists(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::runExists(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::runExists(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testRunMethods()
    {
        $this->assertSame('ok', Call::runMethods(Foo::class, 'callStatic'));
        $this->assertSame('ok', Call::runMethods(Foo::class, ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', Call::runMethods(Foo::class, 'callParameter', 'bar'));
        $this->assertSame('foo_bar', Call::runMethods(Foo::class, ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('ok', Call::runMethods(new Foo(), 'callStatic'));
        $this->assertSame('ok', Call::runMethods(new Foo(), ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', Call::runMethods(new Foo(), 'callParameter', 'bar'));
        $this->assertSame('foo_bar', Call::runMethods(new Foo(), ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('foo', Call::runMethods(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::runMethods(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testRunOf()
    {
        $this->assertSame('ok', Call::runOf([
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertSame('ok', Call::runOf([
            'Unknown'       => 'unknown',
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], new Foo(), 'foo'));

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], new Foo()));

        $this->assertNull(Call::runOf([
            'Unknown' => 'unknown',
        ], 'foo'));
    }

    public function testWhenTrue()
    {
        $this->assertSame('ok', Call::when(true, Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', Call::when(true, Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', Call::when(true, new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', Call::when(true, new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', Call::when(true, static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], Call::when(true, static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testWhenFalse()
    {
        $this->assertNull(Call::when(false, Foo::class, 'callStatic'));
        $this->assertNull(Call::when(false, Foo::class, 'callParameter', 'bar'));

        $this->assertNull(Call::when(false, new Foo(), 'callStatic'));
        $this->assertNull(Call::when(false, new Foo(), 'callParameter', 'bar'));

        $this->assertNull(Call::when(false, static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertNull(Call::when(false, static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testWrong()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument #1 must be either a class reference or an instance of a class, string given.');

        Call::run('foo', 'bar');
    }
}
