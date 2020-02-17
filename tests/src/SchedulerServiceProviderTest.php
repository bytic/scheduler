<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\SchedulerServiceProvider;

/**
 * Class SchedulerServiceProviderTest
 * @package Bytic\Scheduler\Tests
 */
class SchedulerServiceProviderTest extends AbstractTest
{
    public function test_registerCrontabDriver_get_identifier_from_scheduler()
    {
        $provider = new SchedulerServiceProvider();
        $provider->initContainer();

        $scheduler = new Scheduler();
        $scheduler->setIdentifier('MYCRON');

        $provider->getContainer()->set(Scheduler::class, $scheduler);

        $provider->register();

        self::assertSame(
            'MYCRON',
            $provider->getContainer()->get(CrontabDriver::class)->getCrontab()->getIdentifier()
        );
    }
}
