<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Scheduler\Helper;
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

        $events = $scheduler->getEvents();
        static::assertCount(1, $events);
    }
}
