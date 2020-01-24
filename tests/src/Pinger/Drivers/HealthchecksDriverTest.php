<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers;

use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HealthchecksDriverTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers
 */
class HealthchecksDriverTest extends AbstractTest
{
    public function test_getChecks()
    {
        $driver = new HealthchecksDriver(['apiKey' => 'Uwrk3eAkL3lcPo2D1Ou0yZaYdCWybGXE']);

        $checks = $driver->getChecks();
        self::assertIsArray($checks);
    }
}
