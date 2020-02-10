<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Pinger\Drivers\Traits\HasHttpClient;

/**
 * Class UrlDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
class UrlDriver extends AbstractDriver
{
    use HasHttpClient;

    /**
     * @inheritDoc
     */
    public function ping(Event $event, $options = [])
    {
        $url = $options['url'];
        $this->pingUrl($url);
    }

    /**
     * @inheritDoc
     */
    public function publish(EventCollection $collection)
    {
    }
}
