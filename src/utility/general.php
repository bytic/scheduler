<?php

use Nip\Container\Container;

if (!function_exists('scheduler')) {
    /**
     * @param string $connection
     * @return \Bytic\Scheduler\Scheduler
     */
    function scheduler()
    {
        if (function_exists('app')) {
            return app('scheduler');
        }

        $container = Container::getInstance();
        if ($container->has('scheduler')) {
            return $container->get('scheduler');
        }
        return null;
    }
}
