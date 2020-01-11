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
    public function test_generateContentForEvent(Event $event, $content)
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
                '* * * * * H:\webdev\www\libraries\bytic\scheduler\tests\fixtures schedule:run-event -e 9b76e2491ed3f8197f86329b03c4bf9b'
            ],
            [
                (new Event('php foe2')),
                '* * * * * H:\webdev\www\libraries\bytic\scheduler\tests\fixtures schedule:run-event -e 8e21bdada66ea36a9691dad5b511fb71'
            ],
        ];
    }
}
