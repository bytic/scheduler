<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Events\Event;

/**
 * Trait HasPingers
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasPingers
{
    /**
     * @var array
     */
    protected $eventsByPinger = [];

    /**
     * @param Event $event
     */
    protected function onEventAddedPingers($event)
    {
        $pingers = $event->getPingers();

        foreach ($pingers as $destination => $pingerOptions) {
            $this->eventsByPinger[$destination][] = $event->getIdentifier();
        }

    }

    protected function publishPingers()
    {
        foreach ($this->eventsByPinger as $destination => $identifiers) {
            $eventCollection = $this->getEvents()->only($identifiers);
        }
    }

    /**
     * @return array
     */
    public function getEventsByPinger(): array
    {
        return $this->eventsByPinger;
    }
}