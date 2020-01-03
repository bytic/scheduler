<?php

use Nip\Container\Container;

if (!function_exists('scheduler')) {
    /**
     * @param string $connection
     * @return Connection
     */
    function scheduler()
    {
        if (function_exists('app')) {
            return app('scheduler');
        }

        return Container::getInstance()->get('queue')->connection($connection);
    }
}