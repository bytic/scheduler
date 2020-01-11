<?php

namespace Bytic\Scheduler\Events;

use Nip\Collections\AbstractCollection;

/**
 * Class EventCollection
 * @package Bytic\Scheduler\Events
 */
class EventCollection extends AbstractCollection
{
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
}
