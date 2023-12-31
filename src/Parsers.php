<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

// Выбор расширения файла
function parseFile(string $filePath)
{
    $fileContent = file_get_contents($filePath);

    if ($fileContent !== false) {
        if (pathinfo($filePath, PATHINFO_EXTENSION) === "json") {
            $decodedFile = json_decode($fileContent, true);
        } else {
            $decodedFile = Yaml::parse($fileContent);
        }
        return $decodedFile;
    }
}
