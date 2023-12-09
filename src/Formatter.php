<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\formatStylish;

function formatFile(string $format, mixed $diff): string
{
    return formatStylish($diff);
}
