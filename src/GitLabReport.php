<?php declare(strict_types = 1);

namespace Satesh\Phpcs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Report;

class GitLabReport implements Report
{
    /**
     * {@inheritDoc}
     */
    public function generateFileReport($report, File $phpcsFile = null, $showSources = false, $width = 80): bool
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
     * {@inheritDoc}
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
