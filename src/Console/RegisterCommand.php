<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Bytic\Scheduler\Scheduler\FileDetector;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsumeCommand
 * @package ByTIC\Queue\Console
 */
class RegisterCommand extends Command
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
        $file = (new FileDetector($scheduler))->getPath();

        require_once $file;


        $consumer = $this->getQueueConsumer($connection);
        $this->setQueueConsumerOptions($consumer, $input);

        $queues = $this->determineQueues($input);
        $processor = $this->getProcessor();

        foreach ($queues as $queue) {
            $queue = $connection->getContext()->createQueue($queue);
            $consumer->bind($queue, $processor);
        }

        $extensions = $this->getLimitsExtensions($input, $output);

        $exitStatusExtension = new ExitStatusExtension();
        array_unshift($extensions, $exitStatusExtension);

        $consumer->consume(new ChainExtension($extensions));
        return $exitStatusExtension->getExitStatus();
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    protected function determineQueues(InputInterface $input)
    {
        $queue = $input->getArgument('queue-names');
        return is_array($queue) ? $queue : [$queue];
    }
}
