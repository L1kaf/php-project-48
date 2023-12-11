<?php

namespace Differ\Formatters\Plain;

function normaliseValue($value)
{
    if ($value === null) {
        return "null";
    } elseif (is_array($value)) {
        return "[complex value]";
    } elseif (is_string($value)) {
        return "'$value'";
    }
    return trim(var_export($value, true), "'");
}

function formatPlain(mixed $array): string
{
    $result = function (array $node, string $previousKeys = '') use (&$result) {
        $formatArray = array_map(function ($value) use ($result, $previousKeys) {

            $status = $value["status"];
            $key = $value["key"];
            $firstValue = $value["firstValue"];
            $secondValue = $value["secondValue"];

            $patchKey = $previousKeys === "" ? "$key" : "$previousKeys.$key";

            switch ($status) {
                case "added":
                    $normalisedValue = normaliseValue($firstValue);
                    return "Property '$patchKey' was added with value: $normalisedValue";
                case "deleted":
                    return "Property '$patchKey' was removed";
                case "unchanged":
                    break;
                case "changed":
                    $normalisedValue1 = normaliseValue($firstValue);
                    $normalisedValue2 = normaliseValue($secondValue);
                    return "Property '$patchKey' was updated. From $normalisedValue1 to $normalisedValue2";
                case "nested":
                    return $result($firstValue, $patchKey);
            }
        }, $node);

        $filterArray = array_filter($formatArray);
        return implode("\n", $filterArray);
    };

    return $result($array);
}
