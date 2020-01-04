<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class InternalDriver
 * @package Bytic\Scheduler\Drivers
 */
class InternalDriver extends AbstractDriver
{

    /**
     * @param EventCollection $collection
     * @return void
     */
    public function publish(EventCollection $collection)
    {
    }
}
