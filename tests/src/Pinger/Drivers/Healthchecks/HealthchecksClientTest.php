<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers\Healthchecks;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Healthchecks\HealthchecksClient;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;
use Http\Discovery\Psr17FactoryDiscovery;
use Nip\Container\Container;

/**
 * Class HealthchecksClientTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers\Healthchecks
 */
class HealthchecksClientTest extends AbstractTest
{
    public function test_deleteChecks()
    {
        $driver = $this->newHealthchecksClientMock();
        $driver->shouldReceive('executeRequest')
            ->andReturn($this->newResponse(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/checks.json')));

        $driver->shouldReceive('request')->with('DELETE',
            'https://healthchecks.io/api/v1/checks/076cf545-9999-9999-9999-999999999999');

        $driver->deleteChecks();
    }

    public function test_getChecks()
    {
        $driver = $this->newHealthchecksClientMock();
        $driver->shouldReceive('executeRequest')
            ->andReturn($this->newResponse(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/checks.json')));

        $checks = $driver->getChecks();
        self::assertIsArray($checks);
        self::assertCount(1, $checks);
    }

    public function test_createCheckForEvent()
    {
        $event = new Event('php foe');
        $event->description('my cron desc');

        $scheduler = new Scheduler();
        $scheduler->setIdentifier('bytic');
        Container::getInstance()->set('scheduler', $scheduler);

        $driver = $this->newHealthchecksClientMock();
        $driver->shouldReceive('request')
            ->with('POST', \Mockery::any(), \Mockery::on(function ($data) {
                if (!is_array($data)) {
                    return false;
                }
                if ($data['name'] != 'bytic # php foe') {
                    return false;
                }
                if ($data['tags'] != 'bytic') {
                    return false;
                }
                return true;
            }))
            ->andReturn(json_decode(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/create.json'),
                true));


        $response = $driver->createCheckForEvent($event);

        self::assertIsArray($response);
        self::assertCount(13, $response);
        self::assertArrayHasKey('desc', $response);
        self::assertArrayHasKey('update_url', $response);
    }


    /**
     * @return HealthchecksClient|\Mockery\MockInterface
     */
    protected function newHealthchecksClientMock()
    {
        /** @var HealthchecksClient|\Mockery\MockInterface $client */
        $client = \Mockery::mock(HealthchecksClient::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $client->shouldReceive('getIdentifier')->andReturn('bytic');

        $apiKey = getenv('HEALTHCHECKS_API');
        $client->populateFromConfig(['apiKey' => $apiKey ? $apiKey : '9999']);
        return $client;
    }

    /**
     * @param $content
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function newResponse($content)
    {
        return Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($content));
    }
}
