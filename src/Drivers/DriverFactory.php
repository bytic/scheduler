<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Events\EventCollection;

/**
 * Class DriverFactory
 * @package Bytic\Scheduler\Drivers
 */
class DriverFactory
{
    protected static $list = [
        'crontab' => CrontabDriver::class
    ];

    public static function publish(EventCollection $collection, $driver)
    {
        $driver = static::get($driver);
        return new $class();
    }

    public static function get($driver)
    {
        $class = static::$list[$driver];
        return new $class();
    }
}
