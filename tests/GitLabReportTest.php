<?php declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Satesh\Phpcs\GitLabReport;

class GitLabReportTest extends TestCase
{
    public function testGenerateFileReport(): string
    {
        $reportOutput = $this->getGitLabReport();

        $this->expectOutputString($reportOutput);

        $gitLabReport = new GitLabReport();

        $returnValue = $gitLabReport->generateFileReport($this->getPhpcsReport());

        static::assertTrue($returnValue);

        return $reportOutput;
    }

    /**
     * @depends testGenerateFileReport
     */
    public function testGenerate(string $fileReport): void
    {
        $this->expectOutputString('[' . rtrim($fileReport, ',') . ']');

        $gitLabReport = new GitLabReport();

        $gitLabReport->generate($fileReport, 1, 1, 1, 1);
    }

    private function getGitLabReport(): string
    {
        return '{"description":"PHP files must only contain PHP code","fingerprint":"3719b59c961e426a579b2ff715c24b04","location":{"path":"files\/TestClass.php","lines":{"begin":3}}},';
    }

    private function getPhpcsReport(): array
    {
        return [
            'filename' => 'files/TestClass.php',
            'errors' => 1,
            'warnings' => 0,
            'fixable' => 0,
            'messages' => [
                3 => [
                    1 => [
                        [
                            'message' => 'PHP files must only contain PHP code.',
                            'source' => 'Generic.Files.InlineHTML.Found',
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
