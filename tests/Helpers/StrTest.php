<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Str;
use Tests\TestCase;

final class StrTest extends TestCase
{
    public function testEndsWith()
    {
        $this->assertTrue($this->str()->endsWith('jason', 'on'));
        $this->assertTrue($this->str()->endsWith('jason', 'jason'));
        $this->assertTrue($this->str()->endsWith('jason', ['on']));
        $this->assertTrue($this->str()->endsWith('jason', ['no', 'on']));
        $this->assertFalse($this->str()->endsWith('jason', 'no'));
        $this->assertFalse($this->str()->endsWith('jason', ['no']));
        $this->assertFalse($this->str()->endsWith('jason', ''));
        $this->assertFalse($this->str()->endsWith('', ''));
        $this->assertFalse($this->str()->endsWith('jason', [null]));
        $this->assertFalse($this->str()->endsWith('jason', null));
        $this->assertFalse($this->str()->endsWith('jason', 'N'));
        $this->assertFalse($this->str()->endsWith('7', ' 7'));
        $this->assertTrue($this->str()->endsWith('a7', '7'));
        $this->assertTrue($this->str()->endsWith('a7', 7));
        $this->assertTrue($this->str()->endsWith('a7.12', 7.12));
        $this->assertFalse($this->str()->endsWith('a7.12', 7.13));
        $this->assertTrue($this->str()->endsWith(0.27, '7'));
        $this->assertTrue($this->str()->endsWith(0.27, '0.27'));
        $this->assertFalse($this->str()->endsWith(0.27, '8'));
        // Test for multibyte string support
        $this->assertTrue($this->str()->endsWith('Jönköping', 'öping'));
        $this->assertTrue($this->str()->endsWith('Malmö', 'mö'));
        $this->assertFalse($this->str()->endsWith('Jönköping', 'oping'));
        $this->assertFalse($this->str()->endsWith('Malmö', 'mo'));
        $this->assertTrue($this->str()->endsWith('你好', '好'));
        $this->assertFalse($this->str()->endsWith('你好', '你'));
        $this->assertFalse($this->str()->endsWith('你好', 'a'));
    }

    public function testCamel()
    {
        $this->assertSame('fooBar', $this->str()->camel('Foo Bar'));
        $this->assertSame('foOBaR', $this->str()->camel('FoO BaR'));
        $this->assertSame('fooBar', $this->str()->camel('foo bar'));
        $this->assertSame('foOBaR', $this->str()->camel('FoO-BaR'));
        $this->assertSame('foOBaR', $this->str()->camel('FoO   -   BaR'));
    }

    public function testSnake()
    {
        $this->assertSame('foo_bar', $this->str()->snake('Foo Bar'));
        $this->assertSame('fo_o_ba_r', $this->str()->snake('FoO BaR'));
        $this->assertSame('foo_bar', $this->str()->snake('foo bar'));
        $this->assertSame('fo_o-_ba_r', $this->str()->snake('FoO-BaR'));
        $this->assertSame('fo_o-_ba_r', $this->str()->snake('FoO   -   BaR'));
    }

    public function testStart()
    {
        $this->assertSame('/test/string', $this->str()->start('test/string', '/'));
        $this->assertSame('/test/string', $this->str()->start('/test/string', '/'));
        $this->assertSame('/test/string', $this->str()->start('//test/string', '/'));
    }

    public function testStartsWith()
    {
        $this->assertTrue($this->str()->startsWith('jason', 'jas'));
        $this->assertTrue($this->str()->startsWith('jason', 'jason'));
        $this->assertTrue($this->str()->startsWith('jason', ['jas']));
        $this->assertTrue($this->str()->startsWith('jason', ['day', 'jas']));
        $this->assertFalse($this->str()->startsWith('jason', 'day'));
        $this->assertFalse($this->str()->startsWith('jason', ['day']));
        $this->assertFalse($this->str()->startsWith('jason', null));
        $this->assertFalse($this->str()->startsWith('jason', [null]));
        $this->assertFalse($this->str()->startsWith('0123', [null]));
        $this->assertTrue($this->str()->startsWith('0123', 0));
        $this->assertFalse($this->str()->startsWith('jason', 'J'));
        $this->assertFalse($this->str()->startsWith('jason', ''));
        $this->assertFalse($this->str()->startsWith('', ''));
        $this->assertFalse($this->str()->startsWith('7', ' 7'));
        $this->assertTrue($this->str()->startsWith('7a', '7'));
        $this->assertTrue($this->str()->startsWith('7a', 7));
        $this->assertTrue($this->str()->startsWith('7.12a', 7.12));
        $this->assertFalse($this->str()->startsWith('7.12a', 7.13));
        $this->assertTrue($this->str()->startsWith(7.123, '7'));
        $this->assertTrue($this->str()->startsWith(7.123, '7.12'));
        $this->assertFalse($this->str()->startsWith(7.123, '7.13'));
        // Test for multibyte string support
        $this->assertTrue($this->str()->startsWith('Jönköping', 'Jö'));
        $this->assertTrue($this->str()->startsWith('Malmö', 'Malmö'));
        $this->assertFalse($this->str()->startsWith('Jönköping', 'Jonko'));
        $this->assertFalse($this->str()->startsWith('Malmö', 'Malmo'));
        $this->assertTrue($this->str()->startsWith('你好', '你'));
        $this->assertFalse($this->str()->startsWith('你好', '好'));
        $this->assertFalse($this->str()->startsWith('你好', 'a'));
    }

