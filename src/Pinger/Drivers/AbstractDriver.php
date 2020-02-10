<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Utility\PopulateFromConfig;
use Nip\Config\Config;

/**
 * Class AbstractDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
abstract class AbstractDriver
{
    use PopulateFromConfig;

    /**
     * AbstractDriver constructor.
     * @param array|Config $config
     */
    public function __construct($config = [])
    {
        $this->populateFromConfig($config);
    }
    /**
     * @param EventCollection $collection
     * @return void
     */
    abstract public function publish(EventCollection $collection);

    /**
     * @param Event $event
     * @param array $options
     * @return mixed
     */
    abstract public function ping(Event $event, $options = []);
}
