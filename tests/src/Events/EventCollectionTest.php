<?php

namespace Bytic\Scheduler\Tests\Events;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class EventCollectionTest
 * @package Bytic\Scheduler\Tests\Events
 */
class EventCollectionTest extends AbstractTest
{
    public function test_serialize()
    {
        $events = new EventCollection();

        $event1 = new Event('php foe1');
        $events->add($event1);

        $event2 = new Event('php foe2');
        $event2->after(function () {
            return 2;
        });
        $events->add($event2);

        $serialized = serialize($events);
        $eventsReturned = unserialize($serialized);
        self::assertEquals($events->all(), $eventsReturned->all());
    }
}