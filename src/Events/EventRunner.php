<?php

namespace Bytic\Scheduler\Events;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EventRunner
 * @package Bytic\Scheduler\Events
 */
class EventRunner
{
    /**
     * @param OutputInterface $output
     * @param Event $event
     */
    public function handle(OutputInterface $output, Event $event)
    {
        $output->writeln('<info>Running scheduled command:</info> ' . $event->getSummaryForDisplay());

        $event->start();
    }
}
