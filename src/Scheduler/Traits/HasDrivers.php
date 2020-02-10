<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Drivers\DriverManager;
use Bytic\Scheduler\Events\Event;

/**
 * Trait HasDrivers
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasDrivers
{
    protected $manager;

    /**
     * @var array
     */
    protected $eventsByDriver = [];

    /**
     * @return array
     */
    public function getEventsByDriver(): array
    {
        return $this->eventsByDriver;
    }

    protected function publishDrivers()
    {
        foreach ($this->eventsByDriver as $driver => $identifiers) {
            $eventCollection = $this->getEvents()->only($identifiers);
            DriverManager::publish($eventCollection, $driver);
        }
    }

    /**
     * @param Event $event
     */
    protected function onEventAddedDrivers($event)
    {
        $this->eventsByDriver[$event->getDriver()][] = $event->getIdentifier();
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
