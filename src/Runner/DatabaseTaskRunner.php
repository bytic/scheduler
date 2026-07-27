<?php

namespace Bytic\Scheduler\Runner;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use DateTimeImmutable;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseTaskRunner
 *
 * Searches for due tasks in the database and runs them.
 * Handles both recurring (cron expression) and one-time events.
 * Reschedules failed one-time events if retry attempts remain.
 *
 * @package Bytic\Scheduler\Runner
 */
class DatabaseTaskRunner
{
    /**
     * @var \PDO|object|null
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var EventRunner
     */
    protected $eventRunner;

    /**
     * @param \PDO|object|null $connection
     * @param string $table
     */
    public function __construct($connection = null, string $table = 'scheduled_tasks')
    {
        $this->connection  = $connection;
        $this->table       = $table;
        $this->eventRunner = new EventRunner();
    }

    /**
     * @return \PDO|object|null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param \PDO|object|null $connection
     */
    public function setConnection($connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Find and run all due tasks from the database.
     *
     * @param OutputInterface $output
     * @return void
     */
    public function handle(OutputInterface $output): void
    {
        if ($this->connection === null) {
            $output->writeln('<error>No database connection available for DatabaseTaskRunner.</error>');
            return;
        }

        $dueTasks = $this->fetchDueTasks();

        if (empty($dueTasks)) {
            $output->writeln('<info>No scheduled database tasks are due to run.</info>');
            return;
        }

        $collection = $this->buildEventCollection($dueTasks);

        if ($collection->count() === 0) {
            return;
        }

        // Mark tasks as running before execution
        foreach ($dueTasks as $task) {
            $this->markAsRunning((int) $task['id']);
        }

        // Run events and process results
        $this->runEvents($output, $collection, $dueTasks);
    }

    /**
     * Fetch all tasks that are due to run.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function fetchDueTasks(): array
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $connection = $this->connection;
        $table = $this->table;

        if ($connection instanceof \PDO) {
            $stmt = $connection->prepare(
                "SELECT * FROM {$table}
                 WHERE status IN ('pending', 'failed')
                   AND (
                     (expression IS NOT NULL)
                     OR (run_at IS NOT NULL AND run_at <= ? AND attempts < max_attempts)
                   )
                 ORDER BY run_at ASC, created_at ASC"
            );
            $stmt->execute([$now]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        }

        if (method_exists($connection, 'table')) {
            return $connection->table($table)
                ->whereIn('status', ['pending', 'failed'])
                ->where(function ($query) use ($now) {
                    $query->whereNotNull('expression')
                        ->orWhere(function ($q) use ($now) {
                            $q->whereNotNull('run_at')
                              ->where('run_at', '<=', $now)
                              ->whereRaw('attempts < max_attempts');
                        });
                })
                ->orderBy('run_at')
                ->orderBy('created_at')
                ->get()
                ->toArray();
        }

        return [];
    }

    /**
     * Build an EventCollection from fetched task records.
     *
     * @param array<int, array<string, mixed>> $tasks
     * @return EventCollection
     */
    protected function buildEventCollection(array $tasks): EventCollection
    {
        $collection = new EventCollection();

        foreach ($tasks as $task) {
            $event = $this->buildEventFromRecord($task);
            if ($event !== null) {
                $collection->add($event);
            }
        }

        return $collection;
    }

    /**
     * Build an Event from a database record.
     *
     * @param array<string, mixed> $task
     * @return Event|null
     */
    protected function buildEventFromRecord(array $task): ?Event
    {
        $command = $task['command'] ?? null;
        if (empty($command)) {
            return null;
        }

        $event = new Event($command);
        $event->setIdentifier($task['identifier']);

        if (!empty($task['expression'])) {
            $event->setExpression($task['expression']);
        }

        if (!empty($task['run_at'])) {
            $runAt = new DateTimeImmutable($task['run_at']);
            $event->setRunAt($runAt);
        }

        $event->setAttempts((int) ($task['attempts'] ?? 0));
        $event->withMaxAttempts((int) ($task['max_attempts'] ?? 1));
        $event->rescheduleAfter((int) ($task['reschedule_after_seconds'] ?? 300));

        return $event;
    }

    /**
     * Run events and update their database status after completion.
     *
     * @param OutputInterface $output
     * @param EventCollection $collection
     * @param array<int, array<string, mixed>> $tasks
     * @return void
     */
    protected function runEvents(OutputInterface $output, EventCollection $collection, array $tasks): void
    {
        // Build a map of identifier => task record for post-run updates
        $taskMap = [];
        foreach ($tasks as $task) {
            $taskMap[$task['identifier']] = $task;
        }

        // Run all events
        $this->eventRunner->handle($output, $collection);

        // Update database status based on results
        foreach ($collection as $event) {
            /** @var Event $event */
            $identifier = $event->getIdentifier();
            $task = $taskMap[$identifier] ?? null;

            if ($task === null) {
                continue;
            }

            $process = $event->getProcess();
            if ($process === null) {
                continue;
            }

            $taskId = (int) $task['id'];

            if ($process->isSuccessful()) {
                $this->markAsCompleted($taskId);
            } else {
                $this->handleFailure($taskId, $event);
            }
        }
    }

    /**
     * Mark a task as running.
     *
     * @param int $id
     * @return void
     */
    protected function markAsRunning(int $id): void
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $this->updateRecord($id, ['status' => 'running', 'last_run_at' => $now, 'updated_at' => $now]);
    }

    /**
     * Mark a task as completed.
     *
     * @param int $id
     * @return void
     */
    protected function markAsCompleted(int $id): void
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $this->updateRecord($id, ['status' => 'completed', 'last_run_at' => $now, 'updated_at' => $now]);
    }

    /**
     * Handle a failed event: reschedule or mark as failed.
     *
     * @param int $id
     * @param Event $event
     * @return void
     */
    protected function handleFailure(int $id, Event $event): void
    {
        $now = new DateTimeImmutable();
        $attempts = $event->getAttempts() + 1;

        if ($event->isOneTimeEvent() && $attempts < $event->getMaxAttempts()) {
            // Reschedule the one-time event
            $rescheduleAt = $now->modify('+' . $event->getRescheduleAfterSeconds() . ' seconds');
            $this->updateRecord($id, [
                'status'     => 'pending',
                'attempts'   => $attempts,
                'run_at'     => $rescheduleAt->format('Y-m-d H:i:s'),
                'last_run_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ]);
        } else {
            $this->updateRecord($id, [
                'status'     => 'failed',
                'attempts'   => $attempts,
                'last_run_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Update a task record by ID.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return void
     */
    protected function updateRecord(int $id, array $data): void
    {
        $connection = $this->connection;
        $table = $this->table;

        if ($connection instanceof \PDO) {
            $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
            $stmt = $connection->prepare("UPDATE {$table} SET {$set} WHERE id = ?");
            $stmt->execute([...array_values($data), $id]);
            return;
        }

        if (method_exists($connection, 'table')) {
            $connection->table($table)->where('id', $id)->update($data);
        }
    }
}
