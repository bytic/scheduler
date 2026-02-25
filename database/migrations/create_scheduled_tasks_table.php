<?php

/**
 * Migration: create_scheduled_tasks_table
 *
 * Creates the database table used by the DatabaseDriver to store scheduled tasks.
 *
 * Usage with raw PDO:
 *   $pdo->exec(file_get_contents(__FILE__)); // Not applicable - use the class below
 *
 * Usage via framework migration runners:
 *   Implement up()/down() in your framework's migration mechanism.
 */

/**
 * SQL schema for the scheduled_tasks table (MySQL/MariaDB dialect).
 *
 * For other databases, adjust column types as needed:
 *   - PostgreSQL: use SERIAL instead of INT AUTO_INCREMENT, BOOLEAN for tinyint(1)
 *   - SQLite: use INTEGER PRIMARY KEY AUTOINCREMENT
 */
return [
    'up' => "
        CREATE TABLE IF NOT EXISTS `scheduled_tasks` (
            `id`                        INT UNSIGNED    NOT NULL AUTO_INCREMENT,
            `identifier`                VARCHAR(64)     NOT NULL,
            `name`                      VARCHAR(255)    NOT NULL DEFAULT '',
            `command`                   TEXT            NOT NULL,
            `expression`                VARCHAR(100)    NULL     DEFAULT NULL COMMENT 'Cron expression for recurring tasks; NULL for one-time tasks',
            `run_at`                    DATETIME        NULL     DEFAULT NULL COMMENT 'Specific datetime for one-time tasks',
            `status`                    ENUM('pending','running','completed','failed')
                                                        NOT NULL DEFAULT 'pending',
            `attempts`                  SMALLINT        NOT NULL DEFAULT 0,
            `max_attempts`              SMALLINT        NOT NULL DEFAULT 1,
            `reschedule_after_seconds`  INT             NOT NULL DEFAULT 300,
            `last_run_at`               DATETIME        NULL     DEFAULT NULL,
            `created_at`                DATETIME        NOT NULL,
            `updated_at`                DATETIME        NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uq_scheduled_tasks_identifier` (`identifier`),
            KEY `idx_scheduled_tasks_status_run_at` (`status`, `run_at`),
            KEY `idx_scheduled_tasks_status_expression` (`status`, `expression`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'down' => "DROP TABLE IF EXISTS `scheduled_tasks`;",
];
