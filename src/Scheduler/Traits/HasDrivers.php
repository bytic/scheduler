<?php

namespace Bytic\Scheduler\Scheduler\Traits;

/**
 * Trait HasDrivers
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasDrivers
{
    /**
     * @return array
     */
    public function getDrivers()
    {
        return ['crontab'];
    }
}