<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * @package ByTIC\Queue\Console
 */
class ListCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('schedule:list');
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scheduler = scheduler();
        $events = $scheduler->getEvents();

        foreach ($events as $event) {
            $output->writeln(
                "[" . $event->getIdentifier() . "]"
                . "" . $event->getExpression() . " - "
                . "[C:" . $event->getCommand() . "]"
                . "[H:" . $event->getIdentifierHumanRead() . "]"
                . "[D:" . $event->getSummaryForDisplay() . "]"
            );
        }

        return 0;
    }
}
