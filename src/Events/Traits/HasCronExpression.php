<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Exception\InvalidArgumentException;

/**
 * Trait HasCronExpression
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasCronExpression
{

    /**
     * The cron expression representing the event's frequency.
     *
     * @var string
     */
    protected $expression = '* * * * *';

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setMinute($value)
    {
        return $this->spliceIntoPosition(1, $value);
    }

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setHour($value)
    {
        return $this->spliceIntoPosition(2, $value);
    }

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setDay($value)
    {
        return $this->setDayMonth($value);
    }

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setDayMonth($value)
    {
        return $this->spliceIntoPosition(3, $value);
    }

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setMonth($value)
    {
        return $this->spliceIntoPosition(4, $value);
    }

    /**
     * @param $value
     * @return HasCronExpression
     */
    public function setDayWeek($value)
    {
        return $this->spliceIntoPosition(5, $value);
    }

//    /**
//     * @param $value
//     */
//    public function setYear($value)
//    {
//        $this->spliceIntoPosition(6, $value);
//    }

    /**
     * Splice the given value into the given position of the expression.
     *
     * @param int $position
     * @param string $value
     * @return HasCronExpression
     */
    protected function spliceIntoPosition($position, $value)
    {
        $segments = explode(' ', $this->expression);
        $segments[$position - 1] = $value;
        $this->setExpression(implode(' ', $segments));
        return $this;
    }

    /**
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * @param string $expression
     */
    public function setExpression(string $expression)
    {
        $this->expression = $expression;
    }

    /**
     * The Cron expression representing the event's frequency.
     *
     * @param string $expression
     * @return HasCronExpression
     */
    public function cron(string $expression): self
    {
        /** @var string[] $parts */
        $parts = \preg_split(
            '/\s/',
            $expression,
            -1,
            PREG_SPLIT_NO_EMPTY
        );
        if (\count($parts) > 5) {
            throw new InvalidArgumentException("Expression '{$expression}' has more than five parts and this is not allowed.");
        }
        $this->expression = $expression;
        return $this;
    }
}