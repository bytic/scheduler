<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Loader\EventsLoader;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Scheduler\FileDetector;

/**
 * Trait HasEventsTrait
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasEventsTrait
{
    /**
     * @var EventCollection
     */
    protected $events = null;

    protected $eventsByDriver = [];

    /**
     * @return EventCollection
     */
    public function getEvents(): EventCollection
    {
        $this->checkInitEvents();
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
        $this->events->add($event, $event->getIdentifier());

        $this->eventsByDriver[$event->getDriver()][] = $event->getIdentifier();
    }

    protected function checkInitEvents()
    {
        if ($this->events === null) {
            $this->initEvents();
        }
    }

    protected function initEvents()
    {
        $this->events = new EventCollection();
        EventsLoader::loadEvents($this);
    }

    /**
     * @param EventCollection $events
     */
    public function setEvents(EventCollection $events)
    {
        $this->events = $events;
        $this->eventsByDriver = [];
        foreach ($events as $event) {
            $this->eventsByDriver[$event->getDriver()][] = $event->getIdentifier();
        }
    }
}
