<?php

namespace Bytic\Scheduler\Tests\Drivers;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Events\Event;
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
    public function test_generateContentForEvent($event, $content)
    {
        $driver = new CrontabDriver();
        self::assertSame($content, $driver->generateContentForEvent($event));
    }

    /**
     * @return array
     */
    public function data_generateContentForEvent()
    {
        return [
            [
                (new Event('php foe1')),
                '* * * * * php foe1'
            ],
            [
                (new Event('php foe2')),
                '* * * * * php foe2'
            ],
        ];
    }
}