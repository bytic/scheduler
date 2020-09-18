<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Events\CommandBuilder;

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

    /**
     * @return string
     */
    public function buildCommand()
    {
        return (new CommandBuilder())->buildCommand($this);
    }
}
