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
        $fileThreeJson = $this->getFixtureFullPatch('file3.json');
        $fileFourJson = $this->getFixtureFullPatch('file4.json');
        $fileThreeYaml = $this->getFixtureFullPatch('file3.yaml');
        $fileFourYaml = $this->getFixtureFullPatch('file4.yaml');

        $expected1 = file_get_contents($this->getFixtureFullPatch('TestFlatCompare1.txt'));
        $expected2 = file_get_contents($this->getFixtureFullPatch('TestFlatCompare2.txt'));
        $expected3 = file_get_contents($this->getFixtureFullPatch('TestRecursiveCompare.txt'));

        $this->assertEquals($expected1, genDiff($fileOneJson, $fileTwoJson));
        $this->assertEquals($expected2, genDiff($fileTwoJson, $fileOneJson));
        $this->assertEquals($expected1, genDiff($fileOneYml, $fileTwoYml));
        $this->assertEquals($expected2, genDiff($fileTwoYml, $fileOneYml));
        $this->assertEquals($expected1, genDiff($fileOneYaml, $fileTwoYaml));
        $this->assertEquals($expected2, genDiff($fileTwoYaml, $fileOneYaml));
        $this->assertEquals($expected3, genDiff($fileThreeJson, $fileFourJson));
        $this->assertEquals($expected3, genDiff($fileThreeYaml, $fileFourYaml));
    }
}
