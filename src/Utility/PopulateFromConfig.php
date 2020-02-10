<?php

namespace Bytic\Scheduler\Utility;

/**
 * Trait PopulateFromConfig
 * @package Bytic\Scheduler\Utility
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
