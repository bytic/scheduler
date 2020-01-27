<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class Scheduler
 * @package Bytic\Scheduler
 */
class Scheduler
{
    use Scheduler\Traits\EventAdderTrait;
    use Scheduler\Traits\HasConfigTrait;
    use Scheduler\Traits\HasDrivers;
    use Scheduler\Traits\HasEventsTrait;
    use Scheduler\Traits\HasIdentifierTrait;
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
    }
}
