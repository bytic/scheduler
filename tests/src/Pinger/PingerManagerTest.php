<?php

namespace Bytic\Scheduler\Tests\Pinger;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Pinger\Drivers\UrlDriver;
use Bytic\Scheduler\Pinger\PingerManager;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery\Mock;
use Nip\Container\Container;

/**
 * Class PingerManagerTest
 * @package Bytic\Scheduler\Tests\Pinger
 */
class PingerManagerTest extends AbstractTest
{
    public function test_ping_with_url()
    {
        $event = new Event('php foe');
        $url = 'http://localhost';

        $urlPinger = \Mockery::mock(UrlDriver::class)->makePartial();
        $urlPinger->shouldReceive('ping')->withArgs([$event, ['url' => $url]])->once();

        Container::getInstance()->set(UrlDriver::class, $urlPinger);

        PingerManager::ping($url, $event);
    }

    public function test_ping_with_healthchecks()
    {
        $event = new Event('php foe');

        $urlPinger = \Mockery::mock(HealthchecksDriver::class)->makePartial();
        $urlPinger->shouldReceive('ping')->withArgs([$event, []])->once();

        Container::getInstance()->set(HealthchecksDriver::class, $urlPinger);

        PingerManager::ping('healthchecks', $event);
    }

    public function test_instanceDriver_with_config()
    {
        /** @var PingerManager|Mock $manager */
        $manager = \Mockery::mock(PingerManager::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $manager->shouldReceive('driverConfig')->with('healthchecks')->once()->andReturn(['apiKey' => '1111']);
        $manager::reset();

        $healthchecks = $manager::get('healthchecks');
        self::assertInstanceOf(HealthchecksDriver::class, $healthchecks);
        self::assertSame('1111', $healthchecks->getClient()->getApiKey());
    }
}
