<?php

declare(strict_types=1);

namespace Tests\Unit;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Waahhhh\MinecraftFormatter\Enums\MinecraftType;
use Waahhhh\MinecraftFormatter\Formatter;
use Waahhhh\MinecraftFormatter\Formatter\HtmlFormatter;

class HtmlFormatterTest extends TestCase
{
    public static function dataProviderColorCodes(): Generator
    {
        // Java + Bedrock

        yield 'color black' => [
            'text'         => '§0Text',
            'expectedText' => '<span style="color: #000000">Text</span>',
        ];

        yield 'color dark_blue' => [
            'text'         => '§1Text',
            'expectedText' => '<span style="color: #0000AA">Text</span>',
        ];

        yield 'color dark_green' => [
            'text'         => '§2Text',
            'expectedText' => '<span style="color: #00AA00">Text</span>',
        ];

        yield 'color dark_aqua' => [
            'text'         => '§3Text',
            'expectedText' => '<span style="color: #00AAAA">Text</span>',
        ];

        yield 'color dark_red' => [
            'text'         => '§4Text',
            'expectedText' => '<span style="color: #AA0000">Text</span>',
        ];

        yield 'color dark_purple' => [
            'text'         => '§5Text',
            'expectedText' => '<span style="color: #AA00AA">Text</span>',
        ];

        yield 'color gold' => [
            'text'         => '§6Text',
            'expectedText' => '<span style="color: #FFAA00">Text</span>',
        ];

        yield 'color gray' => [
            'text'         => '§7Text',
            'expectedText' => '<span style="color: #AAAAAA">Text</span>',
        ];

        yield 'color dark_gray' => [
            'text'         => '§8Text',
            'expectedText' => '<span style="color: #555555">Text</span>',
        ];

        yield 'color blue' => [
            'text'         => '§9Text',
            'expectedText' => '<span style="color: #5555FF">Text</span>',
        ];

        yield 'color green' => [
            'text'         => '§aText',
            'expectedText' => '<span style="color: #55FF55">Text</span>',
        ];

        yield 'color aqua' => [
            'text'         => '§bText',
            'expectedText' => '<span style="color: #55FFFF">Text</span>',
        ];

        yield 'color red' => [
            'text'         => '§cText',
            'expectedText' => '<span style="color: #FF5555">Text</span>',
        ];

        yield 'color light_purple' => [
            'text'         => '§dText',
            'expectedText' => '<span style="color: #FF55FF">Text</span>',
        ];

        yield 'color yellow' => [
            'text'         => '§eText',
            'expectedText' => '<span style="color: #FFFF55">Text</span>',
        ];

        yield 'color white' => [
            'text'         => '§fText',
            'expectedText' => '<span style="color: #FFFFFF">Text</span>',
        ];

        // Bedrock Edition only

        yield 'color minecoin_gold' => [
            'text'         => '§gText',
            'expectedText' => '§gText',
        ];

        yield 'color material_quartz' => [
            'text'         => '§hText',
            'expectedText' => '§hText',
        ];

        yield 'color material_iron' => [
            'text'         => '§iText',
            'expectedText' => '§iText',
        ];

        yield 'color material_netherite' => [
            'text'         => '§jText',
            'expectedText' => '§jText',
        ];

        yield 'color material_redstone' => [
            'text'         => '§mText',
            'expectedText' => '<s>Text</s>',
        ];

        yield 'color material_copper' => [
            'text'         => '§nText',
            'expectedText' => '<u>Text</u>',
        ];

        yield 'color material_gold' => [
            'text'         => '§pText',
            'expectedText' => '§pText',
        ];

        yield 'color material_emerald' => [
            'text'         => '§qText',
            'expectedText' => '§qText',
        ];

        yield 'color material_diamond' => [
            'text'         => '§sText',
            'expectedText' => '§sText',
        ];

        yield 'color material_lapis' => [
            'text'         => '§tText',
            'expectedText' => '§tText',
        ];

        yield 'color material_amethyst' => [
            'text'         => '§uText',
            'expectedText' => '§uText',
        ];

        yield 'color material_resin' => [
            'text'         => '§vText',
            'expectedText' => '§vText',
        ];

        yield 'color party_blue_color' => [
            'text'         => '§wText',
            'expectedText' => '§wText',
        ];
    }

    public static function dataProviderFormattingCodes(): Generator
    {
        yield 'font obfuscated' => [
            'text'         => '§kText',
            'expectedText' => '****',
        ];

        yield 'font bold' => [
            'text'         => '§lText',
            'expectedText' => '<b>Text</b>',
        ];

        yield 'font strikethrough' => [
            'text'         => '§mText',
            'expectedText' => '<s>Text</s>',
        ];

        yield 'font underline' => [
            'text'         => '§nText',
            'expectedText' => '<u>Text</u>',
        ];

        yield 'font italic' => [
            'text'         => '§oText',
            'expectedText' => '<i>Text</i>',
        ];

        yield 'font reset' => [
            'text'         => '§rText',
            'expectedText' => 'Text',
        ];
    }

    public function testCanCreate(): void
    {
        $sut = new HtmlFormatter(type: MinecraftType::Java);

        $this->assertInstanceOf(Formatter::class, $sut);
    }

    #[DataProvider('dataProviderColorCodes')]
    public function testColorCodes(string $text, string $expectedText): void
    {
        $sut    = new HtmlFormatter(type: MinecraftType::Java);
        $result = $sut->format(text: $text);

        $this->assertSame($expectedText, $result);
    }

    #[DataProvider('dataProviderFormattingCodes')]
    public function testFormattingCodes(string $text, string $expectedText): void
    {
        $sut    = new HtmlFormatter(type: MinecraftType::Java);
        $result = $sut->format(text: $text);

        $this->assertSame($expectedText, $result);
    }

    public function testCustomText(): void
    {
        $expected = '<b>This</b> is a <span style="color: #FF5555">colored</span> text';

        $sut    = new HtmlFormatter(type: MinecraftType::Java);
        $result = $sut->format(text: '§lThis§r is a §ccolored§r text');

        $this->assertSame($expected, $result);
    }

    public function testMultipleCodes(): void
    {
        $expected = '<span style="color: #FF5555"><b>Test test</b></span>';

        $sut    = new HtmlFormatter(type: MinecraftType::Java);
        $result = $sut->format(text: '§c§lTest test§r');

        $this->assertSame($expected, $result);
    }
}
