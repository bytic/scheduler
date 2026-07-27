<?php

namespace Bytic\Scheduler\Console;

use ByTIC\Console\Command;
use Bytic\Scheduler\Runner\DatabaseTaskRunner;
use Bytic\Scheduler\Utility\PackageConfig;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunDatabaseCommand
 *
 * Runs all scheduled tasks that are due according to the database driver.
 * Handles both recurring tasks (cron expression) and one-time events.
 *
 * @package Bytic\Scheduler\Console
 */
class RunDatabaseCommand extends Command
{
    /**
     * @var DatabaseTaskRunner
     */
    protected $runner;

    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('schedule:run-database')
            ->setDescription('Runs all scheduled database tasks that are currently due')
            ->setHelp(
                'This command queries the database for scheduled tasks that are due to run ' .
                '(either by cron expression or specific run_at datetime) and executes them. ' .
                'Failed one-time events will be rescheduled if retry attempts remain.'
            );
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $runner = $this->getRunner();
        $runner->handle($output);
        return 0;
    }

    /**
     * @return DatabaseTaskRunner
     */
    protected function getRunner(): DatabaseTaskRunner
    {
        if ($this->runner === null) {
            $connection = $this->resolveConnection();
            $table = PackageConfig::instance()->get('database.table', 'scheduled_tasks');
            $this->runner = new DatabaseTaskRunner($connection, $table);
        }
        return $this->runner;
    }

    /**
     * @param DatabaseTaskRunner $runner
     */
    public function setRunner(DatabaseTaskRunner $runner): void
    {
        $this->runner = $runner;
    }

    /**
     * Resolve the database connection from the container or config.
     *
     * @return \PDO|object|null
     */
    protected function resolveConnection()
    {
        // Try framework container first
        if (function_exists('app')) {
            try {
                return app('db');
            } catch (\Throwable $e) {
                // Fall through
            }
        }

        if (class_exists(\Nip\Container\Container::class)) {
            try {
                $container = \Nip\Container\Container::getInstance();
                if ($container instanceof \Nip\Container\Container) {
                    if ($container->has('db')) {
                        return $container->get('db');
                    }
                    if ($container->has(\PDO::class)) {
                        return $container->get(\PDO::class);
                    }
                }
            } catch (\Throwable $e) {
                // Fall through
            }
        }

        return null;
    }
}
