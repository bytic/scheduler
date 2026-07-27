<?php

namespace Bytic\Scheduler\Drivers\Traits;

/**
 * Trait HasPauseStateTrait
 *
 * Stores the pause state of events for a driver using a JSON file on disk.
 * Each driver uses a separate file keyed by its class name.
 *
 * @package Bytic\Scheduler\Drivers\Traits
 */
trait HasPauseStateTrait
{
    /**
     * Mark an event as paused.
     *
     * @param string $eventIdentifier
     * @return void
     */
    public function pause(string $eventIdentifier): void
    {
        $paused = $this->getPausedIdentifiers();
        if (!in_array($eventIdentifier, $paused, true)) {
            $paused[] = $eventIdentifier;
        }
        $this->savePausedIdentifiers($paused);
    }

    /**
     * Resume a previously paused event.
     *
     * @param string $eventIdentifier
     * @return void
     */
    public function resume(string $eventIdentifier): void
    {
        $paused = $this->getPausedIdentifiers();
        $paused = array_values(array_filter($paused, static fn($id) => $id !== $eventIdentifier));
        $this->savePausedIdentifiers($paused);
    }

    /**
     * Check whether an event is currently paused.
     *
     * @param string $eventIdentifier
     * @return bool
     */
    public function isPaused(string $eventIdentifier): bool
    {
        return in_array($eventIdentifier, $this->getPausedIdentifiers(), true);
    }

    /**
     * Return all paused event identifiers for this driver.
     *
     * @return string[]
     */
    public function getPausedIdentifiers(): array
    {
        $file = $this->getPauseStateFile();
        if (!is_file($file)) {
            return [];
        }
        $data = json_decode((string) file_get_contents($file), true);
        return is_array($data) ? $data : [];
    }

    /**
     * Persist the list of paused identifiers.
     *
     * @param string[] $identifiers
     * @return void
     */
    protected function savePausedIdentifiers(array $identifiers): void
    {
        $file = $this->getPauseStateFile();
        $dir  = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($identifiers), JSON_PRETTY_PRINT));
    }

    /**
     * Path to the JSON file that stores the paused state for this driver.
     * Sub-classes may override this to customise the storage location.
     *
     * @return string
     */
    protected function getPauseStateFile(): string
    {
        $name = str_replace('\\', '_', static::class);
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'scheduler_pause_' . $name . '.json';
    }
}
