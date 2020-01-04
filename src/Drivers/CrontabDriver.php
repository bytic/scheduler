<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Crontab\Crontab;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;

/**
 * Class CrontabDriver
 * @package Bytic\Scheduler\Drivers
 */
class CrontabDriver extends AbstractDriver
{
    protected $crontab;

    /**
     * CrontabDriver constructor.
     * @param $crontab
     */
    public function __construct()
    {
        $this->crontab = new Crontab();
    }

    /**
     * @return Crontab
     */
    public function getCrontab(): Crontab
    {
        return $this->crontab;
    }

    /**
     * @param Crontab $crontab
     */
    public function setCrontab(Crontab $crontab)
    {
        $this->crontab = $crontab;
    }

    /**
     * @param EventCollection $collection
     */
    public function publish(EventCollection $collection)
    {
        $this->crontab->write(static::generateContent($collection));
    }

    /**
     * @param EventCollection $collection
     * @return string
     */
    public function generateContent(EventCollection $collection)
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
    public function generateContentForEvent(Event $event)
    {
        $content = $event->getExpression();
        $content .= ' ' . $event->getCommand();
        return $content;
    }
}