<?php

namespace Bytic\Scheduler\Scheduler\Traits;

/**
 * Trait HasConfigTrait
 * @package ByTIC\Queue\Connections\Manager
 */
trait HasConfigTrait
{

    /**
     * Get configuration value.
     *
     * @param string $name
     * @param null $default
     * @return array
     */
    protected function getConfig($name, $default = null)
    {
        if (!is_null($name) && $name !== 'null') {
            $name = '.' . $name;
        }
        $name = 'scheduler' . $name;
        return config($name, $default);
    }
}
