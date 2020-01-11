<?php

namespace Bytic\Scheduler\Crontab;

/**
 * Class Crontab
 * @package Bytic\Scheduler\Crontab
 */
class Crontab
{
    use Traits\HasCommentBlockTrait;
    use Traits\HasExecutableTrait;
    use Traits\HasIdentifierTrait;
    use Traits\HasReaderTrait;
    use Traits\HasUserTrait;
    use Traits\HasWriterTrait;

    /**
     * Constructor.
     *
     * @param string $identifier
     */
    public function __construct($identifier = null)
    {
        if ($identifier) {
            $this->setIdentifier($identifier);
        }
    }
}
