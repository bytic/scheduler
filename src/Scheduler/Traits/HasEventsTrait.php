<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Events\EventCollection;
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
        if ($this->events === null) {
            $this->initEvents();
        }
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

    protected function initEvents()
    {
        $this->events = new EventCollection();
        if ($this->loadEventsFromCache()) {
            return;
        }
        $this->loadEventsFromFile();
    }

    /**
     * @return bool
     */
    protected function loadEventsFromCache()
    {
        return false;
    }

    protected function loadEventsFromFile()
    {
        /** @var Scheduler $scheduler */
        $scheduler = $this;
        $file = (new FileDetector($scheduler))->getPath();

        require_once $file;
    }
}
