<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Pinger\PingerManager;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery;

/**
 * Class HasDriversTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class HasPingersTest extends AbstractTest
{
    public function test_onEventAddedDrivers()
    {
        $scheduler = new Scheduler();
        $script = TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'test_script.php';
        $scheduler->php($script);

        $eventsByPinger = $scheduler->getEventsByPinger();
        self::assertIsArray($eventsByPinger);
        self::assertCount(0, $eventsByPinger);

        $scheduler->php($script)->pingAfter('healthchecks');
        $eventsByPinger = $scheduler->getEventsByPinger();
        self::assertCount(1, $eventsByPinger);

        $scheduler->php($script)->pingAfter('healthchecks')->pingBefore('healthchecks');
        $eventsByPinger = $scheduler->getEventsByPinger();
        self::assertArrayHasKey('healthchecks', $eventsByPinger);
        self::assertCount(2, $eventsByPinger['healthchecks']);
    }

    public function test_publishPingers()
    {
        $driver = Mockery::mock(HealthchecksDriver::class)->makePartial();
        $driver->shouldReceive('publish')->once();


        $scheduler = new Scheduler();
        $scheduler->php(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'test_script.php')->pingAfter('healthchecks');

        PingerManager::add($driver, 'healthchecks');

        $scheduler->publish();
    }
}
