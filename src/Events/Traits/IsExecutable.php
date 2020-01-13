<?php

namespace Bytic\Scheduler\Events\Traits;

use Symfony\Component\Process\Process;

/**
 * Trait IsExecutable
 * @package Bytic\Scheduler\Events\Traits
 */
trait IsExecutable
{
    /**
     * Process that runs the event.
     *
     * @var Process
     */
    protected $process;

    public function start()
    {
        $command = $this->buildCommand();
        $process = Process::fromShellCommandline($command, null, null, null);
        $this->setProcess($process);

        $process->start(
            function ($type, $content): void {
                $this->wholeOutput[] = $content;
            });
    }

    /**
     * Set the event's process.
     * @param Process $process
     */
    private function setProcess(Process $process): void
    {
        $this->process = $process;
    }

    /**
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }
}
