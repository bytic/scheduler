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
        foreach ($this->eventsByDriver as $driver => $identifiers) {
            $eventCollection = $this->getEvents()->only($identifiers);
            DriverManager::publish($eventCollection, $driver);
        }
    }
}
