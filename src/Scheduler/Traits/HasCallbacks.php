<?php

namespace Bytic\Scheduler\Scheduler\Traits;

/**
 * Trait HasCallbacks
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait HasCallbacks
{
    /**
     * The array of callbacks to be run for certain events
     *
     * @var array
     */
    protected $callbacks = [
        'onEventAdded' => [],
        'publish' => []
    ];

    /**
     * Register a callback to be called before the operation.
     *
     * @param $topic
     * @param \Closure|callable $callback
     * @return $this
     */
    public function registerCallback($topic, $callback)
    {
        $this->callbacks[$topic][] = $callback;
        return $this;
    }

    /**
     * @param $topic
     * @param array $parameters
     */
    protected function triggerCallbacks($topic, $parameters = [])
    {
        $callbacks = is_array($this->callbacks[$topic]) ? $this->callbacks[$topic] : [];
        foreach ($callbacks as $callback) {
            \call_user_func_array($callback, $parameters);
        }
    }
}
