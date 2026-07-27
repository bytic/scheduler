<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Drivers\Traits\HasPauseStateTrait;
use Bytic\Scheduler\Events\EventCollection;

/**
 * Class AbstractDriver
 * @package Bytic\Scheduler\Drivers
 */
abstract class AbstractDriver
{
    use HasPauseStateTrait;

    /**
     * @param EventCollection $collection
     * @return void
     */
    abstract public function publish(EventCollection $collection);
}
