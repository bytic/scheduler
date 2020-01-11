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
    use Traits\HasIdentifier;
    use Traits\HasNameDescription;
    use Traits\HasOutput;
    use Traits\HasUser;
    use Traits\HasWorkingDirectory;
    use Traits\IsExecutable;
    use Traits\ManagesFrequencies;

    /**
     * Event constructor.
     * @param $command
     */
    public function __construct($command)
    {
        $this->setCommand($command);

        $this->output = $this->getDefaultOutput();
    }
}
