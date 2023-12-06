<?php

namespace Differ\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

Class DifferTest extends TestCase
{
    public function getFixtureFullPatch($fixtureName)
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testDiffer(): void
    {
        $fileOneJson = $this->getFixtureFullPatch('file1.json');
        $fileTwoJson = $this->getFixtureFullPatch('file2.json');
        $fileOneYml = $this->getFixtureFullPatch('file1.yml');
        $fileTwoYml = $this->getFixtureFullPatch('file2.yml');
        $fileOneYaml = $this->getFixtureFullPatch('file1.yaml');
        $fileTwoYaml = $this->getFixtureFullPatch('file2.yaml');

        $expected1 = "{" . PHP_EOL
            . "    - follow: false" . PHP_EOL
            . "      host: hexlet.io" . PHP_EOL
            . "    - proxy: 123.234.53.22" . PHP_EOL
            . "    - timeout: 50" . PHP_EOL
            . "    + timeout: 20" . PHP_EOL
            . "    + verbose: true" . PHP_EOL
            . "}" . PHP_EOL;

        $expected2 = "{" . PHP_EOL
            . "    + follow: false" . PHP_EOL
            . "      host: hexlet.io" . PHP_EOL
            . "    + proxy: 123.234.53.22" . PHP_EOL
            . "    - timeout: 20" . PHP_EOL
            . "    + timeout: 50" . PHP_EOL
            . "    - verbose: true" . PHP_EOL
            . "}" . PHP_EOL; 

        $this->assertEquals($expected1, genDiff($fileOneJson, $fileTwoJson));
        $this->assertEquals($expected2, genDiff($fileTwoJson, $fileOneJson));
        $this->assertEquals($expected1, genDiff($fileOneYml, $fileTwoYml));
        $this->assertEquals($expected2, genDiff($fileTwoYml, $fileOneYml));
        $this->assertEquals($expected1, genDiff($fileOneYaml, $fileTwoYaml));
        $this->assertEquals($expected2, genDiff($fileTwoYaml, $fileOneYaml));
    }
}
