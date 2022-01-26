<?php

namespace Bytic\Scheduler\Scheduler\Traits;

use ByTIC\Console\Application;
use ByTIC\Console\Support\ProcessUtils;
use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Exception\InvalidArgumentException;
use Bytic\Scheduler\Utility\PhpBinary;
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
            Application::formatCommandString($command),
            $parameters
        );
    }

    /**
     * Queues a php script execution.
     *
     * @param string $script The path to the php script to execute
     * @param array $parameters
     * @return EventAdder
     */
    public function php($script, array $parameters = [], $bin = null)
    {
        if (!is_string($script)) {
            throw new InvalidArgumentException('The script parameter is not a string.');
        }

        $bin = PhpBinary::get($bin);
        $command = $bin . ' ' . $script;

        $adder = $this->exec($command, $parameters);
        $adder->after(function (Event $event) use ($script) {
            $cwd = $event->getWorkingDirectory();
            $path = $cwd ? $cwd . DIRECTORY_SEPARATOR : '';
            $path .= $script;

            if (!file_exists($path)) {
                throw new InvalidArgumentException('The script should be a valid path to a file.');
            }
        });
        return $adder;
    }

    /**
     * @param $script
     * @param array $parameters
     * @return EventAdder
     */
    public function php74($script, array $parameters = []): EventAdder
    {
        return $this->php($script, $parameters, PhpBinary::PHP_7_4);
    }

    /**
     * @param $script
     * @param array $parameters
     * @return EventAdder
     */
    public function php80($script, array $parameters = []): EventAdder
    {
        return $this->php($script, $parameters, PhpBinary::PHP_8_0);
    }

    /**
     * @param $script
     * @param array $parameters
     * @return EventAdder
     */
    public function php81($script, array $parameters = []): EventAdder
    {
        return $this->php($script, $parameters, PhpBinary::PHP_8_1);
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
