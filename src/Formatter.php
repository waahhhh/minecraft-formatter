<?php

declare(strict_types=1);

namespace Waahhhh\MinecraftFormatter;

interface Formatter
{
    public function format(string $text): string;
}
