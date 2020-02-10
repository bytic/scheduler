<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class IsSerializableTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class IsSerializableTest extends AbstractTest
{
    public function test_serialize_unserialize()
    {
        $event = new Event('php -v');
        $event->after(function () {
            return 7;
        });
        $event->pingAfter('healthcheck');

        $content = serialize($event);
        self::assertGreaterThan(10, strlen($content));

        $event = unserialize($content);
        self::assertInstanceOf(Event::class, $event);

        $callbacks = $event->afterCallbacks();
        self::assertIsArray($callbacks);
        self::assertCount(2, $callbacks);

        $firstCallback = reset($callbacks);
        self::assertSame(7, $firstCallback());
    }
}