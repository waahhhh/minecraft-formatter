<?php

declare(strict_types=1);

namespace Waahhhh\MinecraftFormatterTest;

use Generator;
use PHPUnit\Framework\TestCase;
use Waahhhh\MinecraftFormatter\HtmlFormatter;
use Waahhhh\MinecraftFormatter\Formatter;

class HtmlFormatterTest extends TestCase
{
    public function testCanCreate(): void
    {
        $formatter = new HtmlFormatter();

        self::assertInstanceOf(Formatter::class, $formatter);
    }

    public function dataProviderTexts(): Generator
    {
        yield 'color black' => [
            'text' => '§0Text',
            'expectedText' => '<span style="#000000">Text</span>',
        ];

        yield 'color dark blue' => [
            'text' => '§1Text',
            'expectedText' => '<span style="#0000AA">Text</span>',
        ];

        yield 'color dark green' => [
            'text' => '§2Text',
            'expectedText' => '<span style="#00AA00">Text</span>',
        ];

        yield 'color dark aqua' => [
            'text' => '§3Text',
            'expectedText' => '<span style="#00AAAA">Text</span>',
        ];

        yield 'color dark red' => [
            'text' => '§4Text',
            'expectedText' => '<span style="#AA0000">Text</span>',
        ];

        yield 'color dark purple' => [
            'text' => '§5Text',
            'expectedText' => '<span style="#AA00AA">Text</span>',
        ];

        yield 'color gold' => [
            'text' => '§6Text',
            'expectedText' => '<span style="#FFAA00">Text</span>',
        ];

        yield 'color gray' => [
            'text' => '§7Text',
            'expectedText' => '<span style="#AAAAAA">Text</span>',
        ];

        yield 'color dark gray' => [
            'text' => '§8Text',
            'expectedText' => '<span style="#555555">Text</span>',
        ];

        yield 'color blue' => [
            'text' => '§9Text',
            'expectedText' => '<span style="#5555FF">Text</span>',
        ];

        yield 'color green' => [
            'text' => '§aText',
            'expectedText' => '<span style="#55FF55">Text</span>',
        ];

        yield 'color aqua' => [
            'text' => '§bText',
            'expectedText' => '<span style="#55FFFF">Text</span>',
        ];

        yield 'color red' => [
            'text' => '§cText',
            'expectedText' => '<span style="#FF5555">Text</span>',
        ];

        yield 'color light purple' => [
            'text' => '§dText',
            'expectedText' => '<span style="#FF55FF">Text</span>',
        ];

        yield 'color yellow' => [
            'text' => '§eText',
            'expectedText' => '<span style="#FFFF55">Text</span>',
        ];

        yield 'color white' => [
            'text' => '§fText',
            'expectedText' => '<span style="#FFFFFF">Text</span>',
        ];

        yield 'color minecoin gold' => [
            'text' => '§gText',
            'expectedText' => '<span style="#DDD605">Text</span>',
        ];

        yield 'font obfuscated' => [
            'text' => '§kText',
            'expectedText' => '****',
        ];

        yield 'font bold' => [
            'text' => '§lText',
            'expectedText' => '<b>Text</b>',
        ];

        yield 'font strikethrough' => [
            'text' => '§mText',
            'expectedText' => '<s>Text</s>',
        ];

        yield 'font underline' => [
            'text' => '§nText',
            'expectedText' => '<u>Text</u>',
        ];

        yield 'font italic' => [
            'text' => '§oText',
            'expectedText' => '<i>Text</i>',
        ];

        yield 'font reset' => [
            'text' => '§rText',
            'expectedText' => 'Text',
        ];
    }

    /**
     * @dataProvider dataProviderTexts
     */
    public function testFormat(string $text, string $expectedText): void
    {
        $formatter = new HtmlFormatter();

        self::assertSame($expectedText, $formatter->format($text));
    }
}
