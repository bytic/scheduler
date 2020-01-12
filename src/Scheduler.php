<?php

namespace Bytic\Scheduler;

/**
 * Class Scheduler
 * @package Bytic\Scheduler
 */
class Scheduler
{
    use Scheduler\Traits\EventAdderTrait;
    use Scheduler\Traits\HasDrivers;
    use Scheduler\Traits\HasEventsTrait;

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
    }
}
