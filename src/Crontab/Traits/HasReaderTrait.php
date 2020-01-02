<?php

namespace Bytic\Scheduler\Crontab\Traits;

use Bytic\Scheduler\Crontab\Cronfile;

/**
 * Trait HasReaderTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasReaderTrait
{
    /**
     * @param $user
     * @return Cronfile
     */
    protected function getCronfile($user = null)
    {
        $crontab = $this->readRaw($user);
        return new Cronfile(
            $this->readRaw($user),
            $this->getHeaderComment(),
            $this->getFooterComment()
        );
    }

    /**
     * Reads the crontab file and returns the output. Default: current user.
     *
     * @param string $user
     *
     * @return string
     */
    protected function readRaw($user = null)
    {
        $process = $this->runCommand('-l', $user);
        return $process->getOutput();
    }
}
