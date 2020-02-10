<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class Scheduler
 * @package Bytic\Scheduler
 */
class Scheduler
{
    use Scheduler\Traits\CanPublish;
    use Scheduler\Traits\EventAdderTrait;
    use Scheduler\Traits\HasCallbacks;
    use Scheduler\Traits\HasConfigTrait;
    use Scheduler\Traits\HasDrivers;
    use Scheduler\Traits\HasEventsTrait;
    use Scheduler\Traits\HasIdentifierTrait;
    use Scheduler\Traits\HasPingers;

    /**
     * @var string Library version, used for setting User-Agent
     */
    const VERSION = '0.9';

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
        $this->events = new EventCollection();
        $this->registerDefaultCallbacks();
    }

    protected function registerDefaultCallbacks()
    {
        $this->registerCallback('onEventAdded', [$this, 'onEventAddedDrivers']);
        $this->registerCallback('onEventAdded', [$this, 'onEventAddedPingers']);

        $this->registerCallback('publish', [$this, 'publishDrivers']);
        $this->registerCallback('publish', [$this, 'publishPingers']);
    }
}
