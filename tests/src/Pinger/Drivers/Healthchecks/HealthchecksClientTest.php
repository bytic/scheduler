<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers\Healthchecks;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\Healthchecks\HealthchecksClient;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;
use Http\Discovery\Psr17FactoryDiscovery;
use Mockery;
use Mockery\MockInterface;
use Nip\Container\Container;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HealthchecksClientTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers\Healthchecks
 */
class HealthchecksClientTest extends AbstractTest
{
    public function test_deleteChecks()
    {
        $driver = $this->newHealthchecksClientMock();
        $driver
            ->shouldReceive('executeRequest')
            ->once()
            ->andReturn($this->newResponse(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/checks.json')));

        $driver->shouldReceive('request')->with(
            'DELETE',
            'https://healthchecks.io/api/v1/checks/076cf545-9999-9999-9999-999999999999'
        );

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


    public function test_setEndpointFromConfig()
    {
        $driver = $this->newHealthchecksClientMock();
        self::assertSame('https://healthchecks.io', $driver->getBaseUri());

        $driver = $this->newHealthchecksClientMock();
        $driver->populateFromConfig(['endpoint' => 'https://health.sportic.ro']);
        self::assertSame('https://health.sportic.ro', $driver->getBaseUri());
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
            ->with('POST', Mockery::any(), Mockery::on(function ($data) {
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
            ->andReturn(json_decode(
                file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/create.json'),
                true
            ));


        $response = $driver->createCheckForEvent($event);

        self::assertIsArray($response);
        self::assertGreaterThanOrEqual(13, count($response));
        self::assertArrayHasKey('desc', $response);
        self::assertArrayHasKey('update_url', $response);
    }


    /**
     * @return HealthchecksClient|MockInterface
     */
    protected function newHealthchecksClientMock()
    {
        /** @var HealthchecksClient|MockInterface $client */
        $client = Mockery::mock(HealthchecksClient::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $client->shouldReceive('getIdentifier')->andReturn('bytic');

        $apiKey = getenv('HEALTHCHECKS_API');
        $client->populateFromConfig(['apiKey' => $apiKey ? $apiKey : '9999']);
        return $client;
    }

    /**
     * @param $content
     * @return ResponseInterface
     */
    protected function newResponse($content)
    {
        return Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($content));
    }
}
