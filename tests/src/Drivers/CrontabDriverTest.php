<?php

namespace Bytic\Scheduler\Tests\Drivers;

use Bytic\Scheduler\Drivers\CrontabDriver;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Helper;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CrontabDriverTest
 * @package Bytic\Scheduler\Tests\Drivers
 */
class CrontabDriverTest extends AbstractTest
{
    public function test_generateContent()
    {
        $this->loadConfig();

        $driver = new CrontabDriver();
        $events = new EventCollection();

        $event1 = (new Event('php foe1'));
        $events->add($event1);

        $event2 = (new Event('php foe2'));
        $events->add($event2);

        $content = $driver->generateContent($events);
        self::assertStringContainsString('# Event [php foe1]', $content);
        self::assertStringContainsString('# Event [php foe2]', $content);
    }

    /**
     * @param $event
     * @param $content
     * @dataProvider data_generateContentForEvent
     */
    public function test_generateContentForEvent(Event $event, $content)
    {
        $this->loadConfig();

        $driver = new CrontabDriver();
        $cron = $driver->generateContentForEvent($event);
        foreach ($content as $string) {
            self::assertStringContainsString($string, $cron);
        }
        self::assertStringContainsString('/bin/php', $cron);
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
                ['* * * * *', $byticPath, ' schedule:run-event -e']
            ],
            [
                (new Event('php foe2')),
                ['* * * * *', $byticPath, ' schedule:run-event -e']
            ],
        ];
    }
}
