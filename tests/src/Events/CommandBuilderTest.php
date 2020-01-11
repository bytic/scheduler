<?php

namespace Bytic\Scheduler\Tests\Events;

use Bytic\Scheduler\Events\CommandBuilder;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CommandBuilderTest
 * @package Bytic\Scheduler\Tests\Events
 */
class CommandBuilderTest extends AbstractTest
{
    public function test_buildCommand_simple()
    {
        $event = new Event('php foe');

        static::assertSame(
            'php foe',
            (new CommandBuilder())->buildCommand($event));
    }

    public function test_buildCommand_with_cwd()
    {
        $event = new Event('php foe');
        $event->in('/home/john');

        static::assertSame(
            'cd /home/john; php foe',
            (new CommandBuilder())->buildCommand($event)
        );
    }

    public function test_buildCommand_with_user()
    {
        $event = new Event('php foe');
        $event->user('john');

        static::assertSame(
            'sudo -u john php foe',
            (new CommandBuilder())->buildCommand($event)
        );
    }
}