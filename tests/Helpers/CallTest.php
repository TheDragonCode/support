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

namespace Tests\Helpers;

use DragonCode\Support\Helpers\Call;
use InvalidArgumentException;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Exceptions\AnyException;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class CallTest extends TestCase
{
    public function testRun()
    {
        $this->assertSame('ok', $this->call()->run(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->run(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', $this->call()->run(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->run(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', $this->call()->run(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], $this->call()->run(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testExists()
    {
        $this->assertSame('ok', $this->call()->runExists(Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->runExists(Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', $this->call()->runExists(new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->runExists(new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', $this->call()->runExists(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], $this->call()->runExists(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testRunMethods()
    {
        $this->assertSame('ok', $this->call()->runMethods(Foo::class, 'callStatic'));
        $this->assertSame('ok', $this->call()->runMethods(Foo::class, ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', $this->call()->runMethods(Foo::class, 'callParameter', 'bar'));
        $this->assertSame('foo_bar', $this->call()->runMethods(Foo::class, ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('ok', $this->call()->runMethods(new Foo(), 'callStatic'));
        $this->assertSame('ok', $this->call()->runMethods(new Foo(), ['qwe', 'rty', 'callStatic']));

        $this->assertSame('foo_bar', $this->call()->runMethods(new Foo(), 'callParameter', 'bar'));
        $this->assertSame('foo_bar', $this->call()->runMethods(new Foo(), ['qwe', 'rty', 'callParameter'], 'bar'));

        $this->assertSame('foo', $this->call()->runMethods(static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], $this->call()->runMethods(static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));

        $this->assertSame('Foo Bar', $this->call()->runMethods(new AnyException(), 'getMessage'));
    }

    public function testRunOf()
    {
        $this->assertSame('ok', $this->call()->runOf([
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertSame('ok', $this->call()->runOf([
            'Unknown'       => 'unknown',
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertNull($this->call()->runOf([
            'Unknown' => 'unknown',
        ], new Foo(), 'foo'));

        $this->assertNull($this->call()->runOf([
            'Unknown' => 'unknown',
        ], new Foo()));

        $this->assertNull($this->call()->runOf([
            'Unknown' => 'unknown',
        ], 'foo'));
    }

    public function testWhenTrue()
    {
        $this->assertSame('ok', $this->call()->when(true, Foo::class, 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->when(true, Foo::class, 'callParameter', 'bar'));

        $this->assertSame('ok', $this->call()->when(true, new Foo(), 'callStatic'));
        $this->assertSame('foo_bar', $this->call()->when(true, new Foo(), 'callParameter', 'bar'));

        $this->assertSame('foo', $this->call()->when(true, static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertSame(['foo', 'bar', 'baz'], $this->call()->when(true, static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testWhenFalse()
    {
        $this->assertNull($this->call()->when(false, Foo::class, 'callStatic'));
        $this->assertNull($this->call()->when(false, Foo::class, 'callParameter', 'bar'));

        $this->assertNull($this->call()->when(false, new Foo(), 'callStatic'));
        $this->assertNull($this->call()->when(false, new Foo(), 'callParameter', 'bar'));

        $this->assertNull($this->call()->when(false, static function ($value) {
            return $value;
        }, 'foo'));

        $this->assertNull($this->call()->when(false, static function ($value, ...$values) {
            return array_merge([$value], $values);
        }, 'foo', 'bar', 'baz'));
    }

    public function testWrong()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument #1 must be either a class reference or an instance of a class, string given.');

        $this->call()->run('foo', 'bar');
    }

    protected function call(): Call
    {
        return new Call();
    }
}
