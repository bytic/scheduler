<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Traits\isApiDriver;

/**
 * Class HealthchecksDriver
 * @package Bytic\Scheduler\Pinger\Drivers
 */
class HealthchecksDriver extends AbstractDriver
{
    use isApiDriver;

    const AUTH_HEADER = 'X-Api-Key';

    const BASE_URI = 'https://healthchecks.io';

    /** @var string */
    protected $apiKey;

    protected $checks = null;

    /**
     * @inheritDoc
     */
    public function ping(Event $event, $options = [])
    {
        $url = $this->determineUrlForEvent($event);
        $this->pingUrl($url);
    }

    /**
     * @return |null
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getChecks()
    {
        if ($this->checks === null) {
            $this->checks = $this->generateChecks();
        }
        return $this->checks;
    }

    /**
     * @param Event $event
     * @return string
     */
    protected function determineUrlForEvent(Event $event)
    {
        return '';
    }

    /**
     * @return mixed
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    protected function generateChecks()
    {
        $uri = $this->generateFullUri('/api/v1/checks/');

        $request = $this->getRequestFactory()->createRequest('GET', $uri)
            ->withHeader(self::AUTH_HEADER, $this->apiKey);

        $response = $this->getClient()->sendRequest($request);
        $body = (string)$response->getBody();

        $checks = json_decode($body, true);
        return $checks;
    }

    /**
     * @inheritDoc
     */
    protected function generateBaseUri(): string
    {
        return self::BASE_URI;
    }
}
