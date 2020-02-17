<?php

namespace Bytic\Scheduler;

use Bytic\Scheduler\Console\PublishCommand;
use Bytic\Scheduler\Console\RunEventCommand;
use Bytic\Scheduler\Drivers\CrontabDriver;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

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
        $this->registerCrontabDriver();
    }

    /**
     * Register the queue manager.
     *
     * @return void
     */
    protected function registerScheduler()
    {
        $this->getContainer()->singleton('scheduler', function () {
            $scheduler = $this->getContainer()->get(Scheduler::class);
            return $scheduler;
        });
    }

    protected function registerCrontabDriver()
    {
        $this->getContainer()->singleton(CrontabDriver::class, function () {
            $driver = new CrontabDriver();
            $driver->getCrontab()->setIdentifier(
                $this->getContainer()->get('scheduler')->getIdentifier()
            );
            return $driver;
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
