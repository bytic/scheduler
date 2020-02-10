<?php

namespace Bytic\Scheduler\Tests\Fixtures\Pinger\Drivers;

use Bytic\Scheduler\Pinger\Drivers\Traits\isApiDriver;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GenericApiDriver
 * @package Bytic\Scheduler\Tests\Fixtures\Pinger\Drivers
 */
class GenericApiDriver
{
    use isApiDriver;

    /**
     * @inheritDoc
     */
    protected function generateBaseUri(): string
    {
        return 'https://reqres.in';
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody(), true);
    }
}