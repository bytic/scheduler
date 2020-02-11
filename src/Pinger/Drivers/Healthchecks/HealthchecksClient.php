<?php

namespace Bytic\Scheduler\Pinger\Drivers\Healthchecks;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Traits\isApiDriver;
use Bytic\Scheduler\Utility\PopulateFromConfig;
use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HealthchecksClient
 * @package Bytic\Scheduler\Pinger\Drivers\Healthchecks
 */
class HealthchecksClient
{
    use isApiDriver {
        buildRequestValues as buildRequestValuesTrait;
    }
    use PopulateFromConfig;

    const AUTH_HEADER = 'X-Api-Key';

    const BASE_URI = 'https://healthchecks.io';

    /** @var string */
    protected $apiKey;

    protected $checks = null;

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function deleteChecks()
    {
        $checks = $this->getChecks();
        foreach ($checks as $check) {
            $this->request('DELETE', $check['update_url']);
        }
    }

    /**
     * @param $url
     */
    public function pingUrl($url)
    {
        $this->getClient()->get($url);
    }

    /**
     * @return array
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
     * @return array
     */
    public function createCheckForEvent(Event $event)
    {
        $data = [
            'name' => $event->getIdentifierHumanRead(),
            'tags' => $this->getIdentifier(),
            'desc' => $event->getSummaryForDisplay(),
            'timeout' => 86400,
            'grace' => 3600,
            'schedule' => $event->getExpression(),
            'unique' => ["name"],
        ];
        return $this->request('POST', '/api/v1/checks/', $data);
    }

    /**
     * @return array
     */
    protected function generateChecks()
    {
        $response = $this->request('GET', '/api/v1/checks/');
        return array_filter($response['checks'], function ($check) {

            $tags = explode(' ', $check['tags']);
            if (array_search($this->getIdentifier(), $tags) === false) {
                return false;
            }
            return true;
        });
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @inheritDoc
     */
    protected function buildRequestValues($method, $path, $payload, $headers)
    {
        $response = $this->buildRequestValuesTrait($method, $path, $payload, $headers);
        if ('PUT' === $response['method'] || 'POST' === $response['method']) {
            $response['headers']['Content-Type'] = 'Content-Type:application/json; charset=utf-8';
            $response['body'] = $this->getStreamFactory()->createStream(json_encode($payload));
        }
        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getHttpHeadersDefault()
    {
        if (empty($this->getApiKey())) {
            throw new Exception("HealthchecksDriver needs apiKey to perform requests");
        }
        return [
            self::AUTH_HEADER => $this->apiKey,
        ];
    }

    /**
     * @return string
     */
    protected function getIdentifier()
    {
        return scheduler()->getIdentifier();
    }

    /**
     * @inheritDoc
     */
    protected function generateBaseUri(): string
    {
        return self::BASE_URI;
    }
}