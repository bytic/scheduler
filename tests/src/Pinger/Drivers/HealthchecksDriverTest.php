<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery\Mock;
use Nip\Config\Config;

/**
 * Class HealthchecksDriverTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers
 */
class HealthchecksDriverTest extends AbstractTest
{
    public function test_construct_with_config()
    {
        $config = new Config(['apiKey' => 999]);

        $driver = new HealthchecksDriver($config);
        self::assertEquals(999, $driver->getClient()->getApiKey());
    }

    public function test_construct_with_array()
    {
        $config = ['apiKey' => 999];

        $driver = new HealthchecksDriver($config);
        self::assertEquals(999, $driver->getClient()->getApiKey());
    }

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
