<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Console\PublishCommand;
use Bytic\Scheduler\Console\RunEventCommand;
use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;

/**
 * Class SchedulerServiceProvider
 * @package Bytic\Scheduler
 */
class SchedulerServiceProvider extends AbstractSignatureServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerScheduler();
    }

    /**
     * Register the queue manager.
     *
     * @return void
     */
    protected function registerScheduler()
    {
        $this->getContainer()->singleton('scheduler', function () {
            $scheduler = new Scheduler();
            return $scheduler;
        });
    }

    protected function registerCommands()
    {
        $this->commands(
            PublishCommand::class,
            RunEventCommand::class
        );
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['scheduler'];
    }
}
