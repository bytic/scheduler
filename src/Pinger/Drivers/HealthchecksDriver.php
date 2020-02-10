<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Pinger\Drivers\Healthchecks\HealthchecksClient;
use Bytic\Scheduler\Pinger\Drivers\Traits\HasHttpClient;

/**
 * Class HealthchecksDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
class HealthchecksDriver extends AbstractDriver
{
    use HasHttpClient;

    protected $client = null;

    /**
     * @inheritDoc
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->client = new HealthchecksClient();
        $this->client->populateFromConfig($config);
    }

    /**
     * @inheritDoc
     */
    public function publish(EventCollection $collection)
    {
        $this->client->deleteChecks();
        foreach ($collection as $event) {
            $this->determineUrlForEvent($event);
        }
    }

    /**
     * @inheritDoc
     */
    public function ping(Event $event, $options = [])
    {
        $url = $this->determineUrlForEvent($event, $options);

        $trigger = isset($options['trigger']) ? $options['trigger'] : '';
        switch ($trigger) {
            case 'before':
                $url .= '/start';
                break;
            case 'failure':
                $url .= '/fail';
                break;
        }

        $this->pingUrl($url);
    }

    /**
     * @param Event $event
     * @param array $options
     * @return string
     */
    protected function determineUrlForEvent(Event $event, $options = [])
    {
        $cacheKey = $event->getIdentifier();
        $urlCached = cache()->get('scheduler-healthchecks');
        $urlCached = is_array($urlCached) ? $urlCached : [];
        if (isset($urlCached[$cacheKey])) {
            return $urlCached[$cacheKey];
        }
        $urlCached[$cacheKey] = $this->generateUrlForEvent($event, $options);
        cache()->put('scheduler-healthchecks', $urlCached);
        return $urlCached[$cacheKey];
    }

    /**
     * @param Event $event
     * @return string
     */
    protected function generateUrlForEvent(Event $event, $options = [])
    {
        $name = $event->getIdentifierHumanRead();

        $checks = $this->client->getChecks();
        foreach ($checks as $check) {
            if ($check['name'] == $name) {
                return $check['ping_url'];
            }
        }
        $check = $this->client->createCheckForEvent($event);
        return $check['ping_url'];
    }
}
