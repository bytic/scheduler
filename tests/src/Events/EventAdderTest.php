<?php

namespace Bytic\Scheduler\Tests\Events;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class EventAdderTest
 * @package Bytic\Scheduler\Tests\Events
 */
class EventAdderTest extends AbstractTest
{

    public function test_after()
    {
        $scheduler = new Scheduler();

        (new EventAdder($scheduler, 'php -v'))->after(function ($event) {
            $event->afterTest = true;
            self::assertInstanceOf(Event::class, $event);
        });

        $events = $scheduler->getEvents();
        self::assertCount(1, $events);

        $firstEvent = $events->current();
        self::assertInstanceOf(Event::class, $firstEvent);
        self::assertTrue($firstEvent->afterTest);
    }
}