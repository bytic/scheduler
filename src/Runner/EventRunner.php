<?php

namespace Bytic\Scheduler\Runner;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EventRunner
 * @package Bytic\Scheduler\Runner
 */
class EventRunner
{
    /**
     * @var EventCollection
     */
    protected $events;

    /**
     * @param OutputInterface $output
     * @param EventCollection $collection
     */
    public function handle(OutputInterface $output, EventCollection $collection)
    {
        $this->events = clone $collection;

        $output->writeln('<info>START running [' . count($collection) . '] events</info>');

        foreach ($collection as $event) {
            $output->writeln('<info>Running scheduled command:</info> ' . $event->getSummaryForDisplay());
            $this->start($event);
        }

        // Watch events until they are finished
        $this->manageStartedEvents();
    }

    /**
     * Run an event process.
     *
     * @param Event $event
     */
    protected function start(Event $event): void
    {
        $event->outputStream = $this->invoke($event->beforeCallbacks(), [$event]);
        $event->start();
    }

    protected function manageStartedEvents()
    {
        while ($this->events->count() > 0) {
            foreach ($this->events as $eventKey => $event) {

                /** @var Event $event */
                $proc = $event->getProcess();

                if ($proc->isRunning()) {
                    continue;
                }

                $event->outputStream .= $event->wholeOutput();
                $event->outputStream .= $this->invoke($event->afterCallbacks(), [$event]);

                $this->events->unset($eventKey);
            }

            \usleep(250000);
        }
    }

    /**
     * Invoke an array of callables.
     *
     * @param \Closure[] $callbacks
     * @param array<mixed,mixed> $parameters
     *
     * @return string
     */
    protected function invoke(array $callbacks = [], array $parameters = [])
    {
        $output = '';
        foreach ($callbacks as $callback) {
            // Invoke the callback with buffering enabled
            $output .= Invoker::call($callback, $parameters, true);
        }
        return $output;
    }


    /**
     * @param Event $event
     * @return string
     */
    protected function formatEventOutput(Event $event)
    {
        return $event->getSummaryForDisplay()
            . '('
            . $event->getCommand()
            . ') '
            . PHP_EOL
            . PHP_EOL
            . $event->outputStream
            . PHP_EOL;
    }
}
