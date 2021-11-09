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

namespace Tests\Helpers\Ables;

use DragonCode\Support\Helpers\Ables\Stringable;
use Tests\TestCase;

class StringableTest extends TestCase
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

    public function testAscii()
    {
        $this->assertSame('', (string) $this->str()->ascii());

        $this->assertSame('@', (string) $this->str('@')->ascii());
        $this->assertSame('u', (string) $this->str('ü')->ascii());

        $this->assertSame('h H sht Sht a A ia yo', (string) $this->str('х Х щ Щ ъ Ъ иа йо')->ascii('bg'));
        $this->assertSame('ae oe ue Ae Oe Ue', (string) $this->str('ä ö ü Ä Ö Ü')->ascii('de'));
    }

    public function testReplace()
    {
        $this->assertSame('foo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X']));
        $this->assertSame('fQQ', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('Eoo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('EPP', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('bZr', (string) $this->str('bar')->replace(['a' => 'Z', 's' => 'X']));
        $this->assertSame('bZr', (string) $this->str('bar')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q']));
        $this->assertSame('bZr', (string) $this->str('bar')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E']));
        $this->assertSame('bZr', (string) $this->str('bar')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P']));

        $this->assertSame('foo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('foo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('foo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('foo', (string) $this->str('foo')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZr', (string) $this->str('b{a}r')->replace(['a' => 'Z', 's' => 'X'], '{%s}'));
        $this->assertSame('bZr', (string) $this->str('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '{%s}'));
        $this->assertSame('bZr', (string) $this->str('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '{%s}'));
        $this->assertSame('bZr', (string) $this->str('b{a}r')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '{%s}'));

        $this->assertSame('bZz', (string) $this->str('b_a_z')->replace(['a' => 'Z', 's' => 'X'], '_%s_'));
        $this->assertSame('bZz', (string) $this->str('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'o' => 'Q'], '_%s_'));
        $this->assertSame('bZz', (string) $this->str('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E'], '_%s_'));
        $this->assertSame('bZz', (string) $this->str('b_a_z')->replace(['a' => 'Z', 's' => 'X', 'f' => 'E', 'o' => 'P'], '_%s_'));
    }

    public function testSlug()
    {
        $this->assertSame('hello-world', (string) $this->str('hello world')->slug());
        $this->assertSame('hello-world', (string) $this->str('hello-world')->slug());
        $this->assertSame('hello-world', (string) $this->str('hello_world')->slug());
        $this->assertSame('hello_world', (string) $this->str('hello_world')->slug('_'));
        $this->assertSame('user-at-host', (string) $this->str('user@host')->slug());

        $this->assertSame('سلام-دنیا', (string) $this->str('سلام دنیا')->slug('-', null));
        $this->assertSame('sometext', (string) $this->str('some text')->slug(''));
        $this->assertSame('privetmir', (string) $this->str('Привет, мир!')->slug(''));

        $this->assertSame('', (string) $this->str('')->slug(''));
        $this->assertSame('', (string) $this->str('')->slug());
    }

    public function testAfter()
    {
        $this->assertSame('Bar', (string) $this->str('Foo Bar')->after(' '));
        $this->assertSame('BaR', (string) $this->str('FoO BaR')->after(' '));
        $this->assertSame('bar', (string) $this->str('foo bar')->after(' '));

        $this->assertSame('FoO-BaR', (string) $this->str('FoO-BaR')->after(' '));
        $this->assertSame('   BaR', (string) $this->str('FoO   -   BaR')->after('-'));
        $this->assertSame('  BaR', (string) $this->str('FoO   -   BaR')->after(' - '));
    }

    public function testBefore()
    {
        $this->assertSame('Foo', (string) $this->str('Foo Bar')->before(' '));
        $this->assertSame('FoO', (string) $this->str('FoO BaR')->before(' '));
        $this->assertSame('foo', (string) $this->str('foo bar')->before(' '));

        $this->assertSame('FoO-BaR', (string) $this->str('FoO-BaR')->before(' '));
        $this->assertSame('FoO   ', (string) $this->str('FoO   -   BaR')->before('-'));
        $this->assertSame('FoO  ', (string) $this->str('FoO   -   BaR')->before(' - '));
    }

    public function testCamel()
    {
        $this->assertSame('fooBar', (string) $this->str('Foo Bar')->camel());
        $this->assertSame('foOBaR', (string) $this->str('FoO BaR')->camel());
        $this->assertSame('fooBar', (string) $this->str('foo bar')->camel());
        $this->assertSame('foOBaR', (string) $this->str('FoO-BaR')->camel());
        $this->assertSame('foOBaR', (string) $this->str('FoO   -   BaR')->camel());
    }

    public function testFinish()
    {
        $this->assertSame('ab/', (string) $this->str('ab')->finish());
        $this->assertSame('abbc', (string) $this->str('ab')->finish('bc'));
        $this->assertSame('abbc', (string) $this->str('abbcbc')->finish('bc'));
        $this->assertSame('abcbbc', (string) $this->str('abcbbcbc')->finish('bc'));
    }

    public function testLower()
    {
        $this->assertSame('foo bar baz', (string) $this->str('FOO BAR BAZ')->lower());
        $this->assertSame('foo bar baz', (string) $this->str('fOo Bar bAz')->lower());
    }

    public function testRemoveSpaces()
    {
        $this->assertEquals('foo bar', (string) $this->str('foo bar')->removeSpaces());
        $this->assertEquals('foo bar', (string) $this->str('foo  bar')->removeSpaces());
        $this->assertEquals('foo bar', (string) $this->str('foo    bar')->removeSpaces());

        $this->assertEquals('foo bar baz', (string) $this->str('foo bar  baz')->removeSpaces());
        $this->assertEquals('foo bar baz', (string) $this->str('foo  bar     baz')->removeSpaces());
        $this->assertEquals('foo bar baz', (string) $this->str('foo    bar baz')->removeSpaces());
    }

    public function testSnake()
    {
        $this->assertSame('foo_bar', (string) $this->str('Foo Bar')->snake());
        $this->assertSame('fo_o_ba_r', (string) $this->str('FoO BaR')->snake());
        $this->assertSame('foo_bar', (string) $this->str('foo bar')->snake());
        $this->assertSame('fo_o-_ba_r', (string) $this->str('FoO-BaR')->snake());
        $this->assertSame('fo_o-_ba_r', (string) $this->str('FoO   -   BaR')->snake());
    }

    public function testStart()
    {
        $this->assertSame('/test/string', (string) $this->str('test/string')->start('/'));
        $this->assertSame('/test/string', (string) $this->str('/test/string')->start('/'));
        $this->assertSame('/test/string', (string) $this->str('//test/string')->start('/'));
    }

    public function testEnd()
    {
        $this->assertSame('test/string/', (string) $this->str('test/string')->end('/'));
        $this->assertSame('test/string/', (string) $this->str('/test/string')->end('/'));
        $this->assertSame('test/string/', (string) $this->str('//test/string')->end('/'));
    }

    public function testStudly()
    {
        $this->assertSame('FooBar', (string) $this->str('Foo Bar')->studly());
        $this->assertSame('FoOBaR', (string) $this->str('FoO BaR')->studly());
        $this->assertSame('FooBar', (string) $this->str('foo bar')->studly());
        $this->assertSame('FoOBaR', (string) $this->str('FoO-BaR')->studly());
        $this->assertSame('FoOBaR', (string) $this->str('FoO   -   BaR')->studly());
    }

    public function testSubstr()
    {
        $this->assertSame('Ё', (string) $this->str('БГДЖИЛЁ')->substr(-1));
        $this->assertSame('ЛЁ', (string) $this->str('БГДЖИЛЁ')->substr(-2));
        $this->assertSame('И', (string) $this->str('БГДЖИЛЁ')->substr(-3, 1));
        $this->assertSame('ДЖИЛ', (string) $this->str('БГДЖИЛЁ')->substr(2, -1));
        $this->assertSame('ИЛ', (string) $this->str('БГДЖИЛЁ')->substr(-3, -1));
        $this->assertSame('ГДЖИЛЁ', (string) $this->str('БГДЖИЛЁ')->substr(1));
        $this->assertSame('ГДЖ', (string) $this->str('БГДЖИЛЁ')->substr(1, 3));
        $this->assertSame('БГДЖ', (string) $this->str('БГДЖИЛЁ')->substr(0, 4));
        $this->assertSame('Ё', (string) $this->str('БГДЖИЛЁ')->substr(-1, 1));

        $this->assertEmpty((string) $this->str('БГДЖИЛЁ')->substr(4, -4));
        $this->assertEmpty((string) $this->str('Б')->substr(2));
    }

    public function testTitle()
    {
        $this->assertSame('Foo Bar', (string) $this->str('Foo Bar')->title());
        $this->assertSame('Foo Bar', (string) $this->str('FoO BaR')->title());
        $this->assertSame('Foo Bar', (string) $this->str('foo bar')->title());
        $this->assertSame('Foo-Bar', (string) $this->str('FoO-BaR')->title());
        $this->assertSame('Foo   -   Bar', (string) $this->str('FoO   -   BaR')->title());

        $this->assertSame('123', (string) $this->str('123')->title());
        $this->assertSame('123', (string) $this->str(123)->title());

        $this->assertSame('0', (string) $this->str('0')->title());
        $this->assertSame('0', (string) $this->str(0)->title());

        $this->assertSame('', (string) $this->str('')->title());
        $this->assertSame('', (string) $this->str(null)->title());
        $this->assertSame('', (string) $this->str(false)->title());
    }

    public function testUpper()
    {
        $this->assertSame('FOO BAR BAZ', (string) $this->str('FOO BAR BAZ')->upper());
        $this->assertSame('FOO BAR BAZ', (string) $this->str('fOo Bar bAz')->upper());
    }

    public function testTrim()
    {
        $this->assertSame('foo', (string) $this->str('  foo  ')->trim());
        $this->assertSame('foo', (string) $this->str('barfoobar')->trim('bar'));
    }

    public function testMatch()
    {
        $this->assertSame('bar', (string) $this->str('foo bar')->match('/bar/'));
        $this->assertSame('bar', (string) $this->str('foo bar')->match('/foo (.*)/'));

        $this->assertSame('', (string) $this->str('foo bar')->match('/nothing/'));

        $this->assertSame('bar', (string) $this->str('FoO       -       BaR - BAZ - BAQ')->slug()->match('/bar/'));
        $this->assertSame('bar', (string) $this->str('FoO       -       BaR - BAZ - BAQ')->slug()->match('/foo-(\w+)/'));
    }

    public function testPregReplace()
    {
        $this->assertSame('', (string) $this->str('')->pregReplace('!\s+!', ''));
        $this->assertSame('', (string) $this->str(' ')->pregReplace('!\s+!', ''));
        $this->assertSame('', (string) $this->str(null)->pregReplace('!\s+!', ''));

        $this->assertSame('foobar', (string) $this->str('foo bar')->pregReplace('!\s+!', ''));
        $this->assertSame('foo-bar', (string) $this->str('foo bar')->pregReplace('!\s+!', '-'));
        $this->assertSame('foo-bar', (string) $this->str('foo     bar')->pregReplace('!\s+!', '-'));

        $this->assertSame('+71234567890', (string) $this->str('abc 7 (123)  456-78-90')->pregReplace('!(\W|\D)+!', '')->start('+'));
    }

    public function testCombine()
    {
        $this->assertSame('', (string) $this->str(null)->ascii()->replace([])->slug()->after('')->before('')->camel());

        $this->assertSame('FOO - BAR', (string) $this->str('FoO       -       BaR')->removeSpaces()->upper());

        $this->assertSame('-bar-', (string) $this->str('FoO       -       BaR - BAZ - BAQ')->slug()->after('foo')->before('baz')->before('zzz'));
    }

    protected function str(?string $value = null): Stringable
    {
        return new Stringable($value);
    }
}
