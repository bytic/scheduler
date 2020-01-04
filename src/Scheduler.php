<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class Scheduler
 * @package Bytic\Scheduler
 */
class Scheduler
{
    use Scheduler\Traits\HasDrivers;
    use Scheduler\Traits\HasEventsTrait;

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
    }
}
