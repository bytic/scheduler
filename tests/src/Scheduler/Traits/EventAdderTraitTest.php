<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Exception\InvalidArgumentException;
use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class EventAdderTraitTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class EventAdderTraitTest extends AbstractTest
{
    protected $scheduler;

    public function test_php_with_full_path()
    {
        $events = $this->scheduler->getEvents();
        $this->scheduler->php(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'test_script.php');

        $event = $events->current();
        self::assertStringContainsString('bin', $event->getCommand());
        self::assertStringContainsString('test_script.php', $event->getCommand());
    }

    public function test_php_with_directory()
    {
        $events = $this->scheduler->getEvents();
        $this->scheduler->php('test_script.php')->in(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'crons');

        $event = $events->current();
        self::assertStringContainsString('bin', $event->getCommand());
        self::assertStringContainsString('test_script.php', $event->getCommand());
    }

    public function test_php_invalid_path()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->scheduler->php('/crons/test_script.php');
    }

    public function test_run_with_params()
    {
        $events = $this->scheduler->getEvents();

        $this->scheduler->run('/bin/apache restart')->hourly();

        $event = $events->current();
        self::assertStringContainsString('/bin/apache restart', $event->getCommand());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->scheduler = new Scheduler();
        $this->scheduler->setEvents(new EventCollection());
    }
}
