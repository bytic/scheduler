<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

/**
 * Trait PopulateFromConfig
 * @package Bytic\Scheduler\Pinger\Drivers\Traits
 */
trait PopulateFromConfig
{
    /**
     * @param array $config
     */
    public function populateFromConfig(array $config)
    {
        foreach ($config as $name => $value) {
            $this->{$name} = $value;
        }
    }
}
