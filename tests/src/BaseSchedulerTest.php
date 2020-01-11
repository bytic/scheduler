<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Helper;
use Bytic\Scheduler\Loader\FileLoader\FileLoader;
use Bytic\Scheduler\Scheduler;

/**
 * Class BaseSchedulerTest
 * @package Bytic\Scheduler\Tests
 */
class BaseSchedulerTest extends AbstractTest
{
    public function test_boilerplate()
    {
        $scheduler = new Scheduler();
        Helper::setBasePath(TEST_FIXTURE_PATH);

        $events = new EventCollection();
        $scheduler->setEvents($events);
        FileLoader::loadEvents($scheduler);

        static::assertCount(1, $events);
    }
}
