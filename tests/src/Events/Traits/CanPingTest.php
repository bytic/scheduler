<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CanPingTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class CanPingTest extends AbstractTest
{
    public function test_pingOnLifecycle()
    {
        $event = new Event('php foe');
        $event->pingOnLifecycle('test');

        $callbacks = $event->beforeCallbacks();
        self::assertCount(1, $callbacks);

        $callbacks = $event->afterCallbacks();
        self::assertCount(2, $callbacks);
    }

    public function test_pingBefore()
    {
        $event = new Event('php foe');
        $event->pingBefore('test1');
        $event->pingBefore('test2');

        $callbacks = $event->beforeCallbacks();
        self::assertCount(2, $callbacks);
    }

    public function test_pingBeforeIf()
    {
        $event = new Event('php foe');
        $event->pingBeforeIf(true, 'test1');
        $event->pingBeforeIf(false, 'test2');

        $callbacks = $event->beforeCallbacks();
        self::assertCount(1, $callbacks);
    }

    public function test_pingAfter()
    {
        $event = new Event('php foe');
        $event->pingAfter('test1');
        $event->pingAfter('test2');

        $callbacks = $event->afterCallbacks();
        self::assertCount(2, $callbacks);
    }

    public function test_pingAfterIf()
    {
        $event = new Event('php foe');
        $event->pingAfterIf(true, 'test1');
        $event->pingAfterIf(false, 'test2');

        $callbacks = $event->afterCallbacks();
        self::assertCount(1, $callbacks);
    }
}
