<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Exception\InvalidArgumentException;

/**
 * Trait HasDriver
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasDriver
{

    /**
     * The cron expression representing the event's frequency.
     *
     * @var string
     */
    protected $driver = 'internal';

    public function using($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }
}
