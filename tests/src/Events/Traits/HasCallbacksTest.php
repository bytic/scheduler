<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Runner\Invoker;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasCallbacksTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class HasCallbacksTest extends AbstractTest
{
    public function test_onSuccess()
    {
        $event = new Event('php -v');
        $event->onSuccess(function ($event) {
            $event->afterTest = true;
            self::assertInstanceOf(Event::class, $event);
        });

        $event->start();
        $event->waitUntilFinish();

        $callbacks = $event->afterCallbacks();
        foreach ($callbacks as $callback) {
            Invoker::call($callback, [$event], true);
        }
        self::assertTrue($event->afterTest);

    }

    public function test_after()
    {
        $event = new Event('php -v');
        $event->after(function ($event) {
            $event->afterTest = true;
            self::assertInstanceOf(Event::class, $event);
        });

        $callbacks = $event->afterCallbacks();
        foreach ($callbacks as $callback) {
            Invoker::call($callback, [$event], true);
        }
        self::assertTrue($event->afterTest);
    }
}
