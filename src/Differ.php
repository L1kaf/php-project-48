<?php

namespace Differ\Differ;

use function Functional\sort;

function generateDiff(mixed $firstData, mixed $secondData): mixed
{
    $firstDataKey = array_keys($firstData);
    $secondDataKey = array_keys($secondData);
    $keys = array_unique(array_merge($firstDataKey, $secondDataKey));
    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));

    $diffLines = array_map(function ($key) use ($firstData, $secondData) {
        $formatValue = function ($value) {
            return is_bool($value) ? var_export($value, true) : $value;
        };

        if (!array_key_exists($key, $firstData)) {
            return "    + {$key}: {$formatValue($secondData[$key])}";
        }

        if (!array_key_exists($key, $secondData)) {
            return "    - {$key}: {$formatValue($firstData[$key])}";
        }

        if ($firstData[$key] === $secondData[$key]) {
            return "      {$key}: {$formatValue($firstData[$key])}";
        }

        return "    - {$key}: {$formatValue($firstData[$key])}\n    + {$key}: {$formatValue($secondData[$key])}";
    }, $sortedKeys);

    return "{\n" . implode("\n", $diffLines) . "\n}\n";
}

function genDiff(string $firstFile, string $secondFile): string
{
    $data1 = json_decode(file_get_contents($firstFile), true);
    $data2 = json_decode(file_get_contents($secondFile), true);

    return generateDiff($data1, $data2);
}
