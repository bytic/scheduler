<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasEventsTraitTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class HasEventsTraitTest extends AbstractTest
{
    public function test_run_with_params()
    {
        $scheduler = new Scheduler();
        $events = $scheduler->getEvents();
        static::assertCount(0, $events);

        $scheduler->run('/bin/apache restart')
            ->hourly();

        static::assertCount(1, $events);
    }
}