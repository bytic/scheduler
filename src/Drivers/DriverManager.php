<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Events\EventCollection;
use Nip\Container\Container;

/**
 * Class DriverFactory
 * @package Bytic\Scheduler\Drivers
 */
class DriverManager
{
    protected static $list = [
        'crontab' => CrontabDriver::class,
        'internal' => InternalDriver::class,
    ];

    protected static $instances = [
    ];

    /**
     * @param EventCollection $collection
     * @param $driver
     */
    public static function publish(EventCollection $collection, $driver)
    {
        $driver = static::get($driver);
        $driver->publish($collection);
    }

    /**
     * @param $driver
     * @return CrontabDriver
     */
    public static function get($driver)
    {
        if (!isset(static::$instances[$driver])) {
            static::add(static::instanceDriver($driver), $driver);
        }

        return static::$instances[$driver];
    }

    /**
     * @param $driver
     * @return bool|mixed|object
     */
    protected static function instanceDriver($driver)
    {
        $class = static::$list[$driver];
        if (function_exists('app')) {
            return app()->get($class);
        }

        if (class_exists(Container::class)) {
            $container = Container::getInstance();
            if ($container instanceof Container) {
                return $container->get($class);
            }
        }

        return new $class();
    }

    /**
     * @param $driver
     * @param $name
     */
    public static function add($driver, $name)
    {
        static::$instances[$name] = $driver;
    }
}
