<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\Event;
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
     * @param Event $event
     */
    public function addEvent($event)
    {
        $this->events->add($event);
    }
}
