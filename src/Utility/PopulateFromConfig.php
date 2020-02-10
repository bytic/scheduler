<?php

namespace Bytic\Scheduler\Utility;

use Iterator;

/**
 * Trait PopulateFromConfig
 * @package Bytic\Scheduler\Utility
 */
trait PopulateFromConfig
{
    /**
     * @param array|Iterator $config
     */
    public function populateFromConfig($config)
    {
        foreach ($config as $name => $value) {
            $this->{$name} = $value;
        }
    }
}
