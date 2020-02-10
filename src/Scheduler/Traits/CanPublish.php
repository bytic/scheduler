<?php

namespace Bytic\Scheduler\Scheduler\Traits;

/**
 * Trait CanPublish
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait CanPublish
{
    public function publish()
    {
        $this->checkInitEvents();
        $this->triggerCallbacks('publish', []);
    }
}
