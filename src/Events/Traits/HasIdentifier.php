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
    public function getIdentifierHumanRead()
    {
        return scheduler()->getIdentifier() . ' # ' . $this->getCommand();
    }

    /**
     * @return string
     */
    protected function generateIdentifier()
    {
        $properties = get_object_vars($this);
        unset($properties['beforeCallbacks']);
        unset($properties['afterCallbacks']);
        return md5($this->getCommand() . serialize($properties));
    }
}
