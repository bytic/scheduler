<?php

namespace Bytic\Scheduler\Serializer;

use Closure;
use function Opis\Closure\{serialize, unserialize};

/**
 *
 */
class EventSerializer
{
    public const SERIALIZABLE_CALLBACKS = ['beforeCallbacks', 'afterCallbacks'];

    /**
     * @param $data
     * @return mixed
     */
    public static function serializeFromData($data)
    {
        foreach ($data as $name => $value) {
            if (in_array($name, self::SERIALIZABLE_CALLBACKS)) {
                $data[$name] = self::serializeWrapCallbackProperty($value);
            }
        }
        return $data;
    }

    protected static function serializeWrapCallbackProperty(array $value): array
    {
        foreach ($value as $key => $callback) {
            $value[$key] = self::serializeClosure($callback);
        }
        return $value;
    }

    /**
     * @param $data
     * @return string
     */
    protected static function serializeClosure($data)
    {
        if ($data instanceof Closure) {
            return serialize($data);
        }
        return $data;
    }

    /**
     * @param $object
     * @param array $data
     * @param Closure|null $setCallback
     * @return void
     */
    public static function unserializeFromData($object, array $data, Closure $setCallback = null)
    {
        foreach ($data as $name => $value) {
            if (in_array($name, self::SERIALIZABLE_CALLBACKS)) {
                $value = self::unserializeCallbackProperty($value);
            }
            if ($setCallback) {
                $setCallback($name, $value);
            } else {
                $object->{$name} = $value;
            }
        }
    }

    /**
     * @param array $value
     * @return array
     */
    protected static function unserializeCallbackProperty(array $value)
    {
        foreach ($value as $name => $callback) {
            $value[$name] = self::unserializeClosure($callback);
        }
        return $value;
    }

    /**
     * @param $data
     * @return Closure|mixed
     */
    public static function unserializeClosure($data)
    {
        if (is_string($data)) {
            $data = unserialize($data);
        }
        return $data;
    }

}
