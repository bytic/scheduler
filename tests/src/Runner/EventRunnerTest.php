<?php

namespace Bytic\Scheduler\Tests\Runner;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Runner\EventRunner;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery\Mock;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EventRunnerTest
 * @package Bytic\Scheduler\Tests\Runner
 */
class EventRunnerTest extends AbstractTest
{
    public function test_handle_calls_start_on_each_event()
    {
        $eventCollection = $this->createEventCollectionMocks();
        $eventCollection[1]->shouldReceive('start')->once();

        $output = $this->createMock(OutputInterface::class);
        $eventRunner = $this->createEventRunnerMock();
        $eventRunner->shouldReceive('manageStartedEvents')->once();

        $eventRunner->handle($output, $eventCollection);
    }

    public function test_handle_calls_before_callbacks_on_event()
    {
        $eventCollection = $this->createEventCollectionMocks();
        $eventCollection[1]->before(function () use (&$calls) {
            define('RUN_CALLBACK', true);
        });

        $output = $this->createMock(OutputInterface::class);
        $eventRunner = $this->createEventRunnerMock();

        $eventRunner->handle($output, $eventCollection);
        self::assertTrue(defined('RUN_CALLBACK'));
    }

    /**
     * @return EventRunner|Mock
     */
    protected function createEventRunnerMock()
    {
        /** @var Mock|EventRunner $eventRunner */
        $eventRunner = \Mockery::mock(EventRunner::class)->makePartial()->shouldAllowMockingProtectedMethods();

        return $eventRunner;
    }

    /**
     * @return EventCollection
     */
    protected function createEventCollectionMocks()
    {
        /** @var Mock|Event $event */
        $event = \Mockery::mock(Event::class)->makePartial();
        $event->setCommand("php -v");

        $eventCollection = new EventCollection();
        $eventCollection->add($event, '1');

        return $eventCollection;
    }
}
