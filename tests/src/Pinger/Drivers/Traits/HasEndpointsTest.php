<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers\Traits;

use Bytic\Scheduler\Tests\AbstractTest;
use Bytic\Scheduler\Tests\Fixtures\Pinger\Drivers\GenericApiDriver;

/**
 * Class HasEndpointsTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers\Traits
 */
class HasEndpointsTest extends AbstractTest
{
    public function test_request_get()
    {
        $driver = new GenericApiDriver();
        $response = $driver->request('GET', '/api/users/2');

        self::assertIsArray($response);
        self::assertArrayHasKey('data', $response);
    }

    public function test_request_post()
    {
        $driver = new GenericApiDriver();
        $response = $driver->request('POST', '/api/users', ["name" => "John", "job" => "DEV"]);

        self::assertIsArray($response);
        self::assertArrayHasKey('name', $response);
        self::assertSame('John', $response['name']);
    }
}