<?php

namespace Bytic\Scheduler\Drivers;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use DateTimeImmutable;

/**
 * Class DatabaseDriver
 *
 * Publishes scheduled events to a database table for execution
 * by the internal database task runner.
 *
 * @package Bytic\Scheduler\Drivers
 */
class DatabaseDriver extends AbstractDriver
{
    /**
     * The database connection or PDO instance.
     *
     * @var \PDO|object|null
     */
    protected $connection = null;

    /**
     * The name of the scheduled tasks table.
     *
     * @var string
     */
    protected $table = 'scheduled_tasks';

    /**
     * @param \PDO|object|null $connection
     */
    public function __construct($connection = null)
    {
        $this->connection = $connection;
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
     * Publish the event collection to the database.
     *
     * @param EventCollection $collection
     * @return void
     */
    public function publish(EventCollection $collection): void
    {
        if ($this->connection === null) {
            return;
        }

        foreach ($collection as $event) {
            $this->upsertEvent($event);
        }
    }

    public function isInstalled(string $eventIdentifier): bool
    {
        if ($this->connection === null) {
            return false;
        }

        return $this->recordExists($eventIdentifier);
    }

    /**
     * Insert or update an event in the database.
     *
     * @param Event $event
     * @return void
     */
    protected function upsertEvent(Event $event): void
    {
        $data = $this->buildRecordFromEvent($event);
        $identifier = $event->getIdentifier();

        if ($this->recordExists($identifier)) {
            $this->updateRecord($identifier, $data);
        } else {
            $this->insertRecord($data);
        }
    }

    /**
     * Build a database record array from an event.
     *
     * @param Event $event
     * @return array<string, mixed>
     */
    protected function buildRecordFromEvent(Event $event): array
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $runAt = $event->getRunAt() ? $event->getRunAt()->format('Y-m-d H:i:s') : null;

        return [
            'identifier'               => $event->getIdentifier(),
            'name'                     => $event->getSummaryForDisplay(),
            'command'                  => $event->getCommand(),
            'expression'               => $event->isOneTimeEvent() ? null : $event->getExpression(),
            'run_at'                   => $runAt,
            'status'                   => 'pending',
            'attempts'                 => $event->getAttempts(),
            'max_attempts'             => $event->getMaxAttempts(),
            'reschedule_after_seconds' => $event->getRescheduleAfterSeconds(),
            'last_run_at'              => null,
            'created_at'               => $now,
            'updated_at'               => $now,
        ];
    }

    /**
     * Check if a record with the given identifier already exists.
     *
     * @param string $identifier
     * @return bool
     */
    protected function recordExists(string $identifier): bool
    {
        $connection = $this->connection;
        $table = $this->table;

        if ($connection instanceof \PDO) {
            $stmt = $connection->prepare("SELECT COUNT(*) FROM {$table} WHERE identifier = ?");
            $stmt->execute([$identifier]);
            return (int) $stmt->fetchColumn() > 0;
        }

        // Support for framework-style query builders (e.g. Laravel/Nip)
        if (method_exists($connection, 'table')) {
            return $connection->table($table)
                ->where('identifier', $identifier)
                ->exists();
        }

        return false;
    }

    /**
     * Insert a new record.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    protected function insertRecord(array $data): void
    {
        $connection = $this->connection;
        $table = $this->table;

        if ($connection instanceof \PDO) {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $stmt = $connection->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
            $stmt->execute(array_values($data));
            return;
        }

        if (method_exists($connection, 'table')) {
            $connection->table($table)->insert($data);
        }
    }

    /**
     * Update an existing record (non-status fields only).
     *
     * @param string $identifier
     * @param array<string, mixed> $data
     * @return void
     */
    protected function updateRecord(string $identifier, array $data): void
    {
        $connection = $this->connection;
        $table = $this->table;

        // Only update metadata, not status/attempts that are managed by the runner
        $updateData = [
            'name'                     => $data['name'],
            'command'                  => $data['command'],
            'expression'               => $data['expression'],
            'max_attempts'             => $data['max_attempts'],
            'reschedule_after_seconds' => $data['reschedule_after_seconds'],
            'updated_at'               => $data['updated_at'],
        ];

        // Only update run_at for one-time events if not yet run
        if ($data['run_at'] !== null) {
            $updateData['run_at'] = $data['run_at'];
            $updateData['status'] = 'pending';
            $updateData['attempts'] = 0;
        }

        if ($connection instanceof \PDO) {
            $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($updateData)));
            $stmt = $connection->prepare("UPDATE {$table} SET {$set} WHERE identifier = ?");
            $stmt->execute([...array_values($updateData), $identifier]);
            return;
        }

        if (method_exists($connection, 'table')) {
            $connection->table($table)
                ->where('identifier', $identifier)
                ->update($updateData);
        }
    }
}
