<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Str;
use Tests\TestCase;

class StrTest extends TestCase
{
    public function testE()
    {
        $this->assertEquals('foo&quot;bar', Str::e('foo"bar'));
        $this->assertEquals('foo&amp;bar', Str::e('foo&bar'));
        $this->assertEquals('foo&#039;bar', Str::e('foo\'bar'));
        $this->assertEquals('foo&#039;bar', Str::e("foo'bar"));
        $this->assertEquals('foo\&#039;bar', Str::e('foo\\\'bar'));

        $this->assertEquals('Foo-&gt;bar with space', Str::e('Foo->bar with space'));
        $this->assertEquals('A#symbol^and%a$few@special!chars~`', Str::e('A#symbol^and%a$few@special!chars~`'));
    }

    public function testDe()
    {
        $this->assertEquals('foo"bar', Str::de('foo&quot;bar'));
        $this->assertEquals('foo&bar', Str::de('foo&amp;bar'));
        $this->assertEquals("foo'bar", Str::de('foo&#039;bar'));
        $this->assertEquals("foo'bar", Str::de('foo&#039;bar'));
        $this->assertEquals('foo\\\'bar', Str::de('foo\&#039;bar'));

        $this->assertEquals('Foo->bar with space', Str::de('Foo-&gt;bar with space'));
        $this->assertEquals('A#symbol^and%a$few@special!chars~`', Str::de('A#symbol^and%a$few@special!chars~`'));
    }

    public function testChoice()
    {
        $this->assertEquals('user', Str::choice(1, ['user', 'users', 'users']));
        $this->assertEquals('users', Str::choice(5, ['user', 'users', 'users']));
        $this->assertEquals('users', Str::choice(20, ['user', 'users', 'users']));

        $this->assertEquals('user of this', Str::choice(1, ['user', 'users', 'users'], 'of this'));
        $this->assertEquals('users of this', Str::choice(5, ['user', 'users', 'users'], 'of this'));
        $this->assertEquals('users of this', Str::choice(20, ['user', 'users', 'users'], 'of this'));
    }

    public function testReplaceSpaces()
    {
        $this->assertEquals('foo bar', Str::replaceSpaces('foo bar'));
        $this->assertEquals('foo bar', Str::replaceSpaces('foo  bar'));
        $this->assertEquals('foo bar', Str::replaceSpaces('foo    bar'));

        $this->assertEquals('foo bar baz', Str::replaceSpaces('foo bar  baz'));
        $this->assertEquals('foo bar baz', Str::replaceSpaces('foo  bar     baz'));
        $this->assertEquals('foo bar baz', Str::replaceSpaces('foo    bar baz'));
    }

    public function testFinish()
    {
        $this->assertEquals('foo/', Str::finish('foo', '/'));
        $this->assertEquals('foo/', Str::finish('foo'));

        $this->assertEquals('foobar', Str::finish('foo', 'bar'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(Str::endsWith('foo bar', 'bar'));
        $this->assertTrue(Str::endsWith('foo bar', ['bar', 'baz']));

        $this->assertFalse(Str::endsWith('foo bar', 'foo'));
    }

    public function testLower()
    {
        $this->assertSame('foo bar', Str::lower('Foo Bar'));
        $this->assertSame('foo bar', Str::lower('FoO BaR'));
        $this->assertSame('foo bar', Str::lower('foo bar'));
        $this->assertSame('foo-bar', Str::lower('FoO-BaR'));
    }

    public function testStudly()
    {
        $this->assertSame('FooBar', Str::studly('Foo Bar'));
        $this->assertSame('FoOBaR', Str::studly('FoO BaR'));
        $this->assertSame('FooBar', Str::studly('foo bar'));
        $this->assertSame('FoOBaR', Str::studly('FoO-BaR'));
    }

    public function testCamel()
    {
        $this->assertSame('fooBar', Str::camel('Foo Bar'));
        $this->assertSame('foOBaR', Str::camel('FoO BaR'));
        $this->assertSame('fooBar', Str::camel('foo bar'));
        $this->assertSame('foOBaR', Str::camel('FoO-BaR'));
    }

    public function testSnake()
    {
        $this->assertSame('foo_bar', Str::snake('Foo Bar'));
        $this->assertSame('fo_o_ba_r', Str::snake('FoO BaR'));
        $this->assertSame('foo_bar', Str::snake('foo bar'));
        $this->assertSame('fo_o-_ba_r', Str::snake('FoO-BaR'));
    }
}
