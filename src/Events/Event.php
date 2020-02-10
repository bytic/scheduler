<?php

namespace Bytic\Scheduler\Events;

use Serializable;

/**
 * Class Event
 * @package Bytic\Scheduler\Events
 */
class Event implements Serializable
{
    use Traits\CanPing;
    use Traits\HasCallbacks;
    use Traits\HasCommand;
    use Traits\HasCronExpression;
    use Traits\HasDriver;
    use Traits\HasIdentifier;
    use Traits\HasNameDescription;
    use Traits\HasOutput;
    use Traits\HasUser;
    use Traits\HasWorkingDirectory;
    use Traits\IsExecutable;
    use Traits\IsSerializable;
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
