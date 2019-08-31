<?php declare(strict_types = 1);

namespace Satesh\Phpcs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Report;

class GitLabReport implements Report
{
    /**
     * Generate a partial report for a single processed file.
     *
     * Function should return TRUE if it printed or stored data about the file
     * and FALSE if it ignored the file. Returning TRUE indicates that the file and
     * its data should be counted in the grand totals.
     *
     * @param array $report Prepared report data.
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being reported on.
     * @param bool $showSources Show sources?
     * @param int $width Maximum allowed line width.
     * @return bool
     */
    public function generateFileReport($report, File $phpcsFile, $showSources = false, $width = 80): bool
    {
        foreach ($report['messages'] as $line => $lineErrors) {
            foreach ($lineErrors as $column => $columnErrors) {
                foreach ($columnErrors as $error) {
                    $gitLabError = [];

                    $gitLabError['description'] = rtrim($error['message'], '.');

                    $gitLabError['fingerprint'] = md5("{$error['source']}-{$report['filename']}-{$line}-{$column}");

                    $gitLabError['location'] = [
                        'path' => $report['filename'],
                        'lines' => [
                            'begin' => $line,
                        ],
                    ];

                    echo json_encode($gitLabError) . ',';
                }
            }
        }

        return true;
    }

    /**
     * Generate the actual report.
     *
     * @param string $cachedData Any partial report data that was returned from generateFileReport during the run.
     * @param int $totalFiles Total number of files processed during the run.
     * @param int $totalErrors Total number of errors found during the run.
     * @param int $totalWarnings Total number of warnings found during the run.
     * @param int $totalFixable Total number of problems that can be fixed.
     * @param bool $showSources Show sources?
     * @param int $width Maximum allowed line width.
     * @param bool $interactive Are we running in interactive mode?
     * @param bool $toScreen Is the report being printed to screen?
     * @return void
     */
    public function generate(
        $cachedData,
        $totalFiles,
        $totalErrors,
        $totalWarnings,
        $totalFixable,
        $showSources = false,
        $width = 80,
        $interactive = false,
        $toScreen = true
    ): void {
        echo '[' . rtrim($cachedData, ',') . ']';
    }
}
