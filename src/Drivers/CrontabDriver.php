<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Crontab\Crontab;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;

/**
 * Class CrontabDriver
 * @package Bytic\Scheduler\Drivers
 */
class CrontabDriver
{
    /**
     * @param EventCollection $collection
     */
    public static function publish(EventCollection $collection)
    {
        $crontab = new Crontab();
        $crontab->write(static::generateContent($collection));
    }

    /**
     * @param EventCollection $collection
     * @return string
     */
    protected static function generateContent(EventCollection $collection)
    {
        $content = [];
        foreach ($collection as $event) {
            $content[] = static::generateContentForEvent($event);
        }
        return implode("\n", $content);
    }

    /**
     * @param Event $event
     * @return string
     */
    protected static function generateContentForEvent(Event $event)
    {
        $content = $event->getExpression();
        $content .= ' ' . $event->getExpression();
        return $content;
    }
}
