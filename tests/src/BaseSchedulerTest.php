<?php

namespace Bytic\Scheduler\Tests;

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
        require_once TEST_FIXTURE_PATH . '/scheduler.php';

        $events = $scheduler->getEvents();
        static::assertCount(1, $events);
    }
}
