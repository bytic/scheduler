<?php

namespace Bytic\Scheduler\Events;

use Bytic\Scheduler\Scheduler;

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
}
