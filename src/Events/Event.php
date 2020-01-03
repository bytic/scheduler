<?php

namespace Bytic\Scheduler\Events;

/**
 * Class Event
 * @package Bytic\Scheduler\Events
 */
class Event
{
    use Traits\HasCommand;
    use Traits\HasCronExpression;
    use Traits\HasDriver;
    use Traits\ManagesFrequencies;

    /**
     * Event constructor.
     * @param $command
     */
    public function __construct($command)
    {
        $this->setCommand($command);
    }
}
