<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;

/**
 * Class HealthchecksDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
class HealthchecksDriver extends AbstractDriver
{
    /** @var string[] */
    protected $apiKeys;

    /** @var int */
    protected $baseUri;

    protected $checks = null;

    /**
     * HealthchecksDriver constructor.
     * @inheritDoc
     */
<<<<<<< Updated upstream
=======
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
>>>>>>> Stashed changes
    public function ping(Event $event, $options = [])
    {
        // TODO: Implement ping() method.
    }
<<<<<<< Updated upstream
}
=======

    /**
     * @param Event $event
     * @return string
     */
    protected function determineUrlForEvent(Event $event)
    {
        return '';
    }
}
>>>>>>> Stashed changes
