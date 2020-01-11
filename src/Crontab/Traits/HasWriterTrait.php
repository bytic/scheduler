<?php

namespace Bytic\Scheduler\Crontab\Traits;

use Bytic\Scheduler\Crontab\Cronfile;
use Bytic\Scheduler\Exception\InvalidIdentifierException;
use Bytic\Scheduler\Exception\RuntimeException;

/**
 * Trait HasWriterTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
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
    public function write($content, $user = null)
    {
        $crontab = $this->generateCrontabContent($content, $user);
        
        $tempFile = tempnam(sys_get_temp_dir(), 'bytic_cron');
        file_put_contents($tempFile, $crontab);

        $process = $this->runCommand($tempFile);
        $exitCode = $process->getExitCode();
        if ($exitCode === 1) {
            throw new RuntimeException($process->getErrorOutput());
        }
        return $exitCode;
    }

    /**
     * @param $content
     * @param null $user
     * @return mixed
     */
    protected function generateCrontabContent($content, $user = null)
    {
        $cronfile = $this->getCronfile($user);
        $cronfile->updateContent($content);
        return $cronfile->getContent();
    }
}
