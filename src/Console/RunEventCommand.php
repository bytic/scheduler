<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
//            ->setDefinition(
//                [
//                    new InputArgument(
//                        'event',
//                        InputArgument::REQUIRED,
//                        'The event id to run'
//                    ),
//                ]
//            )
            ->addOption(
                'event',
                'e',
                InputOption::VALUE_REQUIRED,
                'Which task to run. Provide task number from <info>schedule:list</info> command.',
                null
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
        $eventId = $input->getOption('event');

        $scheduler = scheduler();
        $event = $scheduler->getEvents()->get($eventId);

        return 0;
    }
}
