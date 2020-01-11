<?php

namespace Bytic\Scheduler\Events\Traits;

/**
 * Trait HasIdentifier
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasIdentifier
{
    protected $identifier = null;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        if ($this->identifier === null) {
            $this->setIdentifier($this->generateIdentifier());

        }
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    protected function generateIdentifier()
    {
        return md5($this->getCommand() . serialize($this));
    }
}