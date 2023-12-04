<?php

namespace Differ\Differ;

use function Functional\sort;

function generateDiff(mixed $firstData, mixed $secondData): mixed
{
    $firstDataKey = array_keys($firstData);
    $secondDataKey = array_keys($secondData);
    $keys = array_unique(array_merge($firstDataKey, $secondDataKey));
    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));

    return array_map(function ($key) use ($firstData, $secondData) {
        if (!array_key_exists($key, $firstData)) {
            return "- {$key}: {$secondData[$key]}";
        }

        if (!array_key_exists($key, $secondData)) {
            return "+ {$key}: {$firstData[$key]}";
        }

        if ($firstData === $secondData) {
            return " {$key}: {$firstData[$key]}";
        }

        return "- {$key}: {$firstData[$key]}\n+ {$key}: {$secondData[$key]}";
    }, $sortedKeys);

    
}

function genDiff(string $firstFile, string $secondFile)
{
    $data1 = json_decode(file_get_contents($firstFile), true);
    $data2 = json_decode(file_get_contents($secondFile), true);

    return generateDiff($data1, $data2);
}