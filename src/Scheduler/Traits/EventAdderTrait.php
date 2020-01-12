<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use ByTIC\Console\Application;
use ByTIC\Console\Support\ProcessUtils;
use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Exception\InvalidArgumentException;
use Nip\Container\Container;

/**
 * Trait EventAdderTrait
 * @package Bytic\Scheduler\Scheduler\Traits
 */
trait EventAdderTrait
{
    /**
     * Add a new Artisan command event to the schedule.
     *
     * @param string $command
     * @param array $parameters
     * @return EventAdder
     */
    public function command($command, array $parameters = [])
    {
        if (class_exists($command)) {
            $command = Container::getInstance()->get($command)->getName();
        }
        return $this->exec(
            Application::formatCommandString($command), $parameters
        );
    }

    /**
     * Queues a php script execution.
     *
     * @param string $script The path to the php script to execute
     * @param array $parameters
     * @return EventAdder
     */
    public function php($script, array $parameters = [])
    {
        if (!is_string($script)) {
            throw new InvalidArgumentException('The script parameter is not a string.');
        }
        $bin = Application::phpBinary();
        $command = $bin . ' ' . $script;

        if (!file_exists($script)) {
            throw new InvalidArgumentException('The script should be a valid path to a file.');
        }
        return $this->exec($command, $parameters);
    }

    /**
     * @param $command
     * @param array $parameters
     * @return EventAdder
     */
    public function run($command, array $parameters = [])
    {
        return $this->exec($command, $parameters);
    }

    /**
     * Add a new command event to the schedule.
     *
     * @param string $command
     * @param array $parameters
     * @return EventAdder
     */
    public function exec($command, array $parameters = [])
    {
//        if (count($parameters)) {
//            $command .= ' ' . $this->compileParameters($parameters);
//        }
        return new EventAdder($this, $command);
    }

    /**
     * Compile parameters for a command.
     *
     * @param array $parameters
     * @return string
     */
    protected function compileParameters(array $parameters)
    {
        return collect($parameters)->map(function ($value, $key) {
            if (is_array($value)) {
                $value = collect($value)->map(function ($value) {
                    return ProcessUtils::escapeArgument($value);
                })->implode(' ');
            } elseif (!is_numeric($value) && !preg_match('/^(-.$|--.*)/i', $value)) {
                $value = ProcessUtils::escapeArgument($value);
            }
            return is_numeric($key) ? $value : "{$key}={$value}";
        })->implode(' ');
    }
}