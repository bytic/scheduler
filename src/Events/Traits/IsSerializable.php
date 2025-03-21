<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Serializer\EventSerializer;
use function serialize;

/**
 * Trait IsSerializable
 * @package Bytic\Scheduler\Events\Traits
 */
trait IsSerializable
{
    public $inSerialization = false;

    public function __serialize(): array
    {
        $data = get_object_vars($this);
        if ($this->inSerialization) {
            return $data;
        }
        $this->inSerialization = true;
        $return = EventSerializer::serializeFromData($data);
        $this->inSerialization = false;
        return $return;
    }

    public function __unserialize(array $data): void
    {
        EventSerializer::unserializeFromData($this, $data, function ($name, $value) {
            $this->{$name} = $value;
        });
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
        $data = unserialize($str);
        if (is_array($data)) {
            $this->__unserialize($data);
        }
    }
}
