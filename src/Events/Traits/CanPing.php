<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Pinger\PingerManager;
use Nip\Container\Container;

/**
 * Trait CanPing
 * @package Bytic\Scheduler\Events\Traits
 */
trait CanPing
{
    /**
     * Register a callback to ping a given URL before the job runs.
     *
     * @param string $destination
     * @param array $options
     * @return $this
     */
    public function pingBefore($destination, $options = [])
    {
        return $this->before($this->pingCallback($destination, $options));
    }

    /**
     * Register a callback to ping a given URL before the job runs if the given condition is true.
     *
     * @param bool $value
     * @param string $destination
     * @param $
     * @param array $options
     * @return $this
     */
    public function pingBeforeIf($value, $destination, $options = [])
    {
        return $value ? $this->pingBefore($destination, $options) : $this;
    }

    /**
     * Register a callback to ping a given URL after the job runs.
     *
     * @param string $destination
     * @param array $options
     * @return $this
     */
    public function pingAfter($destination, $options = [])
    {
        return $this->after($this->pingCallback($destination, $options));
    }

    /**
     * Register a callback to ping a given URL after the job runs if the given condition is true.
     *
     * @param bool $value
     * @param string $destination
     * @param array $options
     * @return $this
     */
    public function pingAfterIf($value, $destination, $options = [])
    {
        return $value ? $this->pingAfter($destination, $options) : $this;
    }

    /**
     * Register a callback to ping a given URL if the operation succeeds.
     *
     * @param string $destination
     * @param array $options
     * @return $this
     */
    public function pingOnSuccess($destination, $options = [])
    {
        return $this->onSuccess($this->pingCallback($destination, $options));
    }

    /**
     * Register a callback to ping a given URL if the operation fails.
     *
     * @param string $destination
     * @param array $options
     * @return $this
     */
    public function pingOnFailure($destination, $options = [])
    {
        return $this->onFailure($this->pingCallback($destination, $options));
    }

    /**
     * Get the callback that pings the given URL.
     *
     * @param string $destination
     * @param array $options
     * @return \Closure
     */
    protected function pingCallback($destination, $options = [])
    {
        return function () use ($destination, $options) {
            /** @var PingerManager $manager */
            $manager = Container::getInstance()->get(PingerManager::class);
            $manager::ping($destination, $this, $options);
        };
    }
}