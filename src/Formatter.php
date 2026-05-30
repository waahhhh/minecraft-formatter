<?php

declare(strict_types=1);

namespace Waahhhh\MinecraftFormatter;

/**
 * @template TColorCodes of array<array-key, array>
 * @template TFormattingCodes of array<array-key, array>
 */
interface Formatter
{
    public const array COLOR_CODES_BEDROCK = [];
    public const array COLOR_CODES_JAVA = [];

    public const array FORMATTING_CODES_BEDROCK = [];
    public const array FORMATTING_CODES_JAVA = [];

    /**
     * @return TColorCodes
     */
    public function getColorCodes(): array;

    /**
     * @return TFormattingCodes
     */
    public function getFormattingCodes(): array;

    public function format(string $text): string;
}
