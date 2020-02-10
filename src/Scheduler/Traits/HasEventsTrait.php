<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Loader\EventsLoader;

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
    protected $eventsLoaded = false;

    protected $eventsByPinger = [];

    /**
     * @return EventCollection
     */
    public function getEvents(): EventCollection
    {
        $this->checkInitEvents();
        return $this->events;
    }

    /**
     * @param Event $event
     */
    public function addEvent($event)
    {
        $this->events->add($event, $event->getIdentifier());
        $this->triggerCallbacks('onEventAdded', [$event]);
    }

    protected function checkInitEvents()
    {
        if ($this->eventsLoaded === true) {
            return;
        }
        if (count($this->events) > 0) {
            $this->eventsLoaded = true;
            return;
        }

        $this->initEvents();
        $this->eventsLoaded = true;
        return;
    }

    protected function initEvents()
    {
        EventsLoader::loadEvents($this);
    }

    /**
     * @param EventCollection $events
     */
    public function setEvents(EventCollection $events)
    {
        $this->events = $events;
        $this->eventsLoaded = true;
        $this->eventsByDriver = [];
        foreach ($events as $event) {
            $this->eventsByDriver[$event->getDriver()][] = $event->getIdentifier();
        }
    }
}
