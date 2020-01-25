<?php

namespace Bytic\Scheduler\Tests\Pinger\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Pinger\Drivers\HealthchecksDriver;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;
use Http\Discovery\Psr17FactoryDiscovery;
use Nip\Container\Container;

/**
 * Class HealthchecksDriverTest
 * @package Bytic\Scheduler\Tests\Pinger\Drivers
 */
class HealthchecksDriverTest extends AbstractTest
{
    public function test_getChecks()
    {
        $driver = $this->newHealthchecksDriverMock();
        $driver->shouldReceive('executeRequest')
            ->andReturn($this->newResponse(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/checks.json')));

        $checks = $driver->getChecks();
        self::assertIsArray($checks);
        self::assertCount(2, $checks);
    }

    public function test_createCheckForEvent()
    {
        $event = new Event('php foe');
        $event->description('my cron desc');

        $scheduler = new Scheduler();
        $scheduler->setIdentifier('MYSC');
        Container::getInstance()->set('scheduler', $scheduler);

        $driver = $this->newHealthchecksDriverMock();
        $driver->shouldReceive('request')
            ->with('POST', \Mockery::any(), \Mockery::on(function ($data) {
                if (!is_array($data)) {
                    return false;
                }
                if ($data['name'] != 'MYSC # php foe') {
                    return false;
                }
                if ($data['tags'] != 'MYSC') {
                    return false;
                }
                return true;
            }))
            ->andReturn(json_decode(file_get_contents(TEST_FIXTURE_PATH . '/Pinger/Drivers/Healthchecks/create.json'), true));


        $response = $driver->createCheckForEvent($event);

        self::assertIsArray($response);
        self::assertArrayHasKey('desc', $response);
        self::assertArrayHasKey('update_url', $response);
    }

    /**
     * @return HealthchecksDriver|\Mockery\MockInterface
     */
    protected function newHealthchecksDriverMock()
    {
        /** @var HealthchecksDriver|\Mockery\MockInterface $driver */
        $driver = \Mockery::mock(HealthchecksDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $driver->populateFromConfig(['apiKey' => getenv('HEALTHCHECKS_API')]);
        return $driver;
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
