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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $scheduler = scheduler();
        $events = $scheduler->getEvents();

        foreach ($events as $event) {
            $driver = $scheduler->getDriver($event->getDriver());
            $isInstalled = $driver->isInstalled($event->getIdentifier());
            $isPaused = $isInstalled && $driver->isPaused($event->getIdentifier());
            $status = $this->resolveStatus($isInstalled, $isPaused);
            $output->writeln(
                "[" . $event->getIdentifier() . "]"
                . "" . $event->getExpression() . " - "
                . "[C:" . $event->getCommand() . "]"
                . "[H:" . $event->getIdentifierHumanRead() . "]"
                . "[D:" . $event->getSummaryForDisplay() . "]"
                . "[S:" . $status . "]"
            );
        }

        return 0;
    }

    /**
     * @param bool $isInstalled
     * @param bool $isPaused
     * @return string
     */
    protected function resolveStatus(bool $isInstalled, bool $isPaused): string
    {
        if ($isInstalled === false) {
            return 'not installed';
        }

        return $isPaused ? 'paused' : 'active';
    }
}
