<?php

namespace Differ\Formatters\Stylish;

function boolToString($value)
{
    return (is_bool($value) ? ($value ? "true" : "false") : $value);
}

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
            fn($key, $val) => "{$indent}    {$key}: {$iter($val, $depth + 1)}",
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
            case "add":
                return "{$indent}  + {$key}: {$stringifyFirstValue}";
            case "delete":
                return "{$indent}  - {$key}: {$stringifyFirstValue}";
            case "unchagne":
                return "{$indent}    {$key}: {$stringifyFirstValue}";
            case "change":
                return "{$indent}  - {$key}: {$stringifyFirstValue}\n{$indent}  + {$key}: {$stringifySecondValue}";
            case "nested":
                $nestedValue = is_array($firstValue)
                ? formatStylish($firstValue, $spacesCount + 1) : stringify($firstValue);
                return "{$indent}    {$key}: {$nestedValue}";
        }
    }, $array);

    $result = ["{", ...$formatArray, "$indent}"];
    return implode("\n", $result);
}
