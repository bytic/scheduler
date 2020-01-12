<?php

namespace Bytic\Scheduler\Tests\Drivers;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Helper;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CrontabDriverTest
 * @package Bytic\Scheduler\Tests\Drivers
 */
class CrontabDriverTest extends AbstractTest
{
    /**
     * @param $event
     * @param $content
     * @dataProvider data_generateContentForEvent
     */
    public function test_generateContentForEvent(Event $event, $content)
    {
        $driver = new CrontabDriver();
        self::assertStringStartsWith($content, $driver->generateContentForEvent($event));
    }

    /**
     * @return array
     */
    public function data_generateContentForEvent()
    {
        $byticPath =  Helper::normalizePath(TEST_FIXTURE_PATH, 'vendor', 'bin', 'bytic');
        return [
            [
                (new Event('php foe1')),
                '* * * * * ' . $byticPath . ' schedule:run-event -e'
            ],
            [
                (new Event('php foe2')),
                '* * * * * ' . $byticPath . ' schedule:run-event -e'
            ],
        ];
    }
}
