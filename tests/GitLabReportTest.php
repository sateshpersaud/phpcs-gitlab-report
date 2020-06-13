<?php declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Satesh\Phpcs\GitLabReport;

class GitLabReportTest extends TestCase
{
    public function testGenerateFileReport(): string
    {
        $fileReport = $this->getFileReport();

        $this->expectOutputString($fileReport);

        $gitLabReport = new GitLabReport();

        $returnValue = $gitLabReport->generateFileReport($this->getPhpcsReport());

        static::assertTrue($returnValue);

        return $fileReport;
    }

    /**
     * @depends testGenerateFileReport
     */
    public function testGenerate(string $fileReport): void
    {
        $fullReport = $this->getFullReport();

        $this->expectOutputString($fullReport);

        $gitLabReport = new GitLabReport();

        $gitLabReport->generate($fileReport, 0, 0, 0, 0);
    }

    private function getFileReport(): string
    {
        return '{"description":"Expected 1 space between class keyword and class name; 2 found","fingerprint":"b8bb8bb00c5549ff34161bd8a9fbc799","location":{"path":"files\/ExampleClass.php","lines":{"begin":1}}},';
    }

    private function getFullReport(): string
    {
        return '[{"description":"Expected 1 space between class keyword and class name; 2 found","fingerprint":"b8bb8bb00c5549ff34161bd8a9fbc799","location":{"path":"files\/ExampleClass.php","lines":{"begin":1}}}]';
    }

    private function getPhpcsReport(): array
    {
        return [
            'filename' => 'files/ExampleClass.php',
            'errors' => 1,
            'warnings' => 0,
            'fixable' => 1,
            'messages' => [
                1 => [
                    2 => [
                        [
                            'message' => 'Expected 1 space between class keyword and class name; 2 found',
                            'source' => 'PSR2.Classes.ClassDeclaration.SpaceAfterKeyword',
                            'severity' => 5,
                            'fixable' => false,
                            'type' => 'ERROR',
                        ],
                    ],
                ],
            ],
        ];
    }
}
