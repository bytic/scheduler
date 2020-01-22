<?php

namespace Bytic\Scheduler\Tests\Drivers;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Drivers\DriverManager;
use Bytic\Scheduler\Tests\AbstractTest;
use Nip\Container\Container;

/**
 * Class DriverManagerTest
 * @package Bytic\Scheduler\Tests\Drivers
 */
class DriverManagerTest extends AbstractTest
{
    public function test_get_from_container()
    {
        $container = Container::getInstance();

        $driver = new CrontabDriver();
        $driver->getCrontab()->setIdentifier('MYCRON');
        $container->set(CrontabDriver::class, $driver);

        $crontab = DriverManager::get('crontab');
        self::assertInstanceOf(CrontabDriver::class, $crontab);
        self::assertSame('MYCRON', $crontab->getCrontab()->getIdentifier());

        $container->set(CrontabDriver::class, null);
    }
}
