<?php

namespace Bytic\Scheduler\Pinger;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Events\Traits\CanPing;
use Bytic\Scheduler\Pinger\Drivers\AbstractDriver;
use Bytic\Scheduler\Pinger\Drivers\UrlDriver;
use Nip\Container\Container;

/**
 * Class PingerManager
 * @package Bytic\Scheduler\Pinger
 */
class PingerManager
{
    protected static $list = [
        'url' => Drivers\UrlDriver::class,
        'healthchecks' => Drivers\HealthchecksDriver::class
    ];

    protected static $instances = [
    ];

    /**
     * @param string $destination
     * @param Event|CanPing $event
     * @param array $options
     */
    public static function ping(string $destination, Event $event, $options = [])
    {
        $driver = static::get($destination);
        if ($driver instanceof UrlDriver) {
            $options['url'] = $destination;
        }
        $driver->ping($event, $options);
    }


    /**
     * @param EventCollection $collection
     * @param $destination
     */
    public static function publish(EventCollection $collection, $destination)
    {
        $driver = static::get($destination);
        $driver->publish($collection);
    }

    /**
     * @param $destination
     * @return AbstractDriver
     */
    public static function get($destination)
    {
        if (isset(static::$instances[$destination])) {
            return static::$instances[$destination];
        }

        if (filter_var($destination, FILTER_VALIDATE_URL)) {
            $destination = 'url';
        }
        static::add(static::instanceDriver($destination), $destination);
        return static::$instances[$destination];
    }

    /**
     * @param $driver
     * @return bool|mixed|object
     */
    protected static function instanceDriver($driver)
    {
        $class = static::$list[$driver];
        $config = static::driverConfig($driver);

        $container = function_exists('app') ? app() : (class_exists(Container::class) ? Container::getInstance() : null);
        if ($container instanceof Container) {
            return $container->get($class, ['config' => $config]);
        }
        return new $class($config);
    }

    /**
     * @param $driver
     * @return array
     */
    protected static function driverConfig($driver)
    {
        if (function_exists('config') && function_exists('app')) {
            return config('scheduler.pingers.' . $driver, []);
        }
        return [];
    }

    /**
     * @param $driver
     * @param $name
     */
    public static function add($driver, $name)
    {
        static::$instances[$name] = $driver;
    }

    public static function reset()
    {
        static::$instances = [];
    }
}
