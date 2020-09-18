<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Runner\Invoker;
use Closure;
use Symfony\Component\Process\Process;

/**
 * Trait HasCallbacks
 * @package Bytic\Scheduler\Events\Traits
 *
 * @method Process getProcess()
 */
trait HasCallbacks
{

    /**
     * The array of callbacks to be run before the event is started.
     *
     * @var array
     */
    protected $beforeCallbacks = [];

    /**
     * The array of callbacks to be run after the event is finished.
     *
     * @var array
     */
    protected $afterCallbacks = [];


    /**
     * Register a callback to be called before the operation.
     *
     * @param Closure $callback
     * @return $this
     */
    public function before(Closure $callback)
    {
        $this->beforeCallbacks[] = $callback;
        return $this;
    }

    /**
     * Register a callback to be called after the operation.
     *
     * @param Closure $callback
     * @return $this
     */
    public function after(Closure $callback)
    {
        return $this->then($callback);
    }

    /**
     * Register a callback to be called after the operation.
     *
     * @param Closure $callback
     * @return $this
     */
    public function then(Closure $callback)
    {
        $this->afterCallbacks[] = $callback;
        return $this;
    }

    /**
     * Return all registered before callbacks.
     *
     * @return Closure[]
     */
    public function beforeCallbacks()
    {
        return $this->beforeCallbacks;
    }

    /**
     * Return all registered after callbacks.
     *
     * @return Closure[]
     */
    public function afterCallbacks()
    {
        return $this->afterCallbacks;
    }

    /**
     * Register a callback to be called if the operation succeeds.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onSuccess(Closure $callback)
    {
        return $this->then(function ($event = null) use ($callback) {
            if ($this->getProcess()->isSuccessful()) {
                Invoker::call($callback, [$this], true);
            }
        });
    }

    /**
     * Register a callback to be called if the operation fails.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onFailure(Closure $callback)
    {
        return $this->then(function () use ($callback) {
            if (!$this->getProcess()->isSuccessful()) {
                Invoker::call($callback, [$this], true);
            }
        });
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function invokeBeforeCallbacks(array $parameters = [])
    {
        return $this->invokeCallbacks($this->beforeCallbacks(), $parameters);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function invokeAfterCallbacks(array $parameters = [])
    {
        return $this->invokeCallbacks($this->afterCallbacks(), $parameters);
    }

    /**
     * @param array $parameters
     * @return string
     */
    protected function invokeCallbacks($callbacks, array $parameters = [])
    {
        $output = '';
        foreach ($callbacks as $callback) {
            /** @var Closure $callback */
            if ($callback instanceof  Closure) {
                $callback = Closure::bind($callback, $this);
            }
            // Invoke the callback with buffering enabled
            $output .= Invoker::call($callback, $parameters, true);
        }
        return $output;
    }
}
