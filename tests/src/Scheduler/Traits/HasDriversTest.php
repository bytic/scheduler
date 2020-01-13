<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;
use Nip\Container\Container;

/**
 * Class HasDriversTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class HasDriversTest extends AbstractTest
{
    public function test_getDriver()
    {
        $scheduler = new Scheduler();
        $driver = $scheduler->getDriver('crontab');
        self::assertInstanceOf(CrontabDriver::class, $driver);
    }
}