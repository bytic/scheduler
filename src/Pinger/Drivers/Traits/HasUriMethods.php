<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

/**
 * Trait HasUriMethods
 * @package Bytic\Scheduler\Pinger\Drivers\Traits
 */
trait HasUriMethods
{
    /** @var string */
    protected $baseUri = null;


    /**
     * @param string $path
     * @param null $query
     * @return mixed
     */
    public function generateFullUri($path = '/', $query = null)
    {
        $uri = $this->getUriFactory()
            ->createUri(sprintf('%s' . $path, $this->getBaseUri()));

        if (is_array($query)) {
            $query = implode('&', $this->buildQuery($query));
        }
        if (!empty($query)) {
            $uri = $uri->withQuery($query);
        }

        return $uri;
    }

    protected function buildQuery(array $queryParams = []): string
    {
        $queryParams = array_map(
            function (array $keyValue) {
                list($key, $value) = $keyValue;

                return sprintf('%s=%s', $key, urlencode($value));
            },
            $queryParams
        );

        return implode('&', $queryParams);
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        if ($this->baseUri === null) {
            $this->baseUri = $this->generateBaseUri();
        }
        return $this->baseUri;
    }

    /**
     * @param int $baseUri
     */
    public function setBaseUri(int $baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return string
     */
    abstract protected function generateBaseUri(): string;
}