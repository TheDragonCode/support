<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Ables\Stringable;
use Helldar\Support\Helpers\Str;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class StrTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame('', (string) $this->str()->of(''));
        $this->assertInstanceOf(Stringable::class, $this->str()->of(''));

        $this->assertSame('', (string) $this->str()->of(null));
        $this->assertInstanceOf(Stringable::class, $this->str()->of(null));

        $this->assertSame('foo', (string) $this->str()->of('foo'));
        $this->assertInstanceOf(Stringable::class, $this->str()->of('foo'));
    }

    public function testAfter()
    {
        $this->assertSame('Bar', $this->str()->after('Foo Bar', ' '));
        $this->assertSame('BaR', $this->str()->after('FoO BaR', ' '));
        $this->assertSame('bar', $this->str()->after('foo bar', ' '));
        $this->assertSame('FoO-BaR', $this->str()->after('FoO-BaR', ' '));
        $this->assertSame('   BaR', $this->str()->after('FoO   -   BaR', '-'));
        $this->assertSame('  BaR', $this->str()->after('FoO   -   BaR', ' - '));
    }

    public function testBefore()
    {
        $this->assertSame('Foo', $this->str()->before('Foo Bar', ' '));
        $this->assertSame('FoO', $this->str()->before('FoO BaR', ' '));
        $this->assertSame('foo', $this->str()->before('foo bar', ' '));
        $this->assertSame('FoO-BaR', $this->str()->before('FoO-BaR', ' '));
        $this->assertSame('FoO   ', $this->str()->before('FoO   -   BaR', '-'));
        $this->assertSame('FoO  ', $this->str()->before('FoO   -   BaR', ' - '));
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

    public function testSlug()
    {
        $this->assertSame('hello-world', $this->str()->slug('hello world'));
        $this->assertSame('hello-world', $this->str()->slug('hello-world'));
        $this->assertSame('hello-world', $this->str()->slug('hello_world'));
        $this->assertSame('hello_world', $this->str()->slug('hello_world', '_'));
        $this->assertSame('user-at-host', $this->str()->slug('user@host'));
        $this->assertSame('سلام-دنیا', $this->str()->slug('سلام دنیا', '-', null));
        $this->assertSame('sometext', $this->str()->slug('some text', ''));
        $this->assertSame('privetmir', $this->str()->slug('Привет, мир!', ''));
        $this->assertSame('', $this->str()->slug('', ''));
        $this->assertSame('', $this->str()->slug(''));
    }

    public function testTitle()
    {
        $this->assertSame('Foo Bar', $this->str()->title('Foo Bar'));
        $this->assertSame('Foo Bar', $this->str()->title('FoO BaR'));
        $this->assertSame('Foo Bar', $this->str()->title('foo bar'));
        $this->assertSame('Foo-Bar', $this->str()->title('FoO-BaR'));
        $this->assertSame('Foo   -   Bar', $this->str()->title('FoO   -   BaR'));

        $this->assertSame('123', $this->str()->title('123'));
        $this->assertSame('123', $this->str()->title(123));

        $this->assertSame('0', $this->str()->title('0'));
        $this->assertSame('0', $this->str()->title(0));

        $this->assertNull($this->str()->title(''));
        $this->assertNull($this->str()->title(null));
        $this->assertNull($this->str()->title(false));
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
        $this->assertTrue($this->str()->startsWith(0.27, '0'));
        $this->assertTrue($this->str()->startsWith(0.27, '0.27'));
        $this->assertFalse($this->str()->startsWith(0.27, '8'));

        // Test for multibyte string support
        $this->assertTrue($this->str()->startsWith('Jönköping', 'Jö'));
        $this->assertTrue($this->str()->startsWith('Malmö', 'Malmö'));
        $this->assertFalse($this->str()->startsWith('Jönköping', 'Jonko'));
        $this->assertFalse($this->str()->startsWith('Malmö', 'Malmo'));
        $this->assertTrue($this->str()->startsWith('你好', '你'));
        $this->assertFalse($this->str()->startsWith('你好', '好'));
        $this->assertFalse($this->str()->startsWith('你好', 'a'));
    }

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

    public function testReplace()
    {
        $this->assertSame('foo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('bZr', $this->str()->replace('bar', ['a' => 'Z', 's' => 'X']));
        $this->assertSame('bZr', $this->str()->replace('bar', ['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('bZr', $this->str()->replace('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('bZr', $this->str()->replace('bar', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('foo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('foo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('foo', $this->str()->replace('foo', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZr', $this->str()->replace('b{a}r', ['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('bZr', $this->str()->replace('b{a}r', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('bZr', $this->str()->replace('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('bZr', $this->str()->replace('b{a}r', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZz', $this->str()->replace('b_a_z', ['a' => 'Z', 's' => 'X'], '_%s_'));
        $this->assertSame('bZz', $this->str()->replace('b_a_z', ['a' => 'Z', 's' => 'X', 'o' => 'Q'], '_%s_'));
        $this->assertSame('bZz', $this->str()->replace('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E'], '_%s_'));
        $this->assertSame('bZz', $this->str()->replace('b_a_z', ['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '_%s_'));
    }

    public function testStrContains()
    {
        $this->assertTrue($this->str()->contains('qwerty', 'ert'));
        $this->assertTrue($this->str()->contains('qwerty', 'qwerty'));
        $this->assertTrue($this->str()->contains('qwerty', ['ert']));
        $this->assertTrue($this->str()->contains('qwerty', ['xxx', 'ert']));

        $this->assertFalse($this->str()->contains('qwerty', 'xxx'));
        $this->assertFalse($this->str()->contains('qwerty', ['xxx']));
        $this->assertFalse($this->str()->contains('qwerty', ''));
        $this->assertFalse($this->str()->contains('qwerty', null));
        $this->assertFalse($this->str()->contains('qwerty', [null]));
        $this->assertFalse($this->str()->contains('qwerty', [0]));
        $this->assertFalse($this->str()->contains('qwerty', ['0']));
        $this->assertFalse($this->str()->contains('qwerty', 0));
        $this->assertFalse($this->str()->contains('qwerty', '0'));
        $this->assertFalse($this->str()->contains('', ''));
    }

    public function testRandom()
    {
        $this->assertEquals(16, strlen($this->str()->random()));

        $randomInteger = random_int(1, 100);

        $this->assertEquals($randomInteger, strlen($this->str()->random($randomInteger)));

        $this->assertIsString($this->str()->random());
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->str()->isEmpty(''));
        $this->assertTrue($this->str()->isEmpty(' '));
        $this->assertTrue($this->str()->isEmpty('      '));
        $this->assertTrue($this->str()->isEmpty(null));

        $this->assertFalse($this->str()->isEmpty(0));
        $this->assertFalse($this->str()->isEmpty('   0   '));
        $this->assertFalse($this->str()->isEmpty(false));
        $this->assertFalse($this->str()->isEmpty([]));

        $this->assertFalse($this->str()->isEmpty(new Foo()));
        $this->assertFalse($this->str()->isEmpty(new Bar()));
        $this->assertFalse($this->str()->isEmpty(new Baz()));
        $this->assertFalse($this->str()->isEmpty(new Baq()));
        $this->assertFalse($this->str()->isEmpty(new Arrayable()));
    }

    public function testDoesntEmpty()
    {
        $this->assertFalse($this->str()->doesntEmpty(''));
        $this->assertFalse($this->str()->doesntEmpty(' '));
        $this->assertFalse($this->str()->doesntEmpty('      '));
        $this->assertFalse($this->str()->doesntEmpty(null));

        $this->assertTrue($this->str()->doesntEmpty(0));
        $this->assertTrue($this->str()->doesntEmpty('   0   '));
        $this->assertTrue($this->str()->doesntEmpty(false));
        $this->assertTrue($this->str()->doesntEmpty([]));

        $this->assertTrue($this->str()->doesntEmpty(new Foo()));
        $this->assertTrue($this->str()->doesntEmpty(new Bar()));
        $this->assertTrue($this->str()->doesntEmpty(new Baz()));
        $this->assertTrue($this->str()->doesntEmpty(new Baq()));
        $this->assertTrue($this->str()->doesntEmpty(new Arrayable()));
    }

    public function testAscii()
    {
        $this->assertSame('', $this->str()->ascii(null));

        $this->assertSame('@', $this->str()->ascii('@'));
        $this->assertSame('u', $this->str()->ascii('ü'));

        $this->assertSame('h H sht Sht a A ia yo', $this->str()->ascii('х Х щ Щ ъ Ъ иа йо', 'bg'));
        $this->assertSame('ae oe ue Ae Oe Ue', $this->str()->ascii('ä ö ü Ä Ö Ü', 'de'));
    }

    public function testConvertToString()
    {
        $this->assertSame('', $this->str()->convertToString(''));
        $this->assertSame('null', $this->str()->convertToString(null));
        $this->assertSame('foo', $this->str()->convertToString('foo'));
        $this->assertSame('bar', $this->str()->convertToString('bar'));
    }

    public function testMatch()
    {
        $this->assertSame('bar', $this->str()->match('foo bar', '/bar/'));
        $this->assertSame('bar', $this->str()->match('foo bar', '/foo (.*)/'));

        $this->assertNull($this->str()->match('foo bar', '/nothing/'));
    }

    public function testPregReplace()
    {
        $this->assertSame('', $this->str()->pregReplace('', '!\s+!', ''));
        $this->assertSame('', $this->str()->pregReplace(' ', '!\s+!', ''));
        $this->assertSame('', $this->str()->pregReplace(null, '!\s+!', ''));

        $this->assertSame('foobar', $this->str()->pregReplace('foo bar', '!\s+!', ''));
        $this->assertSame('foo-bar', $this->str()->pregReplace('foo bar', '!\s+!', '-'));
        $this->assertSame('foo-bar', $this->str()->pregReplace('foo     bar', '!\s+!', '-'));

        $this->assertSame('71234567890', $this->str()->pregReplace('abc 7 (123)  456-78-90', '!(\W|\D)+!', ''));
    }

    protected function str(): Str
    {
        return new Str();
    }
}
