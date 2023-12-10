<?php

namespace Differ\Formatters\Plain;

function boolToString($value)
{
    return (is_bool($value) ? ($value ? "true" : "false") : $value);
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
                case "add":
                    return "Property '$patchKey' was added with value: $secondValue";
                case "delete":
                    return "Property '$patchKey' was removed";
                case "unchagne":
                    break;
                case "change":
                    return "Property '$patchKey' was updated. From '$firstValue' to '$secondValue'";
                case "nested":
                    return $result($firstValue, $patchKey);
            }
        }, $node);
    
        $filterArray = array_filter($formatArray);
        return implode("\n", $filterArray);
    };

    return $result($array);
}
