<?php

namespace Bytic\Scheduler;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use Bytic\Scheduler\Console\ListCommand;
use Bytic\Scheduler\Console\PublishCommand;
use Bytic\Scheduler\Console\RunEventCommand;
use Bytic\Scheduler\Drivers\CrontabDriver;

/**
 * Class SchedulerServiceProvider
 * @package Bytic\Scheduler
 */
class SchedulerServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'scheduler';

    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();
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
        $this->getContainer()->share('scheduler', function () {
            $scheduler = $this->getContainer()->get(Scheduler::class);
            return $scheduler;
        });
    }

    protected function registerCrontabDriver()
    {
        $this->getContainer()->share(CrontabDriver::class, function () {
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
            ListCommand::class,
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
