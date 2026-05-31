<?php

namespace Waahhhh\MinecraftFormatter\Traits;

use RuntimeException;
use Waahhhh\MinecraftFormatter\Enums\MinecraftType;

/**
 * @template TColorCodes of array<array-key, array>
 * @template TFormattingCodes of array<array-key, array>
 */
trait InteractsWithMinecraftType
{
    /**
     * @var TColorCodes
     */
    protected readonly array $colorCodes;

    /**
     * @var TFormattingCodes
     */
    protected readonly array $formattingCodes;

    public function __construct(protected readonly MinecraftType $type)
    {
        $this->colorCodes = match ($this->type) {
            MinecraftType::Bedrock => self::COLOR_CODES_BEDROCK,
            MinecraftType::Java => self::COLOR_CODES_JAVA,
        };

        $this->formattingCodes = match ($this->type) {
            MinecraftType::Bedrock => self::FORMATTING_CODES_BEDROCK,
            MinecraftType::Java => self::FORMATTING_CODES_JAVA,
        };
    }

    /**
     * @return TColorCodes
     */
    public function getColorCodes(): array
    {
        return $this->colorCodes;
    }

    /**
     * @return TFormattingCodes
     */
    public function getFormattingCodes(): array
    {
        return $this->formattingCodes;
    }
}
