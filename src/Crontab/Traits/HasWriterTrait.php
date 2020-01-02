<?php

namespace Bytic\Scheduler\Crontab\Traits;

use Symfony\Component\Process\Process;

trait HasWriterTrait
{
    /**
     * Writes the crontab into the system for the given user. Default: current user.
     *
     * @param string $content
     * @param string $user
     *
     * @return integer
     *
     * @throws InvalidIdentifierException
     * @throws RuntimeException
     */
    private function write($content, $user = null)
    {
        $crontab = $this->read($user);

        $header = $this->getHeaderComment();
        $footer = $this->getFooterComment();
        $content = $header . PHP_EOL . $content . $footer;
        $hasHeader = preg_match("/^$header\s*$/m", $crontab) === 1;
        $hasFooter = preg_match("/^$footer\s*$/m", $crontab) === 1;
        if ($hasHeader && !$hasFooter) {
            throw new InvalidIdentifierException(sprintf('Unclosed identifier. Your crontab contains "%s", but no "%s".',
                $header, $footer));
        } elseif (!$hasHeader && $hasFooter) {
            throw new InvalidIdentifierException(sprintf('Unopened identifier. Your crontab contains "%s", but no "%s".',
                $footer, $header));
        }
        if ($hasHeader && $hasFooter) {
            $crontab = preg_replace("/^$header\s*$.*?^$footer\s*$/sm", $content, $crontab);
        } else {
            $crontab .= PHP_EOL . $content;
        }
        $tempFile = tempnam(sys_get_temp_dir(), 'helthe_cron');
        file_put_contents($tempFile, $crontab);
        $process = new Process($this->getCommand($user) . ' ' . $tempFile);
        if ($process->run() === 1) {
            throw new RuntimeException($process->getErrorOutput());
        }
        return $process->getExitCode();
    }
}