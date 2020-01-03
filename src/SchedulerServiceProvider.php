<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Console\RegisterCommand;
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
        $this->commands(RegisterCommand::class);
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['scheduler'];
    }
}
