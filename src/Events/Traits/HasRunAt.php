<?php

namespace Bytic\Scheduler\Events\Traits;

use DateTimeInterface;

/**
 * Trait HasRunAt
 *
 * Supports one-time events that should run at a specific datetime.
 *
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasRunAt
{
    /**
     * The specific datetime when this event should run (for one-time events).
     *
     * @var DateTimeInterface|null
     */
    protected $runAt = null;

    /**
     * Number of times this event has been attempted.
     *
     * @var int
     */
    protected $attempts = 0;

    /**
     * Maximum number of attempts before giving up.
     *
     * @var int
     */
    protected $maxAttempts = 1;

    /**
     * Seconds to wait before rescheduling after a failure.
     *
     * @var int
     */
    protected $rescheduleAfterSeconds = 300;

    /**
     * Schedule the event to run once at a specific datetime.
     *
     * @param DateTimeInterface $dateTime
     * @return $this
     */
    public function runOnce(DateTimeInterface $dateTime): static
    {
        $this->runAt = $dateTime;
        if (method_exists($this, 'using')) {
            $this->using('database');
        }
        return $this;
    }

    /**
     * Whether this is a one-time event.
     *
     * @return bool
     */
    public function isOneTimeEvent(): bool
    {
        return $this->runAt !== null;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getRunAt(): ?DateTimeInterface
    {
        return $this->runAt;
    }

    /**
     * @param DateTimeInterface|null $runAt
     * @return $this
     */
    public function setRunAt(?DateTimeInterface $runAt): static
    {
        $this->runAt = $runAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     * @return $this
     */
    public function setAttempts(int $attempts): static
    {
        $this->attempts = $attempts;
        return $this;
    }

    /**
     * Increment the attempt counter.
     *
     * @return $this
     */
    public function incrementAttempts(): static
    {
        $this->attempts++;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }

    /**
     * Set the maximum number of attempts.
     *
     * @param int $maxAttempts
     * @return $this
     */
    public function withMaxAttempts(int $maxAttempts): static
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }

    /**
     * @return int
     */
    public function getRescheduleAfterSeconds(): int
    {
        return $this->rescheduleAfterSeconds;
    }

    /**
     * Set the number of seconds to wait before rescheduling after failure.
     *
     * @param int $seconds
     * @return $this
     */
    public function rescheduleAfter(int $seconds): static
    {
        $this->rescheduleAfterSeconds = $seconds;
        return $this;
    }

    /**
     * Whether this event can be retried.
     *
     * @return bool
     */
    public function canRetry(): bool
    {
        return $this->attempts < $this->maxAttempts;
    }
}
