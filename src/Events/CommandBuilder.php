<?php

namespace Bytic\Scheduler\Events;

use Bytic\Scheduler\Helper;

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
        $command = $this->generateCWD($event);
        $command .= $this->sudo($event);
        $command .= $this->generateEventCommand($event);

        return \trim($command, '& ');
    }

    /**
     * @param Event $event
     * @return string
     */
    protected function generateCWD(Event $event)
    {
        $command = '';
        $cwd = $event->getWorkingDirectory();
        if ($cwd) {
            $command .= $this->sudo($event);

            // Support changing drives in Windows
            $cdParameter = Helper::isWindows() ? '/d ' : '';
            $andSign = Helper::isWindows() ? ' &' : ';';

            $command .= "cd {$cdParameter}{$cwd}{$andSign} ";
        }
        return $command;
    }

    /**
     * @param Event $event
     * @return mixed
     */
    protected function generateEventCommand(Event $event)
    {
        return $event->getCommand();
    }

    /**
     * @param Event $event
     * @return string
     */
    protected function sudo(Event $event)
    {
        $user = $event->getUser();
        if ($user) {
            return "sudo -u {$user} ";
        }
        return '';
    }
}
