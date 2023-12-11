<?php

namespace Differ\Formatters\Json;

function formatJson(mixed $array): string
{
    return json_encode($array, JSON_PRETTY_PRINT);
}
