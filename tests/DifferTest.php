<?php

namespace Differ\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

сlass DifferTest extends TestCase
{
    public function getFixtureFullPatch($fixtureName)
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testDiffer(): void
    {
        $fileOneJson = $this->getFixtureFullPatch('file3.json');
        $fileTwoJson = $this->getFixtureFullPatch('file4.json');
        $fileOneYaml = $this->getFixtureFullPatch('file3.yaml');
        $fileTwoYaml = $this->getFixtureFullPatch('file4.yaml');

        $expected1 = file_get_contents($this->getFixtureFullPatch('TestRecursiveCompare.txt'));
        $expected2 = file_get_contents($this->getFixtureFullPatch('TestPlainCompare.txt'));
        $expected3 = file_get_contents($this->getFixtureFullPatch('TestJsonCompare.txt'));

        $this->assertEquals($expected1, genDiff($fileOneJson, $fileTwoJson));
        $this->assertEquals($expected1, genDiff($fileOneYaml, $fileTwoYaml));
        $this->assertEquals($expected2, genDiff($fileOneJson, $fileTwoJson, "plain"));
        $this->assertEquals($expected3, genDiff($fileOneJson, $fileTwoJson, "json"));
    }
}
