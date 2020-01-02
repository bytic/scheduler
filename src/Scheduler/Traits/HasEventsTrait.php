<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Events\EventCollection;

/**
 * Trait HasEventsTrait
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasEventsTrait
{
    /**
     * @var EventCollection
     */
    protected $events;

    protected $eventsByDriver = [];

    /**
     * @return EventCollection
     */
    public function getEvents(): EventCollection
    {
        return $this->events;
    }

    /**
     * @param $command
     * @return EventAdder
     */
    public function run($command)
    {
        return new EventAdder($this, $command);
    }

    /**
     * @param $event
     */
    public function addEvent($event)
    {
        $this->events->add($event);
    }
}
