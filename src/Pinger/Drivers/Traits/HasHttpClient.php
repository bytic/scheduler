<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

use Http\Client\HttpClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\UriFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

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
     * @var null|RequestFactoryInterface
     */
    protected $requestFactory = null;

    /**
     * @var null|UriFactory|UriFactoryInterface
     */
    protected $uriFactory = null;

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = Psr18ClientDiscovery::find();
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

    protected function send(string $method, $uri, array $headers = [], $body = null)
    {

    }

    /**
     * @return RequestFactoryInterface |null
     */
    public function getRequestFactory(): ?RequestFactoryInterface
    {
        if ($this->requestFactory === null) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }
        return $this->requestFactory;
    }

    /**
     * @param RequestFactoryInterface $requestFactory
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): void
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * @return UriFactoryInterface
     */
    protected function getUriFactory(): UriFactoryInterface
    {
        if (null === $this->uriFactory) {
            $this->uriFactory = Psr17FactoryDiscovery::findUrlFactory();
        }

        return $this->uriFactory;
    }
}