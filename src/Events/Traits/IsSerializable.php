<?php

namespace Bytic\Scheduler\Events\Traits;

use function Opis\Closure\serialize as s;
use function Opis\Closure\unserialize as u;
use function serialize;

/**
 * Trait IsSerializable
 * @package Bytic\Scheduler\Events\Traits
 */
trait IsSerializable
{
    public function __serialize(): array
    {
        $data = get_object_vars($this);
        foreach ($data as $name => $value) {
            if (in_array($name, ['beforeCallbacks', 'afterCallbacks'])) {
                $data[$name] = s($value);
            }
        }
        return $data;
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $name => $value) {
            if (in_array($name, ['beforeCallbacks', 'afterCallbacks'])) {
                $value = u($value);
            }
            $this->{$name} = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize($this);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($str)
    {
        $data = u($str);
        foreach ($data as $name => $value) {
            $this->{$name} = $value;
        }
    }
}
