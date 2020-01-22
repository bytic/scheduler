<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class EventAdderTraitTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class EventAdderTraitTest extends AbstractTest
{
    public function test_php()
    {
        $scheduler = new Scheduler();
        $events = new EventCollection();
        $scheduler->setEvents($events);
        static::assertCount(0, $events);

        $scheduler->php(TEST_FIXTURE_PATH . '/crons/test_script.php');
        static::assertCount(1, $events);

        $event = $events->current();
        self::assertStringContainsString('bin', $event->getCommand());
        self::assertStringContainsString('test_script.php', $event->getCommand());
    }

    public function test_run_with_params()
    {
        $scheduler = new Scheduler();
        $events = new EventCollection();
        $scheduler->setEvents($events);
        static::assertCount(0, $events);

        $scheduler->run('/bin/apache restart')
            ->hourly();

        static::assertCount(1, $events);
    }
}
