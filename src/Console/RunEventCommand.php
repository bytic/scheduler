<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunEventCommand
 * @package ByTIC\Queue\Console
 */
class RunEventCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('schedule:run-event')
            ->setDescription('Executes an event by id')
            ->setDefinition(
                [
                    new InputArgument(
                        'id',
                        InputArgument::REQUIRED,
                        'The event id to run'
                    ),
                ]
            )
            ->setHelp('This command executes an event.')
            ->setHidden(true);
    }/** @noinspection PhpMissingParentCallCommonInspection */

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = [];
        /** @var string $closure */
        $eventId = $input->getArgument('id');

        $scheduler = scheduler();
        $event = $scheduler->getEvents()->get($eventId);

        return 0;
    }
}
