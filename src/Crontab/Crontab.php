<?php

namespace Bytic\Scheduler\Crontab;

/**
 * Class Crontab
 * @package Bytic\Scheduler\Crontab
 */
class Crontab
{
    use Traits\HasExecutableTrait;
    use Traits\HasCommentBlockTrait;
    use Traits\HasIdentifierTrait;

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