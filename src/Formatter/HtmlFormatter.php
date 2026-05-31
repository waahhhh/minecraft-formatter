<?php

declare(strict_types=1);

namespace Waahhhh\MinecraftFormatter\Formatter;

use Illuminate\Support\Str;
use Waahhhh\MinecraftFormatter\Formatter;
use Waahhhh\MinecraftFormatter\Traits\InteractsWithMinecraftType;

use function array_shift;
use function preg_split;

/**
 * @source https://minecraft.wiki/w/Formatting_codes
 *
 * @phpstan-type TColorCodes array<int|string, array{
 *     name: string,
 *     foregroundColor: string,
 *     backgroundColor: string,
 * }>
 * @phpstan-type TFormattingCodes array<string, array{
 *     name: string,
 *     obfuscated?: bool,
 *     open?: string,
 *     close?: string,
 *     reset?: bool,
 * }>
 *
 * @implements Formatter<TColorCodes, TFormattingCodes>
 */
readonly class HtmlFormatter implements Formatter
{
    /**
     * @use InteractsWithMinecraftType<TColorCodes, TFormattingCodes>
     */
    use InteractsWithMinecraftType;

    public const array COLOR_CODES_BEDROCK = [
        '0' => ['name' => 'black', 'foregroundColor' => '#000000', 'backgroundColor' => '#000000'],
        '1' => ['name' => 'dark_blue', 'foregroundColor' => '#0000AA', 'backgroundColor' => '#00002A'],
        '2' => ['name' => 'dark_green', 'foregroundColor' => '#00AA00', 'backgroundColor' => '#002A00'],
        '3' => ['name' => 'dark_aqua', 'foregroundColor' => '#00AAAA', 'backgroundColor' => '#002A2A'],
        '4' => ['name' => 'dark_red', 'foregroundColor' => '#AA0000', 'backgroundColor' => '#2A0000'],
        '5' => ['name' => 'dark_purple', 'foregroundColor' => '#AA00AA', 'backgroundColor' => '#2A002A'],
        '6' => ['name' => 'gold', 'foregroundColor' => '#FFAA00', 'backgroundColor' => '#2A2A00'],
        '7' => ['name' => 'gray', 'foregroundColor' => '#C6C6C6', 'backgroundColor' => '#313131'],
        '8' => ['name' => 'dark_gray', 'foregroundColor' => '#555555', 'backgroundColor' => '#151515'],
        '9' => ['name' => 'blue', 'foregroundColor' => '#5555FF', 'backgroundColor' => '#15153F'],
        'a' => ['name' => 'green', 'foregroundColor' => '#55FF55', 'backgroundColor' => '#153F15'],
        'b' => ['name' => 'aqua', 'foregroundColor' => '#55FFFF', 'backgroundColor' => '#153F3F'],
        'c' => ['name' => 'red', 'foregroundColor' => '#FF5555', 'backgroundColor' => '#3F1515'],
        'd' => ['name' => 'light_purple', 'foregroundColor' => '#FF55FF', 'backgroundColor' => '#3F153F'],
        'e' => ['name' => 'yellow', 'foregroundColor' => '#FFFF55', 'backgroundColor' => '#3F3F15'],
        'f' => ['name' => 'white', 'foregroundColor' => '#FFFFFF', 'backgroundColor' => '#3F3F3F'],
        'g' => ['name' => 'minecoin_gold', 'foregroundColor' => '#DDD605', 'backgroundColor' => '#373501'],
        'h' => ['name' => 'material_quartz', 'foregroundColor' => '#E3D4D1', 'backgroundColor' => '#383534'],
        'i' => ['name' => 'material_iron', 'foregroundColor' => '#CECACA', 'backgroundColor' => '#333232'],
        'j' => ['name' => 'material_netherite', 'foregroundColor' => '#443A3B', 'backgroundColor' => '#110E0E'],
        'm' => ['name' => 'material_redstone', 'foregroundColor' => '#971607', 'backgroundColor' => '#250501'],
        'n' => ['name' => 'material_copper', 'foregroundColor' => '#B4684D', 'backgroundColor' => '#2D1A13'],
        'p' => ['name' => 'material_gold', 'foregroundColor' => '#DEB12D', 'backgroundColor' => '#372C0B'],
        'q' => ['name' => 'material_emerald', 'foregroundColor' => '#11A036', 'backgroundColor' => '#04280D'],
        's' => ['name' => 'material_diamond', 'foregroundColor' => '#2CBAA8', 'backgroundColor' => '#0B2E2A'],
        't' => ['name' => 'material_lapis', 'foregroundColor' => '#21497B', 'backgroundColor' => '#08121E'],
        'u' => ['name' => 'material_amethyst', 'foregroundColor' => '#9A5CC6', 'backgroundColor' => '#261731'],
        'v' => ['name' => 'material_resin', 'foregroundColor' => '#EB7114', 'backgroundColor' => '#3B1D05'],
        'w' => ['name' => 'party_blue_color', 'foregroundColor' => '#8CB3FF', 'backgroundColor' => '#232D40'],
    ];

    public const array COLOR_CODES_JAVA = [
        '0' => ['name' => 'black', 'foregroundColor' => '#000000', 'backgroundColor' => '#000000'],
        '1' => ['name' => 'dark_blue', 'foregroundColor' => '#0000AA', 'backgroundColor' => '#00002A'],
        '2' => ['name' => 'dark_green', 'foregroundColor' => '#00AA00', 'backgroundColor' => '#002A00'],
        '3' => ['name' => 'dark_aqua', 'foregroundColor' => '#00AAAA', 'backgroundColor' => '#002A2A'],
        '4' => ['name' => 'dark_red', 'foregroundColor' => '#AA0000', 'backgroundColor' => '#2A0000'],
        '5' => ['name' => 'dark_purple', 'foregroundColor' => '#AA00AA', 'backgroundColor' => '#2A002A'],
        '6' => ['name' => 'gold', 'foregroundColor' => '#FFAA00', 'backgroundColor' => '#2A2A00'],
        '7' => ['name' => 'gray', 'foregroundColor' => '#AAAAAA', 'backgroundColor' => '#2A2A2A'],
        '8' => ['name' => 'dark_gray', 'foregroundColor' => '#555555', 'backgroundColor' => '#151515'],
        '9' => ['name' => 'blue', 'foregroundColor' => '#5555FF', 'backgroundColor' => '#15153F'],
        'a' => ['name' => 'green', 'foregroundColor' => '#55FF55', 'backgroundColor' => '#153F15'],
        'b' => ['name' => 'aqua', 'foregroundColor' => '#55FFFF', 'backgroundColor' => '#153F3F'],
        'c' => ['name' => 'red', 'foregroundColor' => '#FF5555', 'backgroundColor' => '#3F1515'],
        'd' => ['name' => 'light_purple', 'foregroundColor' => '#FF55FF', 'backgroundColor' => '#3F153F'],
        'e' => ['name' => 'yellow', 'foregroundColor' => '#FFFF55', 'backgroundColor' => '#3F3F15'],
        'f' => ['name' => 'white', 'foregroundColor' => '#FFFFFF', 'backgroundColor' => '#3F3F3F'],
    ];

    public const array FORMATTING_CODES_BEDROCK = [
        'k' => ['name' => 'obfuscated', 'obfuscated' => true],
        'l' => ['name' => 'bold', 'open' => '<b>', 'close' => '</b>'],
        'o' => ['name' => 'italic', 'open' => '<i>', 'close' => '</i>'],
        'r' => ['name' => 'reset', 'reset' => true],
    ];

    public const array FORMATTING_CODES_JAVA = [
        'k' => ['name' => 'obfuscated', 'obfuscated' => true],
        'l' => ['name' => 'bold', 'open' => '<b>', 'close' => '</b>'],
        'm' => ['name' => 'strikethrough', 'open' => '<s>', 'close' => '</s>'],
        'n' => ['name' => 'underlined', 'open' => '<u>', 'close' => '</u>'],
        'o' => ['name' => 'italic', 'open' => '<i>', 'close' => '</i>'],
        'r' => ['name' => 'reset', 'reset' => true],
    ];

    public function format(string $text): string
    {
        $parts = preg_split('/(§.)/', $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        if ($parts === false) {
            return $text;
        }

        $html = '';

        // A top-level §r has no opening wrapper to close, so keep resolving
        // until all tokens are consumed.
        while ($parts !== []) {
            [$segment, $parts] = $this->resolve($parts);

            $html .= $segment;
        }

        return $html;
    }

    /**
     * Recursively resolves an array of tokens into nested HTML.
     *
     * Returns a tuple of [renderedHtml, remainingTokens]. When a wrapper
     * (color or formatting code) opens a recursive call, §r will terminate
     * that call early and hand the unconsumed tokens back to the caller so
     * it can continue rendering siblings after the closing tag.
     *
     * @param  array<int, string> $parts
     * @return array{0: string, 1: array<int, string>}
     */
    private function resolve(array $parts): array
    {
        $html = '';

        while ($parts !== []) {
            $token = array_shift($parts);
            $code  = $this->extractCode($token);

            // ── Plain text ────────────────────────────────────────────────────
            if ($code === null) {
                $html .= $token;

                continue;
            }

            // ── §r — reset ────────────────────────────────────────────────────
            // Return early so the parent wrapper call receives the remaining
            // tokens and can continue rendering after its closing tag.
            if ($code === 'r') {
                return [$html, $parts];
            }

            // ── §k — obfuscated ───────────────────────────────────────────────
            // Peek at the next token: if it is plain text, replace every
            // character with * and consume it; otherwise leave it for the
            // next iteration so it is handled by its own branch.
            if ($code === 'k') {
                if ($parts !== [] && $this->extractCode($parts[0]) === null) {
                    $next  = array_shift($parts);
                    $html .= Str::repeat('*', Str::length($next));
                }

                continue;
            }

            // ── Formatting code ───────────────────────────────────────────────
            // Checked before color codes so that §m and §n resolve as
            // strikethrough / underline on Java Edition.
            if (isset($this->getFormattingCodes()[$code]['open'], $this->getFormattingCodes()[$code]['close'])) {
                $open  = (string)$this->getFormattingCodes()[$code]['open'];
                $close = (string)$this->getFormattingCodes()[$code]['close'];

                [$inner, $parts] = $this->resolve($parts);

                $html .= "{$open}{$inner}{$close}";

                continue;
            }

            // ── Color code ────────────────────────────────────────────────────
            if (isset($this->getColorCodes()[$code])) {
                $color = (string)$this->getColorCodes()[$code]['foregroundColor'];

                [$inner, $parts] = $this->resolve($parts);

                $html .= "<span style=\"color: {$color}\">{$inner}</span>";

                continue;
            }

            // ── Unknown code — pass through ───────────────────────────────────
            $html .= $token;
        }

        return [$html, []];
    }

    /**
     * Extracts the single code character from a §x token.
     * Returns null when the token is plain text (does not start with §).
     */
    private function extractCode(string $token): ?string
    {
        if (!Str::startsWith($token, '§')) {
            return null;
        }

        return Str::substr($token, 1, 1);
    }
}
