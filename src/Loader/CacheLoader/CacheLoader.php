<?php

namespace Bytic\Scheduler\Loader\CacheLoader;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Scheduler;
use Nip\Cache\Manager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class CacheLoader
 * @package Bytic\Scheduler\Loader\CacheLoader
 */
class CacheLoader
{
    use SingletonTrait;

    protected $cacheManager;

    /**
     * CacheLoader constructor.
     */
    public function __construct()
    {
        $this->cacheManager = new Manager();
        $this->cacheManager->setActive(true);
        $this->cacheManager->setTtl(365 * 24 * 60 * 60);
    }

    /**
     * @param Scheduler $scheduler
     * @return bool
     */
    public static function loadEvents(Scheduler $scheduler)
    {
        $data = static::instance()->cacheManager->get(
            static::instance()->cacheId()
        );
        if ($data instanceof EventCollection) {
            $scheduler->setEvents($data);
            return true;
        }
        return false;
    }

    /**
     * @param Scheduler $scheduler
     */
    public static function saveEvents(Scheduler $scheduler)
    {
        static::instance()->cacheManager->saveData(
            static::instance()->cacheId(),
            $scheduler->getEvents()
        );
    }

    /**
     * @return string
     */
    protected function cacheId()
    {
        return 'scheduler';
    }
}
