<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery\Mock;

/**
 * Class HealthchecksDriverTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers
 */
class HealthchecksDriverTest extends AbstractTest
{
    /**
     * @dataProvider data_ping_append_url
     */
    public function test_ping_append_url($urlEnd, $options)
    {
        /** @var HealthchecksDriver|Mock $driver */
        $driver = \Mockery::mock(HealthchecksDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $driver->shouldReceive('determineUrlForEvent')->once()->andReturn('https://hc-ping.com/{uuid}');
        $driver->shouldReceive('pingUrl')->once()->with('https://hc-ping.com/{uuid}' . $urlEnd);

        $event = new Event('php');
        $driver->ping($event, $options);
    }

    /**
     * @return array
     */
    public function data_ping_append_url(): array
    {
        return [
            ['', []],
            ['', ['trigger' => 'after']],
            ['/start', ['trigger' => 'before']],
            ['/fail', ['trigger' => 'failure']],
        ];
    }
}
