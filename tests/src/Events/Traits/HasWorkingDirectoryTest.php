<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasWorkingDirectoryTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class HasWorkingDirectoryTest extends AbstractTest
{
    public function test_in()
    {
        $event = new Event('php foo');
        static::assertFalse($event->getWorkingDirectory());

        $event->in('/home/root');

        static::assertSame('/home/root', $event->getWorkingDirectory());
    }
}
