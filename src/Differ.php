<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parseFile;
use function Differ\Formatter\formatFile;

function generateDiff(mixed $firstData, mixed $secondData): mixed
{
    $firstDataKey = array_keys($firstData);
    $secondDataKey = array_keys($secondData);
    $keys = array_unique(array_merge($firstDataKey, $secondDataKey));
    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));
    // Делаем статусы согласно их совпадению с другим файлом
    return array_map(function ($key) use ($firstData, $secondData) {
        $firstValue = $firstData[$key] ?? null;
        $secondValue = $secondData[$key] ?? null;

        if (!array_key_exists($key, $firstData)) {
            return [
                "status" => "added",
                "key" => $key,
                'firstValue' => $secondValue,
                "secondValue" => null
            ];
        }

        if (!array_key_exists($key, $secondData)) {
            return [
                "status" => "deleted",
                "key" => $key,
                "firstValue" => $firstValue,
                "secondValue" => null
            ];
        }

        if ($firstData[$key] === $secondValue) {
            return [
                "status" => "unchanged",
                "key" => $key,
                "firstValue" => $firstValue,
                "secondValue" => null
            ];
        }

        if (is_array($firstValue) && is_array($secondValue)) {
            return [
                "status" => "nested",
                "key" => $key,
                "firstValue" => generateDiff($firstValue, $secondValue),
                "secondValue" => null
            ];
        }

        return [
            "status" => "changed",
            "key" => $key,
            "firstValue" => $firstValue,
            "secondValue" => $secondValue
        ];
    }, $sortedKeys);
}
// Основная фукнция
function genDiff(string $firstFile, string $secondFile, string $format = "stylish"): string
{
    $data1 = parseFile($firstFile);
    $data2 = parseFile($secondFile);

    $diff = generateDiff($data1, $data2);
    return formatFile($format, $diff);
}
