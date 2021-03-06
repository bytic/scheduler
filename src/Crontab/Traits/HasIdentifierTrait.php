<?php

namespace Bytic\Scheduler\Crontab\Traits;

use Bytic\Scheduler\Helper;

/**
 * Trait HasIdentifierTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasIdentifierTrait
{
    /**
     * @var string
     */
    protected $identifier = null;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        if ($this->identifier === null) {
            $this->initIdentifier();
        }
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    protected function initIdentifier()
    {
        $this->identifier = Helper::getBasePath();
    }
}
