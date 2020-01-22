<?php

namespace Bytic\Scheduler\Runner;

/**
 * Class Invoker
 * @package Bytic\Scheduler\Runner
 */
class Invoker
{
    /**
     * Call the given Closure with buffering support.
     *
     * @param callable $closure
     * @param bool $buffer
     * @param array<mixed,mixed> $parameters
     *
     * @return mixed
     */
    public static function call($closure, array $parameters = [], $buffer = false)
    {
        if ($buffer) {
            \ob_start();
        }
        $result = \call_user_func_array($closure, $parameters);
        if ($buffer) {
            return \ob_get_clean();
        }
        return $result;
    }
}
