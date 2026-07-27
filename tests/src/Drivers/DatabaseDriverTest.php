<?php

namespace Bytic\Scheduler\Tests\Drivers;

use Bytic\Scheduler\Drivers\DatabaseDriver;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventCollection;
use Bytic\Scheduler\Tests\AbstractTest;
use DateTimeImmutable;

/**
 * Class DatabaseDriverTest
 * @package Bytic\Scheduler\Tests\Drivers
 */
class DatabaseDriverTest extends AbstractTest
{
    public function test_publish_without_connection_does_nothing()
    {
        $driver = new DatabaseDriver(null);
        $events = new EventCollection();
        $events->add(new Event('php foo'));

        // Should not throw
        $driver->publish($events);

        self::assertNull($driver->getConnection());
    }

    public function test_setTable_and_getTable()
    {
        $driver = new DatabaseDriver();

        self::assertEquals('scheduled_tasks', $driver->getTable());

        $driver->setTable('custom_tasks');
        self::assertEquals('custom_tasks', $driver->getTable());
    }

    public function test_setConnection_and_getConnection()
    {
        $driver = new DatabaseDriver();

        self::assertNull($driver->getConnection());

        $pdo = $this->createSqliteConnection();
        $driver->setConnection($pdo);

        self::assertSame($pdo, $driver->getConnection());
    }

    public function test_publish_inserts_recurring_event()
    {
        $pdo = $this->createSqliteConnection();
        $this->createTable($pdo);

        $driver = new DatabaseDriver($pdo);
        $driver->setTable('scheduled_tasks');

        $event = new Event('php artisan queue:work');
        $event->everyMinute();

        $events = new EventCollection();
        $events->add($event);

        $driver->publish($events);

        $stmt = $pdo->query("SELECT * FROM scheduled_tasks");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        self::assertCount(1, $rows);
        self::assertEquals($event->getIdentifier(), $rows[0]['identifier']);
        self::assertEquals('* * * * *', $rows[0]['expression']);
        self::assertNull($rows[0]['run_at']);
        self::assertEquals('pending', $rows[0]['status']);
    }

    public function test_publish_inserts_one_time_event()
    {
        $pdo = $this->createSqliteConnection();
        $this->createTable($pdo);

        $driver = new DatabaseDriver($pdo);

        $runAt = new DateTimeImmutable('2030-01-01 12:00:00');
        $event = new Event('php notify.php');
        $event->runOnce($runAt);

        $events = new EventCollection();
        $events->add($event);

        $driver->publish($events);

        $stmt = $pdo->query("SELECT * FROM scheduled_tasks");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        self::assertCount(1, $rows);
        self::assertEquals($event->getIdentifier(), $rows[0]['identifier']);
        self::assertNull($rows[0]['expression']);
        self::assertEquals('2030-01-01 12:00:00', $rows[0]['run_at']);
        self::assertEquals('pending', $rows[0]['status']);
    }

    public function test_publish_updates_existing_event()
    {
        $pdo = $this->createSqliteConnection();
        $this->createTable($pdo);

        $driver = new DatabaseDriver($pdo);

        $event = new Event('php foo');
        $events = new EventCollection();
        $events->add($event);

        // First publish: insert
        $driver->publish($events);

        $stmt = $pdo->query("SELECT COUNT(*) FROM scheduled_tasks");
        self::assertEquals(1, (int) $stmt->fetchColumn());

        // Second publish: update (same identifier)
        $driver->publish($events);

        $stmt = $pdo->query("SELECT COUNT(*) FROM scheduled_tasks");
        self::assertEquals(1, (int) $stmt->fetchColumn());
    }

    public function test_isInstalled_returnsFalseWithoutConnection()
    {
        $driver = new DatabaseDriver(null);

        self::assertFalse($driver->isInstalled('event-1'));
    }

    public function test_isInstalled_returnsFalseForMissingRecord()
    {
        $pdo = $this->createSqliteConnection();
        $this->createTable($pdo);

        $driver = new DatabaseDriver($pdo);

        self::assertFalse($driver->isInstalled('event-1'));
    }

    public function test_isInstalled_returnsTrueForExistingRecord()
    {
        $pdo = $this->createSqliteConnection();
        $this->createTable($pdo);

        $driver = new DatabaseDriver($pdo);
        $event = new Event('php foo');
        $events = new EventCollection();
        $events->add($event);
        $driver->publish($events);

        self::assertTrue($driver->isInstalled($event->getIdentifier()));
    }

    /**
     * Create a SQLite in-memory PDO connection for testing.
     */
    private function createSqliteConnection(): \PDO
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * Create the scheduled_tasks table in SQLite.
     */
    private function createTable(\PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS scheduled_tasks (
                id                        INTEGER PRIMARY KEY AUTOINCREMENT,
                identifier                TEXT NOT NULL UNIQUE,
                name                      TEXT NOT NULL DEFAULT '',
                command                   TEXT NOT NULL,
                expression                TEXT NULL,
                run_at                    TEXT NULL,
                status                    TEXT NOT NULL DEFAULT 'pending',
                attempts                  INTEGER NOT NULL DEFAULT 0,
                max_attempts              INTEGER NOT NULL DEFAULT 1,
                reschedule_after_seconds  INTEGER NOT NULL DEFAULT 300,
                last_run_at               TEXT NULL,
                created_at                TEXT NOT NULL,
                updated_at                TEXT NOT NULL
            )
        ");
    }
}
