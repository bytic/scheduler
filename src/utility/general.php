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

        return Container::getInstance()->get('scheduler');
    }
}
