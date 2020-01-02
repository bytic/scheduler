<?php

namespace Bytic\Scheduler\Crontab\Traits;

use Symfony\Component\Process\Process;

/**
 * Trait HasExecutableTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasExecutableTrait
{
    /**
     * @var string
     */
    protected $executable = null;

    /**
     * @param string $arguments
     * @param null $user
     * @return Process
     */
    protected function runCommand($arguments = '', $user = null)
    {
        $command = $this->getCommand($user);
        if (!empty($arguments)) {
            $command .= ' ' . $arguments;
        }
        $process = Process::fromShellCommandline($command);
        $process->run();
        return $process;
    }

    /**
     * Get the base crontab command. Default: current user.
     *
     * @param string $user
     *
     * @return string
     */
    public function getCommand($user = null)
    {
        $command = $this->getExecutable();
        $user = $this->user($user);

        if ($user) {
            $command .= ' -u ' . $user;
        }

        return $command;
    }

    /**
     * @return string
     */
    public function getExecutable()
    {
        if ($this->executable === null) {
            $this->initExecutable();
        }

        return $this->executable;
    }

    /**
     * @param string $executable
     */
    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }


    protected function initExecutable()
    {
        $this->executable = '/usr/bin/crontab';
    }

}