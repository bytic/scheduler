<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;
use DateTimeImmutable;

/**
 * Class HasRunAtTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class HasRunAtTest extends AbstractTest
{
    public function test_default_values()
    {
        $event = new Event('php foo');

        self::assertNull($event->getRunAt());
        self::assertFalse($event->isOneTimeEvent());
        self::assertEquals(0, $event->getAttempts());
        self::assertEquals(1, $event->getMaxAttempts());
        self::assertEquals(300, $event->getRescheduleAfterSeconds());
    }

    public function test_runOnce_sets_run_at_and_driver()
    {
        $event = new Event('php foo');
        $futureDate = new DateTimeImmutable('+1 hour');

        $result = $event->runOnce($futureDate);

        self::assertSame($event, $result);
        self::assertTrue($event->isOneTimeEvent());
        self::assertSame($futureDate, $event->getRunAt());
        self::assertEquals('database', $event->getDriver());
    }

    public function test_withMaxAttempts()
    {
        $event = new Event('php foo');

        $result = $event->withMaxAttempts(3);

        self::assertSame($event, $result);
        self::assertEquals(3, $event->getMaxAttempts());
    }

    public function test_rescheduleAfter()
    {
        $event = new Event('php foo');

        $result = $event->rescheduleAfter(600);

        self::assertSame($event, $result);
        self::assertEquals(600, $event->getRescheduleAfterSeconds());
    }

    public function test_incrementAttempts()
    {
        $event = new Event('php foo');

        self::assertEquals(0, $event->getAttempts());

        $event->incrementAttempts();
        self::assertEquals(1, $event->getAttempts());

        $event->incrementAttempts();
        self::assertEquals(2, $event->getAttempts());
    }

    public function test_canRetry_with_attempts_below_max()
    {
        $event = new Event('php foo');
        $event->withMaxAttempts(3);
        $event->setAttempts(0);

        self::assertTrue($event->canRetry());

        $event->setAttempts(2);
        self::assertTrue($event->canRetry());
    }

    public function test_canRetry_when_attempts_exceed_max()
    {
        $event = new Event('php foo');
        $event->withMaxAttempts(1);
        $event->setAttempts(1);

        self::assertFalse($event->canRetry());

        $event->setAttempts(5);
        self::assertFalse($event->canRetry());
    }

    public function test_setRunAt()
    {
        $event = new Event('php foo');
        $date = new DateTimeImmutable('2030-01-01 12:00:00');

        $result = $event->setRunAt($date);

        self::assertSame($event, $result);
        self::assertSame($date, $event->getRunAt());
        self::assertTrue($event->isOneTimeEvent());
    }

    public function test_setRunAt_null_clears_one_time_event()
    {
        $event = new Event('php foo');
        $event->runOnce(new DateTimeImmutable('+1 hour'));

        self::assertTrue($event->isOneTimeEvent());

        $event->setRunAt(null);
        self::assertFalse($event->isOneTimeEvent());
    }
}
