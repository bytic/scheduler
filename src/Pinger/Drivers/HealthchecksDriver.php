<?php

namespace Bytic\Scheduler\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Traits\isApiDriver;
use Psr\Http\Message\ResponseInterface;

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
        $url = $this->determineUrlForEvent($event, $options);
        $this->pingUrl($url);
    }

    /**
     * @return |null
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
        $urlCached[$cacheKey] = $this->generateUrlForEvent($event);
        cache()->put('scheduler-healthchecks', $urlCached);
        return $urlCached[$cacheKey];
    }

    /**
     * @param Event $event
     * @return string
     */
    protected function generateUrlForEvent(Event $event)
    {
        $name = $event->getIdentifierHumanRead();

        $checks = $this->getChecks();
        foreach ($checks as $check) {
            if ($check['name'] == $name) {
                return $check['ping_url'];
            }
        }
        $check = $this->createCheckForEvent($event);
        return $check['ping_url'];
    }

    /**
     * @return array
     */
    protected function generateChecks()
    {
        $response = $this->request('GET', '/api/v1/checks/');
        return $response['checks'];
    }

    /**
     * @param Event $event
     * @return array
     */
    public function createCheckForEvent(Event $event)
    {
        $data = [
            'name' => $event->getIdentifierHumanRead(),
            'tags' => scheduler()->getIdentifier(),
            'desc' => $event->getSummaryForDisplay(),
            'timeout' => 86400,
            'grace' => 60,
            'schedule' => $event->getExpression(),
            'unique' => ["name"],
        ];
        return $this->request('POST', '/api/v1/checks/', $data);
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * @return array
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function getHttpHeadersDefault()
    {
        if (empty($this->getApiKey())) {
            throw new \Exception("HealthchecksDriver needs apiKey to perform requests");
        }
        return [
            self::AUTH_HEADER => $this->apiKey,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function generateBaseUri(): string
    {
        return self::BASE_URI;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
