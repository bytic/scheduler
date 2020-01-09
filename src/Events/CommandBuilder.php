<?php

namespace Bytic\Scheduler\Events;

/**
 * Class CommandBuilder
 * @package Bytic\Scheduler\Events
 */
class CommandBuilder
{
    /**
     * Build the command for the given event.
     *
     * @param Event $event
     * @return string
     */
    public function buildCommand(Event $event)
    {
        return $event->getCommand();
    }
}
