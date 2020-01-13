<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use Bytic\Scheduler\Helper;

/**
 * Trait HasIdentifierTrait
 * @package Bytic\Scheduler\Scheduler\Traits
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
        $this->identifier = $this->getConfig('name', Helper::getBasePath());
    }
}