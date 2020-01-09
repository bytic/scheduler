<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class DriverFactory
 * @package Bytic\Scheduler\Drivers
 */
class DriverManager
{
    protected static $list = [
        'crontab' => CrontabDriver::class
    ];

    protected static $instances = [
    ];

    public static function publish(EventCollection $collection, $driver)
    {
        $driver = static::get($driver);
        $driver::publish($collection);
    }

    /**
     * @param $driver
     * @return CrontabDriver
     */
    public static function get($driver)
    {
        if (!static::$instances[$driver]) {
            $class = static::$list[$driver];
            static::add( new $class(), $driver);
        }

        return static::$instances[$driver];
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
