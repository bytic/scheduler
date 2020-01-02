<?php

namespace Bytic\Scheduler\Events\Traits;

/**
 * Trait HasCommand
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasCommand
{
    protected $command;

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }
}