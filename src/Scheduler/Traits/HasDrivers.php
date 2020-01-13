<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Drivers\DriverManager;

/**
 * Trait HasDrivers
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasDrivers
{
    protected $manager;

    public function publish()
    {
        $this->checkInitEvents();
        foreach ($this->eventsByDriver as $driver => $identifiers) {
            $eventCollection = $this->getEvents()->only($identifiers);
            DriverManager::publish($eventCollection, $driver);
        }
    }

    /**
     * @param $driver
     * @return \Bytic\Scheduler\Drivers\CrontabDriver
     */
    public function getDriver(string $driver)
    {
        return DriverManager::get($driver);
    }
}
