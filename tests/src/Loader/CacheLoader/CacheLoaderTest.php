<?php

namespace Bytic\Scheduler\Tests\Loader\CacheLoader;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Loader\CacheLoader\CacheLoader;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CacheLoaderTest
 * @package Bytic\Scheduler\Tests\Loader\CacheLoader
 */
class CacheLoaderTest extends AbstractTest
{
    public function test_loadEvents()
    {
        $scheduler = new Scheduler();
        $events = new EventCollection();
        $scheduler->setEvents($events);

        static::assertCount(0, $events);

        $result = CacheLoader::loadEvents($scheduler);
        self::assertTrue($result);

        static::assertCount(2, $scheduler->getEvents());
    }

    public function test_saveEvents()
    {
        @unlink(CACHE_PATH . '/scheduler.php');

        $scheduler = new Scheduler();
        $events = new EventCollection();

        $event1 = new Event('php foe1');
        $events->add($event1);

        $event2 = new Event('php foe2');
        $events->add($event2);

        $scheduler->setEvents($events);
        static::assertCount(2, $events);

        CacheLoader::saveEvents($scheduler);

        self::assertFileExists(CACHE_PATH . '/scheduler.php');
    }
}
