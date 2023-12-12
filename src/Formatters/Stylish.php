<?php

namespace Differ\Formatters\Stylish;
// Вывод булевых значений
function boolToString(mixed $value): mixed
{
    return (is_bool($value) ? ($value ? "true" : "false") : $value);
}
// Структурирование вывода
function stringify(mixed $value, int $spacesCount = 1): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $spacesCount) {
        if (!is_array($currentValue)) {
            if ($currentValue === null) {
                return "null";
            }
            return trim(var_export($currentValue, true), "'");
        }

        $indentSize = $depth * $spacesCount;
        $indent = str_repeat("    ", $indentSize);

        $lines = array_map(
            fn($key, $val) => "$indent    $key: {$iter($val, $depth + 1)}",
            array_keys($currentValue),
            $currentValue
        );

        $result = ['{', ...$lines, "{$indent}}"];

        return implode("\n", $result);
    };

    return $iter($value, 1);
}

function formatStylish(mixed $array, int $spacesCount = 0): string
{
    $indent = str_repeat("    ", $spacesCount);
    $formatArray = array_map(function ($parsedArray) use ($indent, $spacesCount) {

        $status = $parsedArray["status"];
        $key = $parsedArray["key"];
        $firstValue = boolToString($parsedArray["firstValue"]);
        $secondValue = boolToString($parsedArray["secondValue"]);

        $stringifyFirstValue = stringify($firstValue, $spacesCount + 1);
        $stringifySecondValue = stringify($secondValue, $spacesCount + 1);

        switch ($status) {
            case "added":
                return "$indent  + $key: $stringifyFirstValue";
            case "deleted":
                return "$indent  - $key: $stringifyFirstValue";
            case "unchanged":
                return "$indent    $key: $stringifyFirstValue";
            case "changed":
                return "$indent  - $key: $stringifyFirstValue\n$indent  + $key: $stringifySecondValue";
            case "nested":
                $nestedValue = is_array($firstValue)
                ? formatStylish($firstValue, $spacesCount + 1) : stringify($firstValue);
                return "$indent    $key: $nestedValue";
        }
    }, $array);

    $result = ["{", ...$formatArray, "$indent}"];
    return implode("\n", $result);
}
