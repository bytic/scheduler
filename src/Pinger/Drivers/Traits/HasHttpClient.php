<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

use Http\Client\HttpClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
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
     * @var StreamFactory
     */
    protected $streamFactory;

    /**
     * @return HttpClient|ClientInterface
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = Psr18ClientDiscovery::find();
        }
        return $this->client;
    }

    /**
     * @param HttpClient|ClientInterface $client
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

    /**
     * @return StreamFactoryInterface|StreamFactory
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }
        return $this->streamFactory;
    }

    /**
     * @param StreamFactoryInterface|StreamFactory $streamFactory
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): void
    {
        $this->streamFactory = $streamFactory;
    }
}
