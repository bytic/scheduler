<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

/**
 * Trait HasHttpClient
 * @package Bytic\Scheduler\Pinger\Drivers\Traits
 */
trait HasHttpClient
{
    /**
     * @var null|HttpClient
     */
    protected $client = null;

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = HttpClientDiscovery::find();
        }
        return $this->client;
    }

    /**
     * @param HttpClient $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @param $url
     */
    public function pingUrl($url)
    {
        $this->getClient()->get($url);
    }
}