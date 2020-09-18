<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Pinger\PingerManager;
use Bytic\Scheduler\Runner\Invoker;
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

    public function test_serialize_unserialize_with_callbacks()
    {
        $file = TEST_FIXTURE_PATH . '/cache/scheduler-callback-test.php';
//        $event = new Event('php -v');
//        $event->pingBefore('healthchecks');
//        $event->pingAfter('healthchecks');
//        $event->pingOnSuccess('healthchecks');
//
//        file_put_contents($file, serialize($event));

        /** @var Event $event */
        $event = unserialize(file_get_contents($file));
        self::assertInstanceOf(Event::class, $event);

        $driver = \Mockery::mock(HealthchecksDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $driver->shouldReceive('ping')->times(3);
        PingerManager::add($driver, 'healthchecks');

        $event->invokeBeforeCallbacks();

        $event->start();
        $event->waitUntilFinish();

        $event->invokeAfterCallbacks();

        PingerManager::reset();
    }
}
