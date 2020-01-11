<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Loader\CacheLoader\CacheLoader;

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
