<?php

namespace Bytic\Scheduler\Events\Traits;

use function Opis\Closure\{serialize as s, unserialize as u};

/**
 * Trait IsSerializable
 * @package Bytic\Scheduler\Events\Traits
 */
trait IsSerializable
{
    /**
     * @inheritDoc
     */
    public function serialize()
    {
        $data = get_object_vars($this);
        return s($data);
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
