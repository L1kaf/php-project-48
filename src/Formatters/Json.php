<?php

namespace Differ\Formatters\Json;

// Вывод в json формате
function formatJson(mixed $array): string
{
    return json_encode($array, JSON_PRETTY_PRINT);
}
