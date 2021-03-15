<?php

namespace Bytic\Scheduler\Loader\CacheLoader;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Scheduler;
use DateInterval;
use Nip\Cache\Cacheable\HasCacheStore;
use Nip\Utility\Str;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class CacheLoader
 * @package Bytic\Scheduler\Loader\CacheLoader
 */
class CacheLoader
{
    use SingletonTrait;
    use HasCacheStore;

    /**
     * @param Scheduler $scheduler
     * @return bool
     */
    public static function loadEvents(Scheduler $scheduler)
    {
        $data = static::instance()->getDataFromCache();
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
        static::instance()->saveDataToCache(
            $scheduler->getEvents()
        );
    }

    /**
     * @param null $key
     * @return mixed|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getDataFromCache($key = null)
    {
        return $this->cacheStore()->get($this->dataCacheKey($key));
    }

    /**
     * @param $data
     * @param null $key
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function saveDataToCache($data, $key = null)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->cacheStore()->set($this->dataCacheKey($key), $data,$this->dataCacheTtl($key));
    }

    /**
     * @param $key
     * @return string
     */
    protected function dataCacheKey($key= null): string
    {
        return Str::slug(__CLASS__).$key;
    }

    /**
     * @param null $key
     * @return DateInterval
     */
    protected function dataCacheTtl($key= null)
    {
        return DateInterval::createFromDateString('1 year');
    }
}