    public function testLength()
    {
        $this->assertSame(11, $this->str()->length('foo bar baz'));
        $this->assertSame(11, $this->str()->length('foo bar baz', 'UTF-8'));
    }

    public function testRemoveSpaces()
    {
        $this->assertEquals('foo bar', $this->str()->removeSpaces('foo bar'));
        $this->assertEquals('foo bar', $this->str()->removeSpaces('foo  bar'));
        $this->assertEquals('foo bar', $this->str()->removeSpaces('foo    bar'));

        $this->assertEquals('foo bar baz', $this->str()->removeSpaces('foo bar  baz'));
        $this->assertEquals('foo bar baz', $this->str()->removeSpaces('foo  bar     baz'));
        $this->assertEquals('foo bar baz', $this->str()->removeSpaces('foo    bar baz'));
    }

    public function testLower()
    {
        $this->assertSame('foo bar baz', $this->str()->lower('FOO BAR BAZ'));
        $this->assertSame('foo bar baz', $this->str()->lower('fOo Bar bAz'));
    }

    public function testUpper()
    {
        $this->assertSame('FOO BAR BAZ', $this->str()->upper('FOO BAR BAZ'));
        $this->assertSame('FOO BAR BAZ', $this->str()->upper('fOo Bar bAz'));
    }

    public function testFinish()
    {
        $this->assertSame('ab/', $this->str()->finish('ab'));
        $this->assertSame('abbc', $this->str()->finish('ab', 'bc'));
        $this->assertSame('abbc', $this->str()->finish('abbcbc', 'bc'));
        $this->assertSame('abcbbc', $this->str()->finish('abcbbcbc', 'bc'));
    }

    public function testStudly()
    {
        $this->assertSame('FooBar', $this->str()->studly('Foo Bar'));
        $this->assertSame('FoOBaR', $this->str()->studly('FoO BaR'));
        $this->assertSame('FooBar', $this->str()->studly('foo bar'));
        $this->assertSame('FoOBaR', $this->str()->studly('FoO-BaR'));
        $this->assertSame('FoOBaR', $this->str()->studly('FoO   -   BaR'));
    }

    public function testDe()
    {
        $this->assertEquals('foo"bar', $this->str()->de('foo&quot;bar'));
        $this->assertEquals('foo&bar', $this->str()->de('foo&amp;bar'));
        $this->assertEquals("foo'bar", $this->str()->de('foo&#039;bar'));
        $this->assertEquals("foo'bar", $this->str()->de('foo&#039;bar'));
        $this->assertEquals('foo\\\'bar', $this->str()->de('foo\&#039;bar'));

        $this->assertEquals('Foo->bar with space', $this->str()->de('Foo-&gt;bar with space'));
        $this->assertEquals('A#symbol^and%a$few@special!chars~`', $this->str()->de('A#symbol^and%a$few@special!chars~`'));
    }

    public function testE()
    {
        $this->assertSame('foo&quot;bar', $this->str()->e('foo"bar'));
        $this->assertSame('foo&amp;bar', $this->str()->e('foo&bar'));
        $this->assertSame('foo&#039;bar', $this->str()->e('foo\'bar'));
        $this->assertSame('foo&#039;bar', $this->str()->e("foo'bar"));
        $this->assertSame('foo\&#039;bar', $this->str()->e('foo\\\'bar'));

        $this->assertSame('Foo-&gt;bar with space', $this->str()->e('Foo->bar with space'));
        $this->assertSame('A#symbol^and%a$few@special!chars~`', $this->str()->e('A#symbol^and%a$few@special!chars~`'));
    }

    public function testChoice()
    {
        $this->assertEquals('user', $this->str()->choice(1, ['user', 'users', 'users']));
        $this->assertEquals('users', $this->str()->choice(5, ['user', 'users', 'users']));
        $this->assertEquals('users', $this->str()->choice(20, ['user', 'users', 'users']));

        $this->assertEquals('user of this', $this->str()->choice(1, ['user', 'users', 'users'], 'of this'));
        $this->assertEquals('users of this', $this->str()->choice(5, ['user', 'users', 'users'], 'of this'));
        $this->assertEquals('users of this', $this->str()->choice(20, ['user', 'users', 'users'], 'of this'));
    }

    public function testSubstr()
    {
        $this->assertSame('Ё', $this->str()->substr('БГДЖИЛЁ', -1));
        $this->assertSame('ЛЁ', $this->str()->substr('БГДЖИЛЁ', -2));
        $this->assertSame('И', $this->str()->substr('БГДЖИЛЁ', -3, 1));
        $this->assertSame('ДЖИЛ', $this->str()->substr('БГДЖИЛЁ', 2, -1));
        $this->assertSame('ИЛ', $this->str()->substr('БГДЖИЛЁ', -3, -1));
        $this->assertSame('ГДЖИЛЁ', $this->str()->substr('БГДЖИЛЁ', 1));
        $this->assertSame('ГДЖ', $this->str()->substr('БГДЖИЛЁ', 1, 3));
        $this->assertSame('БГДЖ', $this->str()->substr('БГДЖИЛЁ', 0, 4));
        $this->assertSame('Ё', $this->str()->substr('БГДЖИЛЁ', -1, 1));

        $this->assertEmpty($this->str()->substr('БГДЖИЛЁ', 4, -4));
        $this->assertEmpty($this->str()->substr('Б', 2));
    }

    protected function str(): Str
    {
        return new Str();
    }
}
