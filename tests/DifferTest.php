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
        $file1 = $this->getFixtureFullPatch('file1.json');
        $file2 = $this->getFixtureFullPatch('file2.json');
        $file3 = $this->getFixtureFullPatch('file3.json');

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
            
        $expected3 = "{" . PHP_EOL
            . "    - follow: false" . PHP_EOL
            . "    - host: hexlet.io" . PHP_EOL
            . "    - proxy: 123.234.53.22" . PHP_EOL
            . "    - timeout: 50" . PHP_EOL
            . "}" . PHP_EOL;

        $expected4 = "{" . PHP_EOL
            . "    + follow: false" . PHP_EOL
            . "    + host: hexlet.io" . PHP_EOL
            . "    + proxy: 123.234.53.22" . PHP_EOL
            . "    + timeout: 50" . PHP_EOL
            . "}" . PHP_EOL; 

        $this->assertEquals($expected1, genDiff($file1, $file2));
        $this->assertEquals($expected2, genDiff($file2, $file1));
        $this->assertEquals($expected3, genDiff($file1, $file3));
        $this->assertEquals($expected4, genDiff($file3, $file1));
    }
}
