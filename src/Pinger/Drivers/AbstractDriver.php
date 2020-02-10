<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Traits\PopulateFromConfig;

/**
 * Class AbstractDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
abstract class AbstractDriver
{
    use PopulateFromConfig;

    /**
     * AbstractDriver constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->populateFromConfig($config);
    }

    public function register($scheduler)
    {

    }

    /**
     * @param Event $event
     * @param array $options
     * @return mixed
     */
    abstract public function ping(Event $event, $options = []);
}
