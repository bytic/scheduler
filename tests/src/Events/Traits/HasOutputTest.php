<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;

/**
 * Class HasOutputTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class HasOutputTest extends \Bytic\Scheduler\Tests\AbstractTest
{
    public function test_outputCaptureProcessCallback()
    {
        $event = new Event('php -v');
        $event->start();
        $event->waitUntilFinish();

        $output = $event->wholeOutput();
        self::assertIsString($output);
        self::assertStringStartsWith('PHP', $output);
    }
}
