<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;

/**
 * Class HealthchecksDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
class HealthchecksDriver extends AbstractDriver
{

    /**
     * @inheritDoc
     */
    function ping(Event $event, $options = [])
    {
        // TODO: Implement ping() method.
    }
}