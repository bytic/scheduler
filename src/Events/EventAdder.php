<?php

namespace Bytic\Scheduler\Events;

use Bytic\Scheduler\Events\Traits\HasCallbacks;
use Bytic\Scheduler\Runner\Invoker;
use Bytic\Scheduler\Scheduler;
use Closure;

/**
 * Class EventAdder
 * @package Bytic\Scheduler\Events
 */
class EventAdder
{
    /**
     * @var Scheduler
     */
    protected $scheduler;

    /**
     * @var \Closure[]
     */
    protected $afterChecks = [];

    protected $event;

    /**
     * EventAdder constructor.
     * @param Scheduler|Scheduler\Traits\EventAdderTrait $scheduler
     * @param $command
     */
    public function __construct(Scheduler $scheduler, $command)
    {
        $this->scheduler = $scheduler;
        $this->event = new Event($command);
    }

    public function __destruct()
    {
        $this->invokeAfter($this->event);
        $this->scheduler->addEvent($this->event);
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        call_user_func_array([$this->event, $name], $arguments);
        return $this;
    }

    /**
     * Register a callback to be called after the operation.
     *
     * @param \Closure $callback
     * @return $this
     */
    public function after(Closure $callback)
    {
        $this->afterChecks[] = $callback;
        return $this;
    }

    protected function invokeAfter($event)
    {
        foreach ($this->afterChecks as $callback) {
            // Invoke the callback with buffering enabled
            Invoker::call($callback, [$event]);
        }
    }
}
