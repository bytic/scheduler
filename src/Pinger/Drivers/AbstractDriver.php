<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;

/**
 * Class AbstractDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
abstract class AbstractDriver
{
    /**
     * @param Event $event
     * @param array $options
     * @return mixed
     */
    abstract public function ping(Event $event, $options = []);
}
