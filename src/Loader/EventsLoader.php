<?php

namespace Bytic\Scheduler\Loader;

use Bytic\Scheduler\Loader\CacheLoader\CacheLoader;
use Bytic\Scheduler\Loader\FileLoader\FileLoader;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Scheduler\Traits\HasEventsTrait;

/**
 * Class EventsLoader
 * @package Bytic\Scheduler\Loader
 */
class EventsLoader
{
    /**
     * @param Scheduler|HasEventsTrait $scheduler
     */
    static public function loadEvents(Scheduler $scheduler)
    {
        if (static::loadEventsFromCache($scheduler)) {
            return;
        }
        static::loadEventsFromFile($scheduler);
        CacheLoader::saveEvents($scheduler);
    }

    /**
     * @param Scheduler $scheduler
     * @return bool
     */
    static protected function loadEventsFromCache(Scheduler $scheduler)
    {
        return CacheLoader::loadEvents($scheduler);
    }

    /**
     * @param Scheduler $scheduler
     * @return bool
     */
    static protected function loadEventsFromFile(Scheduler $scheduler)
    {
        return FileLoader::loadEvents($scheduler);
    }
}
