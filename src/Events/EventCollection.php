<?php

namespace Bytic\Scheduler\Events;

use Nip\Collections\Typed\ClassCollection;
use Opis\Closure\SerializableClosure;

/**
 * Class EventCollection
 * @package Bytic\Scheduler\Events
 */
class EventCollection extends ClassCollection
{
    protected $validClass = Event::class;

    /**
     * {@inheritDoc}
     * @param Event $element
     */
    public function add($element, $key = null)
    {
        if ($key == null) {
            $key = $element->getIdentifier();
        }

        parent::add($element, $key);
    }

    protected function unserializeAllowedClasses()
    {
        return [Event::class, SerializableClosure::class];
    }
}
