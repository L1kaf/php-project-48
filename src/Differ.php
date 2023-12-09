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

    return array_map(function ($key) use ($firstData, $secondData) {
        $firstValue = $firstData[$key] ?? null;
        $secondValue = $secondData[$key] ?? null;

        if (!array_key_exists($key, $firstData)) {
            return [
                "status" => "add",
                "key" => $key,
                'firstValue' => $secondValue,
                "secondValue" => null
            ];
        }

        if (!array_key_exists($key, $secondData)) {
            return [
                "status" => "delete",
                "key" => $key,
                "firstValue" => $firstValue,
                "secondValue" => null
            ];
        }

        if ($firstData[$key] === $secondValue) {
            return [
                "status" => "unchagne",
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
            "status" => "change",
            "key" => $key,
            "firstValue" => $firstValue,
            "secondValue" => $secondValue
        ];
    }, $sortedKeys);
}

function genDiff(string $firstFile, string $secondFile, string $format = "stylish"): string
{
    $data1 = parseFile($firstFile);
    $data2 = parseFile($secondFile);

    $diff = generateDiff($data1, $data2);
    return formatFile($format, $diff);
}
