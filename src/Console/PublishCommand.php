<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PublishCommand
 * @package ByTIC\Queue\Console
 */
class PublishCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('schedule:register');
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scheduler = scheduler();
        $scheduler->publish();

        return 0;
    }
}
