<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Stringable;
use Tests\TestCase;

class StringableTest extends TestCase
{
    public function testAscii()
    {
        $this->assertSame('', (string) Stringable::of(null)->ascii());

        $this->assertSame('@', (string) Stringable::of('@')->ascii());
        $this->assertSame('u', (string) Stringable::of('ü')->ascii());

        $this->assertSame('h H sht Sht a A ia yo', (string) Stringable::of('х Х щ Щ ъ Ъ иа йо')->ascii('bg'));
        $this->assertSame('ae oe ue Ae Oe Ue', (string) Stringable::of('ä ö ü Ä Ö Ü')->ascii('de'));
    }

    public function testReplace()
    {
        $this->assertSame('foo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('bZr', (string) Stringable::of('bar')->replace(['a' => 'Z', 's' => 'X']));
        $this->assertSame('bZr', (string) Stringable::of('bar')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('bZr', (string) Stringable::of('bar')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('bZr', (string) Stringable::of('bar')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('foo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('foo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('foo', (string) Stringable::of('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZr', (string) Stringable::of('b{a}r')->replace(['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('bZr', (string) Stringable::of('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('bZr', (string) Stringable::of('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('bZr', (string) Stringable::of('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZz', (string) Stringable::of('b_a_z')->replace(['a' => 'Z', 's' => 'X'], '_%s_'));
        $this->assertSame('bZz', (string) Stringable::of('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '_%s_'));
        $this->assertSame('bZz', (string) Stringable::of('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '_%s_'));
        $this->assertSame('bZz', (string) Stringable::of('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '_%s_'));
    }

    public function testSlug()
    {
        $this->assertSame('hello-world', (string) Stringable::of('hello world')->slug());
        $this->assertSame('hello-world', (string) Stringable::of('hello-world')->slug());
        $this->assertSame('hello-world', (string) Stringable::of('hello_world')->slug());
        $this->assertSame('hello_world', (string) Stringable::of('hello_world')->slug('_'));
        $this->assertSame('user-at-host', (string) Stringable::of('user@host')->slug());

        $this->assertSame('سلام-دنیا', (string) Stringable::of('سلام دنیا')->slug('-', null));
        $this->assertSame('sometext', (string) Stringable::of('some text')->slug(''));
        $this->assertSame('privetmir', (string) Stringable::of('Привет, мир!')->slug(''));

        $this->assertSame('', (string) Stringable::of('')->slug(''));
        $this->assertSame('', (string) Stringable::of('')->slug());
    }

    public function testAfter()
    {
        $this->assertSame('Bar', (string) Stringable::of('Foo Bar')->after(' '));
        $this->assertSame('BaR', (string) Stringable::of('FoO BaR')->after(' '));
        $this->assertSame('bar', (string) Stringable::of('foo bar')->after(' '));

        $this->assertSame('FoO-BaR', (string) Stringable::of('FoO-BaR')->after(' '));
        $this->assertSame('   BaR', (string) Stringable::of('FoO   -   BaR')->after('-'));
        $this->assertSame('  BaR', (string) Stringable::of('FoO   -   BaR')->after(' - '));
    }

    public function testBefore()
    {
        $this->assertSame('Foo', (string) Stringable::of('Foo Bar')->before(' '));
        $this->assertSame('FoO', (string) Stringable::of('FoO BaR')->before(' '));
        $this->assertSame('foo', (string) Stringable::of('foo bar')->before(' '));

        $this->assertSame('FoO-BaR', (string) Stringable::of('FoO-BaR')->before(' '));
        $this->assertSame('FoO   ', (string) Stringable::of('FoO   -   BaR')->before('-'));
        $this->assertSame('FoO  ', (string) Stringable::of('FoO   -   BaR')->before(' - '));
    }

    public function testCamel()
    {
        $this->assertSame('fooBar', (string) Stringable::of('Foo Bar')->camel());
        $this->assertSame('foOBaR', (string) Stringable::of('FoO BaR')->camel());
        $this->assertSame('fooBar', (string) Stringable::of('foo bar')->camel());
        $this->assertSame('foOBaR', (string) Stringable::of('FoO-BaR')->camel());
        $this->assertSame('foOBaR', (string) Stringable::of('FoO   -   BaR')->camel());
    }

    public function testFinish()
    {
        $this->assertSame('ab/', (string) Stringable::of('ab')->finish());
        $this->assertSame('abbc', (string) Stringable::of('ab')->finish('bc'));
        $this->assertSame('abbc', (string) Stringable::of('abbcbc')->finish('bc'));
        $this->assertSame('abcbbc', (string) Stringable::of('abcbbcbc')->finish('bc'));
    }

    public function testLower()
    {
        $this->assertSame('foo bar baz', (string) Stringable::of('FOO BAR BAZ')->lower());
        $this->assertSame('foo bar baz', (string) Stringable::of('fOo Bar bAz')->lower());
    }

    public function testRemoveSpaces()
    {
        $this->assertEquals('foo bar', (string) Stringable::of('foo bar')->removeSpaces());
        $this->assertEquals('foo bar', (string) Stringable::of('foo  bar')->removeSpaces());
        $this->assertEquals('foo bar', (string) Stringable::of('foo    bar')->removeSpaces());

        $this->assertEquals('foo bar baz', (string) Stringable::of('foo bar  baz')->removeSpaces());
        $this->assertEquals('foo bar baz', (string) Stringable::of('foo  bar     baz')->removeSpaces());
        $this->assertEquals('foo bar baz', (string) Stringable::of('foo    bar baz')->removeSpaces());
    }

    public function testSnake()
    {
        $this->assertSame('foo_bar', (string) Stringable::of('Foo Bar')->snake());
        $this->assertSame('fo_o_ba_r', (string) Stringable::of('FoO BaR')->snake());
        $this->assertSame('foo_bar', (string) Stringable::of('foo bar')->snake());
        $this->assertSame('fo_o-_ba_r', (string) Stringable::of('FoO-BaR')->snake());
        $this->assertSame('fo_o-_ba_r', (string) Stringable::of('FoO   -   BaR')->snake());
    }

    public function testStart()
    {
        $this->assertSame('/test/string', (string) Stringable::of('test/string')->start('/'));
        $this->assertSame('/test/string', (string) Stringable::of('/test/string')->start('/'));
        $this->assertSame('/test/string', (string) Stringable::of('//test/string')->start('/'));
    }

    public function testStudly()
    {
        $this->assertSame('FooBar', (string) Stringable::of('Foo Bar')->studly());
        $this->assertSame('FoOBaR', (string) Stringable::of('FoO BaR')->studly());
        $this->assertSame('FooBar', (string) Stringable::of('foo bar')->studly());
        $this->assertSame('FoOBaR', (string) Stringable::of('FoO-BaR')->studly());
        $this->assertSame('FoOBaR', (string) Stringable::of('FoO   -   BaR')->studly());
    }

    public function testSubstr()
    {
        $this->assertSame('Ё', (string) Stringable::of('БГДЖИЛЁ')->substr(-1));
        $this->assertSame('ЛЁ', (string) Stringable::of('БГДЖИЛЁ')->substr(-2));
        $this->assertSame('И', (string) Stringable::of('БГДЖИЛЁ')->substr(-3, 1));
        $this->assertSame('ДЖИЛ', (string) Stringable::of('БГДЖИЛЁ')->substr(2, -1));
        $this->assertSame('ИЛ', (string) Stringable::of('БГДЖИЛЁ')->substr(-3, -1));
        $this->assertSame('ГДЖИЛЁ', (string) Stringable::of('БГДЖИЛЁ')->substr(1));
        $this->assertSame('ГДЖ', (string) Stringable::of('БГДЖИЛЁ')->substr(1, 3));
        $this->assertSame('БГДЖ', (string) Stringable::of('БГДЖИЛЁ')->substr(0, 4));
        $this->assertSame('Ё', (string) Stringable::of('БГДЖИЛЁ')->substr(-1, 1));

        $this->assertEmpty((string) Stringable::of('БГДЖИЛЁ')->substr(4, -4));
        $this->assertEmpty((string) Stringable::of('Б')->substr(2));
    }

    public function testTitle()
    {
        $this->assertSame('Foo Bar', (string) Stringable::of('Foo Bar')->title());
        $this->assertSame('Foo Bar', (string) Stringable::of('FoO BaR')->title());
        $this->assertSame('Foo Bar', (string) Stringable::of('foo bar')->title());
        $this->assertSame('Foo-Bar', (string) Stringable::of('FoO-BaR')->title());
        $this->assertSame('Foo   -   Bar', (string) Stringable::of('FoO   -   BaR')->title());

        $this->assertSame('123', (string) Stringable::of('123')->title());
        $this->assertSame('123', (string) Stringable::of(123)->title());

        $this->assertSame('0', (string) Stringable::of('0')->title());
        $this->assertSame('0', (string) Stringable::of(0)->title());

        $this->assertSame('', (string) Stringable::of('')->title());
        $this->assertSame('', (string) Stringable::of(null)->title());
        $this->assertSame('', (string) Stringable::of(false)->title());
    }

    public function testUpper()
    {
        $this->assertSame('FOO BAR BAZ', (string) Stringable::of('FOO BAR BAZ')->upper());
        $this->assertSame('FOO BAR BAZ', (string) Stringable::of('fOo Bar bAz')->upper());
    }

    public function testCombine()
    {
        $this->assertSame('', (string) Stringable::of(null)->ascii()->replace([])->slug()->after('')->before('')->camel());

        $this->assertSame('FOO - BAR', (string) Stringable::of('FoO       -       BaR')->removeSpaces()->upper());

        $this->assertSame('-bar-', (string) Stringable::of('FoO       -       BaR - BAZ - BAQ')->slug()->after('foo')->before('baz')->before('zzz'));
    }

    public function testMatch()
    {
        $this->assertSame('bar', (string) Stringable::of('foo bar')->match('/bar/'));
        $this->assertSame('bar', (string) Stringable::of('foo bar')->match('/foo (.*)/'));

        $this->assertSame('', (string) Stringable::of('foo bar')->match('/nothing/'));

        $this->assertSame('bar', (string) Stringable::of('FoO       -       BaR - BAZ - BAQ')->slug()->match('/bar/'));
        $this->assertSame('bar', (string) Stringable::of('FoO       -       BaR - BAZ - BAQ')->slug()->match('/foo-(\w+)/'));
    }

    public function testPregReplace()
    {
        $this->assertSame('', (string) Stringable::of('')->pregReplace('!\s+!', ''));
        $this->assertSame('', (string) Stringable::of(' ')->pregReplace('!\s+!', ''));
        $this->assertSame('', (string) Stringable::of(null)->pregReplace('!\s+!', ''));

        $this->assertSame('foobar', (string) Stringable::of('foo bar')->pregReplace('!\s+!', ''));
        $this->assertSame('foo-bar', (string) Stringable::of('foo bar')->pregReplace('!\s+!', '-'));
        $this->assertSame('foo-bar', (string) Stringable::of('foo     bar')->pregReplace('!\s+!', '-'));

        $this->assertSame('+71234567890', (string) Stringable::of('abc 7 (123)  456-78-90')->pregReplace('!(\W|\D)+!', '')->start('+'));
    }
}
